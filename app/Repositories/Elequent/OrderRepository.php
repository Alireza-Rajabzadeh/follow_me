<?php

namespace App\Repositories\Elequent;

use App\Models\Orders;
use App\Repositories\Elequent\BaseRepository;


class OrderRepository extends BaseRepository
{
    public function __construct(Orders $orders)
    {
        $this->model = $orders;
    }
}
