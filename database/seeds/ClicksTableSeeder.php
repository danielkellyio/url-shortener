<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Url;
use App\User;

class ClicksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach($users as $user){
            foreach(range(1,rand(500, 1000)) as $index) {
                $url = Url::where('user_id', $user->id)->first();
                if($url){
                    $faker = Faker::create();
                    $randomDay = rand(0, 30);
                    $click = new \App\Click();
                    $click->created_at = date('Y-m-d', strtotime("-$randomDay days"));
                    $click->updated_at = $click->created_at;
                    $click->url_id = $url->id;
                    $click->ip_address = $randomDay > 15 ? $faker->ipv4 : $faker->ipv6;
                    $click->referrer = $faker->url;
                    $click->save();
                }
            }
        }
    }
}
