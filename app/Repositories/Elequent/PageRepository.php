<?php

namespace App\Repositories\Elequent;

use App\Models\UserPage;
use App\Repositories\Elequent\BaseRepository;


class PageRepository extends BaseRepository
{
    public function __construct(UserPage $user_page)
    {
        $this->model = $user_page;
    }
}
