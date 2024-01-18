<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UsersCredit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserCereditsSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {

            if (empty($user->credit()->get()->toArray())) {
                echo ("\t".$user->name . " , seedeing credit ." . PHP_EOL);

                $user_credit_data = [
                    'user_id' => $user->id,
                    "coins" => random_int(80, 1000)
                ];

                UsersCredit::create($user_credit_data);
            } else {
                echo ("\t".$user->name . " , already has credit ." . PHP_EOL);
            }

            // UsersCredit::create($user_credit_data);

        }
    }
}
