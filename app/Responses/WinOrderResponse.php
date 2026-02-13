<?php

namespace App\Responses;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class WinOrderResponse
{
    /**
     * EXACT empty response (matches old PHP)
     */
    public static function empty(): array
    {
        return [
            "OrderList" => [
                "Order" => [],
                "CreateDateTime" => now()->toRfc3339String(),
            ],
        ];
    }

    /**
     * Build FULL WinOrder response (1:1 with old API)
     */
    public static function make(Collection $orders, $vendor): array
    {
        if ($orders->isEmpty()) {
            return self::empty();
        }

        $responses = [];

        foreach ($orders as $order) {

            $items = $order->items ?? collect();

            $articleList = self::articles($items);
            $deliveryAddress = self::deliveryAddress($order);

            $totalAm = ($order->total_amount ?? 0) + ($order->discount ?? 0);

            $paymentMethod = ($order->payment_method ?? null) !== 'card_payment'
                ? $order->payment_method
                : 'EC-Karte';

            $responses[] = [
                "AddInfo" => [
                    "PaymentType" => $paymentMethod,
                    "DiscountPercent" =>
                        ($order->discount && $order->total_amount > 0)
                            ? (float) number_format(($order->discount / $totalAm) * 100, 2)
                            : 0,
                    "DeliverLumpSum" => (float) ($order->delivery_price ?? 0),
                    "Total" => (float) ($order->total_amount ?? 0),
                    "DateTimeOrder" => self::formatOrderTime($order->custome_time ?? null),
                    "Comment" => "Deine Bestellnummer : " . self::formatId($order->id),
                    "CurrencyStr" => "€",
                ],

                "OrderID" => $order->uid ?? null,

                "ArticleList" => [
                    "Article" => $articleList,
                ],

                "StoreData" => [
                    "StoreId" => $vendor->id ?? null,
                    "StoreName" => $vendor->name ?? null,
                ],

                "ServerData" => [
                    "Agent" => Request::header('User-Agent'),
                    "CreateDateTime" => now()->toRfc3339String(),
                    "Referer" => Request::header('Referer'),
                    "IpAddress" => Request::ip(),
                ],

                "Customer" => [
                    "DeliveryAddress" => $deliveryAddress,
                ],
            ];
        }

        return [
            "OrderList" => [
                "Order" => $responses,
                "CreateDateTime" => now()->toRfc3339String(),
            ],
        ];
    }

    /**
     * EXACT Article builder (matches old PDO logic)
     */
    private static function articles(Collection $items): array
    {
        return $items->map(function ($item) {

            $extras = json_decode($item->extras, true) ?? [];

            // EXACT old query:
            // SELECT * FROM food_items WHERE id = :food_id
            $food = DB::table('food_items')
                ->where('id', $item->food_id)
                ->first();

            return [
                "Price" => (float) $item->price,
                "ArticleSize" => $item->variant ?? null,
                "ArticleName" => $item->food_item_name ?? null,
                "ArticleNo" => $food->external_id ?? null,
                "SubArticleList" => [
                    "SubArticle" => collect($extras)->map(function ($extra) {
                        return [
                            "Comment" => $extra['info'] ?? null,
                            "Price" => (float) ($extra['price'] ?? null),
                            "Count" => 1,
                            "ArticleName" => $extra['name'] ?? null,
                        ];
                    })->values()->all(),
                ],
                "Count" => $item->quantity ?? 1,
                "Comment" => $item->extra_note ?? null,
            ];
        })->values()->all();
    }

    /**
     * EXACT DeliveryAddress formatter
     */
    private static function deliveryAddress($order): array
    {
        $delivery = json_decode($order->address ?? '', true) ?? [];
        $receiver = json_decode($order->food_receiver ?? '', true) ?? [];

        return [
            "LastName" => $receiver['last_name'] ?? null,
            "AddAddress" => $delivery['additional_address'] ?? null,
            "Company" => $delivery['company_name'] ?? null,
            "Zip" => $delivery['postal_code'] ?? null,
            "Street" => $delivery['street'] ?? null,
            "Latitude" => $delivery['latitude'] ?? null,
            "Country" => $delivery['country'] ?? null,
            "Longitude" => $delivery['longitude'] ?? null,
            "HouseNo" => $delivery['house_number'] ?? null,
            "Title" => $delivery['title'] ?? null,
            "PhoneNo" => $receiver['phone'] ?? null,
            "City" => $delivery['city'] ?? null,
            "FirstName" => $receiver['first_name'] ?? null,
            "EMail" => $receiver['email'] ?? null,
        ];
    }

    /**
     * EXACT ID format (L0001 etc)
     */
    private static function formatId($id): string
    {
        $len = strlen((string) $id);
        return 'L' . str_pad($id, $len, '0', STR_PAD_LEFT);
    }

    /**
     * EXACT time validation
     */
    private static function formatOrderTime(?string $time): ?string
    {
        if (!$time) return null;

        return preg_match('/^(2[0-3]|[01]?[0-9]):([0-5][0-9])$/', $time)
            ? $time
            : null;
    }
}
