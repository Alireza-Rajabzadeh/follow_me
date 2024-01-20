<?php

namespace App\Services;

use App\Repositories\Elequent\OrderDetailRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Elequent\UserRepository;
use App\Repositories\Elequent\OrderRepository;


class OrderService
{

    protected $order_repository;
    protected $user_repository;
    protected $order_detail_repository;



    public function __construct(OrderRepository $order_repository, OrderDetailRepository $order_detail_repository)
    {
        $this->order_repository = $order_repository;
        $this->order_detail_repository = $order_detail_repository;
    }

    public function makeOrder($request_data)
    {
        $order = $this->order_repository->create([
            'user_id' => Auth::user()->id,
            'status_id' => 1,
            'cost' => $request_data['cost'],
        ]);


        $order_detail = $this->order_detail_repository->create([
            'order_id' => $order->id,
            'status_id' => '3',
            'order_count' => $request_data['order_count'],
            'received_count' => 0,
        ]);

        return [
            'order' => $order,
            "order_detail" => $order_detail
        ];
    }

    public function showClientOrders($request_data) {
        $orders = $this->order_repository->search(
            [
                "where"=>[
                    "user_id" => Auth::user()->id,
                ],
                "relation"=>[
                    'orderDetail'
                ],
                "limit" => $request_data['limit']?? 10,
                "offset" => $request_data['offset']?? 0,
            ]
        );
        return $orders;
    }
}
