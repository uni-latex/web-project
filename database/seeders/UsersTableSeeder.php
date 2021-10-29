<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('users')->delete();

        \DB::table('users')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'anditsung',
                'email' => 'anditsung@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$sx5AyYZQA5AC/T1yCzjYieqlCqJRr01c5uE2JSfDJSJj1psyInL56', // password
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'current_team_id' => NULL,
                'profile_photo_path' => NULL,
                'is_admin' => true,
                'created_at' => '2021-10-29 02:42:20',
                'updated_at' => '2021-10-29 02:42:20',
            ),
        ));


    }
}
