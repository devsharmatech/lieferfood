<?php

namespace App\Services;
use App\Responses\WinOrderResponse;
use App\Models\WinorderApi;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Cache;


class WinOrderService
{
public function getOrders($key, $secret)
{
$cacheKey = 'winorder_' . md5($key);

return Cache::remember($cacheKey, 20, function () use ($key, $secret) {
$api = WinorderApi::where('code', $key)
->where('secret_key', $secret)
->where('status', 1)
->first();


if (!$api) return WinOrderResponse::empty();


   $orders = Order::with([
       'items.food'
   ])
   ->where('vendor_id', $api->vendor_id)
   ->where('order_status', 'pending')
   ->where('payment_status', '!=', 0)
   ->whereDate('created_at', today())
   ->latest()
   ->get();

    $vendor = User::find($api->vendor_id);
   return WinOrderResponse::make($orders,$vendor);
});
}


public function updateStatus($orderUid, $tracking)
{
$map = [
0 => 'pending',
1 => 'confirmed',
2 => 'preparing',
5 => 'out_for_delivery',
6 => 'delivered',
7 => 'cancelled'
];


if (!isset($map[$tracking])) {
return ['error' => 'Invalid status'];
}


Order::where('uid', $orderUid)
->update(['order_status' => $map[$tracking]]);


Cache::flush(); // clear WinOrder cache


return ['message' => 'Status updated'];
}
}