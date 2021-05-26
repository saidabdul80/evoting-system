<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     	DB::table('users')->insert([
            'id' => 1,           
            'fname'=> 'Admin',                        
            'lname' => 'Admin',           
            'email' => 'Admin@voting.com',           
            'password'=>md5(12345678)
        ]);   
        
    }
}
