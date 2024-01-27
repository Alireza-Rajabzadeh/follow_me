<?php

namespace App\Http\Controllers;


use App\Services\PageService;
use App\Services\UserService;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FollowPageRequest;
use App\Services\TransactionLoggerService;

class PageController extends Controller
{
    protected $page_service;
    protected $order_service;
    protected $transaction_logger;
    protected $user_service;
    public function __construct(
        OrderService $order_service,
        PageService $page_service,
        UserService $user_service,
        TransactionLoggerService $transaction_logger
    ) {
        $this->page_service = $page_service;
        $this->order_service = $order_service;
        $this->user_service = $user_service;
        $this->transaction_logger = $transaction_logger;
    }


    public function followPage(FollowPageRequest $request)
    {

        $requested_data  = $request->validated();
        $transaction_result = DB::transaction(function () use ($requested_data) {
            $user_order_page = $this->order_service->findOrderUserPageId($requested_data);
            $requested_data['page_id'] = $user_order_page['page']->id;
            $this->page_service->followPage($requested_data);



            $this->order_service->FollowReceived($requested_data);
            $increase_credit_data = $this->user_service->increaseCredit($requested_data);
            $this->transaction_logger->followLog(Auth::user()->id);
            $this->transaction_logger->followReceived($user_order_page->id);

            return $increase_credit_data;
        });

        return apiResponse(true, $transaction_result);
    }
}
