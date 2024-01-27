<?php

namespace App\Repositories\Elequent;

use App\Models\TransactionsLogger;
use App\Repositories\Elequent\BaseRepository;


class TransactionLoggerRepository extends BaseRepository
{
    public function __construct(TransactionsLogger $orders)
    {
        $this->model = $orders;
    }
}
