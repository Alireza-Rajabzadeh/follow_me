<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmptyRequest;
use App\Services\UserService;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\ShowClientOrdersRequest;

class OrderController extends Controller
{
    protected $user_service;
    protected $order_service;
    public function __construct(OrderService $order_service, UserService $user_service)
    {
        $this->user_service = $user_service;
        $this->order_service = $order_service;
    }

    public function showClientOrders(ShowClientOrdersRequest $request)
    {

        $request_data = $request->validated();

        $order_result = $this->order_service->showClientOrders($request_data);

        return apiResponse(true, $order_result);
    }

    public function order(OrderRequest $request)
    {

        $request_data = $request->validated();
        $order_transacrion_result =  DB::transaction(function () use ($request_data) {

            $this->user_service->hasEnouphCredit($request_data);
            $reduce_result = $this->user_service->reduceCredit($request_data);

            $request_data['cost'] = $reduce_result['cost'];
            $order_result = $this->order_service->makeOrder($request_data);
            return ($order_result);
        });

        return apiResponse(true, [], 'order accepted . followers will be add to your page .');
    }
}
