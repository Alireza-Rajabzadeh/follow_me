<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserPage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserPageSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {

            if (empty($user->page()->first())) {
                echo ("\t" . $user->name . " , seedeing user page ." . PHP_EOL);

                $page_id = str_replace(" ", "_", $user->name);
                $page_id = str_replace(".", "_", $page_id);
                $user_page_data = [
                    'user_id' => $user->id,
                    "page_id" => $page_id
                ];

                $page = UserPage::where($user_page_data)->first();
                UserPage::create($user_page_data);
            } else {
                echo ("\t" . $user->name . " , already has user page ." . PHP_EOL);
            }
        }
    }
}
