<?php

namespace App\Repositories\Elequent;

use App\Models\Orders;
use App\Models\UsersCredit;
use App\Repositories\Elequent\BaseRepository;


class UsersCreditRepository extends BaseRepository
{
    public function __construct(UsersCredit $orders)
    {
        $this->model = $orders;
    }
}
