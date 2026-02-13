<?php

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use App\Services\WinOrderService;
use Illuminate\Http\Request;


class WinOrderController extends Controller
{
public function __construct(private WinOrderService $service) {}


public function orders(Request $request)
{
return response()->json(
$this->service->getOrders(
$request->header('app-key'),
$request->header('key-secret')
)
);
}


public function updateStatus(Request $request)
{
return response()->json(
$this->service->updateStatus(
$request->ordersid,
$request->trackingstatus
)
);
}
}