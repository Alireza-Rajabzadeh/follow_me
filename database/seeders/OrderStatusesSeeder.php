<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $order_statuses = [
            [
                'id' => "1",
                "name" => "success"
            ],
            [
                'id' => "2",
                "name" => "fail"
            ],
                        [
                'id' => "3",
                "name" => "inprogress"
            ]
        ];

        foreach ($order_statuses as $order_status_data) {

            $status = OrderStatus::find($order_status_data['id']);

            if (empty($status)) {
                OrderStatus::create($order_status_data);
                echo ("id :" . $order_status_data['id'] . " inserted ." . PHP_EOL);
            } else {
                echo ("id :" . $order_status_data['id'] . " already exist ." . PHP_EOL);
            }
        }
    }
}
