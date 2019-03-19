<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Joshua Miguel Magtibay';
        $user->email = 'joshuamiguelmagtibay17@gmail.com';
        $user->email_verified_at = \Carbon\Carbon::now();
        $user->password = bcrypt('password');
        $user->save();
    }
}
