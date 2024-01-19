<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\Elequent\UserRepository;

class PostsService
{
    protected $user_repository;
    protected $tags_repository;
    protected $categories_repository;
    protected $status_repository;

    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }
    
}
