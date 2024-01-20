<?php

namespace App\Http\Controllers;


use App\Services\PageService;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\FollowPageRequest;
use App\Services\UserService;

class PageController extends Controller
{
    protected $page_service;
    protected $order_service;
    protected $user_service;
    public function __construct(OrderService $order_service, PageService $page_service, UserService $user_service)
    {
        $this->page_service = $page_service;
        $this->order_service = $order_service;
        $this->user_service = $user_service;
    }


    public function followPage(FollowPageRequest $request)
    {

        $requested_data  = $request->validated();

        $transaction_result = DB::transaction(function () use ($requested_data) {
            $this->page_service->followPage($requested_data);
            $increase_credit_data = $this->user_service->increaseCredit($requested_data);

            return $increase_credit_data;
        });

        return apiResponse(true, $transaction_result);

    }
}
