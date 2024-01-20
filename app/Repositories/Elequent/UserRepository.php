<?php

namespace App\Repositories\Elequent;

use App\Models\User;
use App\Repositories\Elequent\BaseRepository;


class UserRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }
}
