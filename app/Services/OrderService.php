<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Elequent\UserRepository;
use App\Repositories\Elequent\OrderRepository;
use App\Repositories\Elequent\OrderDetailRepository;


class OrderService
{

    protected $order_repository;
    protected $user_repository;
    protected $order_detail_repository;



    public function __construct(OrderRepository $order_repository, OrderDetailRepository $order_detail_repository, UserRepository $user_repository)
    {
        $this->order_repository = $order_repository;
        $this->order_detail_repository = $order_detail_repository;
        $this->user_repository = $user_repository;
    }

    public function makeOrder($request_data)
    {
        $order = $this->order_repository->create([
            'user_id' => Auth::user()->id,
            'status_id' => 1, #success
            'cost' => $request_data['cost'],
        ]);


        $order_detail = $this->order_detail_repository->create([
            'order_id' => $order->id,
            'status_id' => '2', #inprogress
            'order_count' => $request_data['order_count'],
            'received_count' => 0,
        ]);

        return [
            'order' => $order,
            "order_detail" => $order_detail
        ];
    }

    public function showClientOrders($request_data)
    {
        $orders = $this->order_repository->search(
            [
                "where" => [
                    "user_id" => Auth::user()->id,
                ],
                "relation" => [
                    'orderDetail'
                ],
                "limit" => $request_data['limit'] ?? 10,
                "offset" => $request_data['offset'] ?? 0,
            ]
        );
        return $orders;
    }

    public function showAvailableOrders($request_data)
    {

        $orders = $this->order_repository->search(
            [
                "where" => [
                    "status_id" => "1",
                ],
                'relation' => [
                    'orderDetail'
                ],
                "dump" => true
            ],
        );

        return $orders;
    }

    public function showAvailablePage($request_data)
    {

        $orders = $this->showAvailableOrders($request_data);


        $available_page = null;
        $available_order = null;
        foreach ($orders['result'] as $order) {


            if (empty($order['order_detail'])) {

                continue;
            }

            if ($order['order_detail']['status_id'] != 2) {
                continue;
            }

            if ($order['order_detail']['order_count'] <= $order['order_detail']['received_count']) {
                continue;
            }

            if ($order['user_id'] == Auth::user()->id) {
                continue;
            }

            $user = $this->user_repository->find($order['user_id']);



            $page = $user->page()->first();


            if (empty($page)) {
                continue;
            }


            $is_currently_following = ($page->followedBy()->where([
                "user_page_id" => Auth::user()->id
            ]));

            if ($is_currently_following->count() != 0) {

                continue;
            }

            $available_order = $order;
            $available_page = $page;
            break;
        }


        if (empty($available_page)) {
            throw new Exception("no available page", 404);
        }


        $result = [
            'avialable_page' => $available_page,
            'order_id' => $available_order['id'],
        ];

        return $result;
    }

    function isExist($request_data)
    {
        $order = $this->order_repository->find($request_data['order_id']);
        if (empty($order)) {
            throw new Exception("Order not found", 1);
        }

        return $order;
    }


    function findOrderUserPageId($request_data)
    {

        $order = $this->isExist($request_data);

        $user = ($order->user()->first());

        $page = $user->page()->first();

        return $page->id;
    }

    function isOrderOpen($order)
    {
        $order_detail = $order->orderDetail()->first();

        if (empty($order_detail)) {

            throw new Exception("Order not found", 404);
        }
        if (($order_detail->order_count <= $order_detail->received_count) || ($order_detail->status_id == 1)) {
            throw new Exception("Order not valid", 404);
        }
        return $order_detail;
    }

    function FollowReceived($request_data)
    {

        $request_data['order'] = $this->isExist($request_data);

        $request_data['order_detail'] = $this->isOrderOpen($request_data['order']);

        $received_count = $request_data['order_detail']->received_count + 1;

        $update_data = [];
        if ($request_data['order_detail']->order_count == $received_count) {
            
            $update_data = [
                "status_id" => 1,
                'received_count' => $received_count
            ];
        } else {
            $update_data = [
                'received_count' => $received_count
            ];
        }


        $request_data['order_detail']->update($update_data);

        return $request_data;
    }
}
