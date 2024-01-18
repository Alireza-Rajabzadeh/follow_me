<?php

namespace Database\Seeders;

use App\Models\PagesFollowers;
use App\Models\UserPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageFollowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = UserPage::all();

        foreach ($pages as $page) {
            // $x = ($page->followedBy());
            // // $x = ($page->Following());

            // // dd($x->count());
            // dd($x->get()->toArray());

            // foreach ($x as $a) {

            //     dd($a);
            // }
            foreach ($pages as $follow) {

                if ($follow->id == $page->id) {
                    echo ("page : " . $page->page_id . " cant follow it self" . PHP_EOL);
                    continue;
                }
                $random_chance = random_int(1, 100);


                if (($random_chance % 2) == 0) {

                    $page_follow_data = [
                        "user_page_id" => $page->id,
                        "follow_page_id" => $follow->id
                    ];

                    $is_follow = PagesFollowers::where($page_follow_data)->first();

                    if (empty($is_follow)) {
                        PagesFollowers::create($page_follow_data);
                        echo ("page : " . $page->page_id . "start following " . $follow->page_id . PHP_EOL);
                    } else {
                        echo ("page : " . $page->page_id . "already " . $follow->page_id . PHP_EOL);
                    }
                }
            }
        }
    }
}
