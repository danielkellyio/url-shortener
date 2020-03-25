<?php

use Illuminate\Database\Seeder;
use \App\Url;

class UrlTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $fakeData = [
            [
                'id'        => 'seed',
                'url'       => 'https://laravel.com/docs/6.x/seeding',
                'user_id'   => 1
            ],
            [
                'id'        => 'netfunc',
                'url'       => 'https://github.com/wearelucid/nuxt-netlify-functions-example',
                'user_id'   => 2
            ],
            [
                'id'        => 'splendid',
                'url'       => 'https://chrome.google.com/webstore/detail/splendid/cclkohfblcmkiefomfkbgiphdngjmjpl?hl=en',
                'user_id'   => 1
            ]

        ];
        foreach($fakeData as $fakeUrl){
            $url            = new Url();
            $url->id        = $fakeUrl['id'];
            $url->url       = $fakeUrl['url'];
            $url->user_id   = $fakeUrl['user_id'];
            $url->save();
        }

    }
}
