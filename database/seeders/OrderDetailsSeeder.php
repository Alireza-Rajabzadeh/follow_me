<?php

namespace Database\Seeders;

use App\Models\OrderDetailStatuses;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $order_detail_statuses = [
            [
                'id' => "1",
                "name" => "complete"
            ],
            [
                'id' => "2",
                "name" => "inprogress"
            ]

        ];

        foreach ($order_detail_statuses as $order_detail_status_data) {

            $status = OrderDetailStatuses::find($order_detail_status_data['id']);

            if (empty($status)) {
                OrderDetailStatuses::create($order_detail_status_data);
                echo ("id :" . $order_detail_status_data['id'] . " inserted ." . PHP_EOL);
            } else {
                echo ("id :" . $order_detail_status_data['id'] . " already exist ." . PHP_EOL);
            }
        }
    }
}
