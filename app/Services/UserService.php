<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Elequent\UserRepository;
use App\Repositories\Elequent\UsersCreditRepository;

class UserService
{
    protected $user_repository;

    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }


    public function userCeredit()
    {

        return (Auth::user()->credit()->first()->coins);
    }


    public function hasEnouphCredit($requset_data)
    {
        if (($requset_data['order_count'] * env("FOLLOW_COST", "4")) > $this->userCeredit()) {

            throw new Exception("not enouph credit", 422);
        }

        return true;
    }


    public function reduceCredit($requset_data)
    {
        $this->hasEnouphCredit($requset_data);

        $cost = ($requset_data['order_count'] * env("FOLLOW_COST", "4"));


        $credit_after_order = $this->userCeredit() - $cost;
        Auth::user()->credit()->update([
            'coins' => $credit_after_order
        ]);

        return [
            'user_credit' => $credit_after_order,
            'cost' => $cost
        ];
    }

    public function increaseCredit($requset_data)
    {
        $follow_reward = env("FOLLOW_COIN_REWARD_AMOUNT", "2");

        $credit_after_follow = $this->userCeredit() + $follow_reward;
        Auth::user()->credit()->update([
            'coins' => $credit_after_follow
        ]);

        return [
            'user_credit' => $credit_after_follow,
            'reward' => $follow_reward
        ];
    }

    public function showUserPageByOrder($request_data)
    {
        $user = $this->user_repository->find($request_data['available_order']['user_id']);

        $page = $user->page()->get();
        return $page;
    }
}
