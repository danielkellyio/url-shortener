<?php

use Illuminate\Database\Seeder;
use \App\User;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Test user
        $user           = new User();
        $user->name     = 'Test User';
        $user->email    = 'testuser@test.com';
        $user->password = Hash::make('password');
        $user->api_token = Str::random(60);
        $user->save();

        // Me user
        if(env('USER_EMAIL') && env('USER_NAME') && env('USER_PASSWORD')){
            $user           = new User();
            $user->name     = env('USER_NAME');
            $user->email    = env('USER_EMAIL');
            $user->password = Hash::make(env('USER_PASSWORD'));
            $user->api_token = Str::random(60);
            $user->save();
        }

        foreach (range(0, 2) as $number) {
            $faker = Faker::create();
            $user           = new User();
            $user->name     = $faker->name;
            $user->email    = $faker->email;
            $user->password = Hash::make('password');
            $user->api_token = Str::random(60);
            $user->save();
        }
    }
}
