<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Elequent\PageRepository;
use App\Repositories\Elequent\PagesFollowersRepository;

class PageService
{
    protected $page_repository;
    protected $follower_page_repository;

    public function __construct(PageRepository $page_repository, PagesFollowersRepository $follower_page_repository)
    {
        $this->page_repository = $page_repository;
        $this->follower_page_repository = $follower_page_repository;
    }


    public function isExist($request_data)
    {
        $page = $this->page_repository->find($request_data['page_id']);
        if (empty($page)) {
            throw new Exception("page not found", 422);
        }

        return $page;
    }

    public function followPage($request_data)
    {
        $page = $this->isExist($request_data);


        if (Auth::user()->id == $request_data['page_id']) {
            throw new Exception("can not follow your page", 422);
        }

        $is_follow = ($page->followedBy()->where([
            "user_page_id" => Auth::user()->id
        ]));


        if ($is_follow->count() != 0) {
            throw new Exception("already follow", 422);
        }

        $this->follower_page_repository->create([
            'user_page_id' => Auth::user()->id,
            'follow_page_id' => $request_data['page_id']
        ]);
    }
}
