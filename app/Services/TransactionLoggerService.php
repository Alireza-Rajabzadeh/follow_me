<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Repositories\Elequent\TransactionLoggerRepository;

class TransactionLoggerService
{
    protected $transaction_logger_repository;

    public function __construct(TransactionLoggerRepository $transaction_logger_repository)
    {
        $this->transaction_logger_repository = $transaction_logger_repository;
    }



    public function getTodayUserLog($user_id)
    {

        $today_date = date("Y-m-d 00:00:00");
        $transaction_log = $this->transaction_logger_repository->search([
            'where' => [
                'user_id' => $user_id,
            ],
            'date' => [
                "date_field" => 'created_at',
                'date_value' => $today_date
            ],
            'dump' => true
        ]);


        if (($transaction_log['total'] > 0)) {
            $transaction_log = $transaction_log['result'][0];
        } else {

            $transaction_log = $this->transaction_logger_repository->create([
                'user_id' => $user_id
            ]);

            $transaction_log = $this->transaction_logger_repository->find($transaction_log->id)->toArray();
        }

        return $transaction_log;
    }



    function followLog($user_id)
    {
        $user_today_log = $this->getTodayUserLog($user_id);

        $update_data = [
            'number_of_page_followed' => $user_today_log['number_of_page_followed'] + 1,
            'number_of_coin_catch' => $user_today_log['number_of_coin_catch'] + env("FOLLOW_COIN_REWARD_AMOUNT", 2)
        ];

        $this->transaction_logger_repository->update($user_today_log['id'], $update_data);
    }
    function followReceived($user_id)
    {
        $user_today_log = $this->getTodayUserLog($user_id);

        $update_data = [
            'number_of_follower_get' => $user_today_log['number_of_follower_get'] + 1,
        ];

        $this->transaction_logger_repository->update($user_today_log['id'], $update_data);
    }
}
