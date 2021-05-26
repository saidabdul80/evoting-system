<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class postSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            'id' => 1,           
            'abbr'=> 'Pres.',            
            'name'=>'President',            
            'status'=>'Active'
        ]);   
        DB::table('posts')->insert([
            'id' => 2,           
            'abbr'=> 'V. P',            
            'name'=>'Vice President',            
            'status'=>'Active'
        ]);   
        DB::table('posts')->insert([
            'id' => 3,           
            'abbr' => 'Sec. Gen.',           
            'name'=> 'Secretary General',                        
            'status'=>'Active'
        ]);   
        DB::table('posts')->insert([
            'id' => 4,           
            'abbr' => 'Fin. Sec.',           
            'name'=> 'Financial Secretary',                        
            'status'=>'Active'
        ]);   

        DB::table('posts')->insert([
            'id' => 5,           
            'abbr' => 'Tresurer',           
            'name'=> 'Tresurer',                        
            'status'=>'Active'
        ]);   

        DB::table('posts')->insert([
            'id' => 6,           
            'abbr' => 'P.R.O I',           
            'name'=> 'P.R.O I',                        
            'status'=>'Active'
        ]);   
        
        DB::table('posts')->insert([
            'id' => 7,           
            'abbr' => 'P.R.O II',           
            'name'=> 'P.R.O II',                        
            'status'=>'Active'
        ]);   
        
    }
}
