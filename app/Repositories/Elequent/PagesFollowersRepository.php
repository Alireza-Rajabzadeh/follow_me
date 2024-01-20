<?php

namespace App\Repositories\Elequent;

use App\Models\PagesFollowers;

use App\Repositories\Elequent\BaseRepository;


class PagesFollowersRepository extends BaseRepository
{
    public function __construct(PagesFollowers $page_followers)
    {
        $this->model = $page_followers;
    }
}
