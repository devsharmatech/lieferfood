<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\DeliveryArea;
use App\Models\collections;
use App\Models\food_item;
use App\Models\WinorderApi;
use App\Models\User;
use App\Models\review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderApiController extends Controller
{
    //
    
    public function getMyOrderWinOrder(Request $request)
    {
        
        $appKey = $request->input('app key');
        $keySecret = $request->input('App-Secret');
        if (!$appKey || !$keySecret) {
            return response()->json(["OrderList"=>["Order"=>[]],"CreateDateTime"=> now()->toIso8601String()]);
        }
        $WinorderApi=WinorderApi::where('code',$appKey)->where('secret_key',$keySecret)->first();
        if(!$WinorderApi){
          return response()->json(['error' => 'Invalid Autherisation'], 403);
        }
        
        if($WinorderApi->status==0){
          return response()->json(['error' => 'Your winorder api is blocked by administrator.'], 402);
        }
        
        if (isset($WinorderApi->vendor_id)) {
            $vendor_id = $WinorderApi->vendor_id;
            $vendor = User::find($vendor_id);
 $orders = Order::with('order_items.foodData', 'vendor', 'user')
    ->latest()
    ->where('order_status', 'pending')
    ->where('vendor_id', $vendor_id)
    ->get(); 

          $responses = [];

          foreach ($orders as $order) {
           $responses[] = [
        "AddInfo" => [
            "PaymentType" => $order->payment_method ?? null,
            "DiscountPercent" => isset($order->discount) && $order->total_amount > 0 
                ? (float) number_format(($order->discount / $order->total_amount) * 100,2) 
                : (float) 0,
            "Total" => (float) $order->total_amount ?? null,
        ],
        "OrderID" => $order->order_code ?? null,
        "ArticleList" => [
            "Article" => $order->order_items->map(function ($item) {
                $extras = json_decode($item->extras, true) ?? [];
                return [
                    "Price" => (float) $item->price,
                    "ArticleSize" => $item->variant ?? null,
                    "ArticleName" => $item->food_item_name ?? null,
                    "ArticleNo" => $item->foodData->external_id ?? null,
                    "SubArticleList" => [
                        "SubArticle" => array_map(function ($extra) {
                            return [
                                "Comment" => $extra['info'] ?? null,
                                "Price" => (float) $extra['price'] ?? null,
                                "Count" => 1,
                                "ArticleName" => $extra['name'] ?? null,
                            ];
                        }, $extras),
                    ],
                    "Count" => $item->quantity ?? 1,
                    "Comment"=>null,
                ];
            }),
        ],
        "StoreData" => [
            // "StoreId" => $order->vendor->id ?? null,
            "StoreId" => null,
            "StoreName" => $order->vendor->name ?? null,
        ],
         "ServerData" => [
                "Agent" => $request->header('User-Agent'),
                "CreateDateTime" => now()->toIso8601String(),
                "Referer" => $request->header('Referer'),
                "IpAddress" => $request->ip(),
            ],
        "Customer" => [
            "DeliveryAddress" => [
                "LastName" => $order->user->surname ?? null,
                "AddAddress" => null, // Adjust if additional address is available
                "Company" => json_decode($order->address, true)['company_name'] ?? null,
                "Zip" => json_decode($order->address, true)['postal_code'] ?? null,
                "Street" => json_decode($order->address, true)['street'] ?? null,
                "Latitude" => null, // Add logic if latitude is available
                "Country" => $order->user->country ?? null,
                "Longitude" => null, // Add logic if longitude is available
                "HouseNo" => json_decode($order->address, true)['house_number'] ?? null,
                "Title" => null, // Add logic if title is available
                "PhoneNo" => $order->contact_number ?? null,
                "City" => json_decode($order->address, true)['city'] ?? null,
                "FirstName" => $order->user->name ?? null,
                "EMail" => $order->user->email ?? null,
            ],
        ],
    ];
           }
         return response()->json(["OrderList"=>["Order"=>$responses,"CreateDateTime"=> now()->toIso8601String()]]);
        } else {
            return response()->json(['error' => 'Invalid Request'], 404);
        }
    }

    public function getReview(Request $request){
        if($request->has('user_id') && $request->input('user_id')!=""){
         if($request->has('vendor_id') && $request->input('vendor_id')!=""){
          if($request->has('order_id') && $request->input('order_id')!=""){
            $review = review::where('user_id', $request->user_id)
                    ->where('vendor_id', $request->vendor_id)
                    ->where('order_id', $request->order_id)
                    ->first();
            return response()->json(['status' => true,'message' => 'Successfully fetched your feedback!','data' => $review]);
          }else{
             return response()->json(['status' => false,'message' => 'Order Id is required!']);
          }
         }else{
             return response()->json(['status' => false,'message' => 'Vendor Id is required!']);
         }
        }else{
            return response()->json(['status' => false,'message' => 'User Id is required!']);
        }
    }
    
    public function storeReview(Request $request)
    {
    $validate = Validator::make($request->all(), [
        'order_id' => 'required|exists:orders,id',
        'vendor_id' => 'required|exists:users,id',
        'user_id' => 'required|exists:users,id',
        'content' => 'required|string',
        'rating' => 'required|integer|min:1|max:5',
     ]);
    if ($validate->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation failed!', 'errors' => $validate->errors()], 200);
    }
    review::updateOrCreate(
        [
            'user_id' => $request->user_id,
            'order_id' => $request->order_id,
            'vendor_id' => $request->vendor_id,
        ],
        [
            'content' => $request->content,
            'rating' => $request->rating,
        ]
    );
    return response()->json(['status' => true, 'message' => 'Feedback saved successfully.']);
}
}
