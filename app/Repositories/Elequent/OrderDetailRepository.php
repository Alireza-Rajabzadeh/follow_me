<?php

namespace App\Repositories\Elequent;

use App\Models\OrderDetails;
use App\Models\Orders;
use App\Repositories\Elequent\BaseRepository;


class OrderDetailRepository extends BaseRepository
{
    public function __construct(OrderDetails $order_detail)
    {
        $this->model = $order_detail;
    }
}
