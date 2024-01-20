<?php

namespace Database\Seeders;

use App\Models\UsersStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users_statuses = [
            [
                'id' => "1",
                "name" => "active"
            ],
            [
                'id' => "2",
                "name" => "deactive"
            ]
        ];

        foreach ($users_statuses as $status_data) {

            $status = UsersStatus::find($status_data['id']);

            if (empty($status)) {
                UsersStatus::create($status_data);
                echo ("id :" . $status_data['id'] . " inserted ." . PHP_EOL);
            } else {
                echo ("id :" . $status_data['id'] . " already exist ." . PHP_EOL);
            }
        }
    }
}
