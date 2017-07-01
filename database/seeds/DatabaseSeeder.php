<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
	        'first' => "Rand",
	        'last' => "al'Thor",
	        'permissions' => 'admin',
	        'email' => 'rand@admin.ca',
	        'company_name' => "Asha'man",
	        'hourly_rate_one' => 100.00,
	        'gst_number' => 'A458EHE5',
            'password' => bcrypt(env('ADMIN_CREDENTIALS', false))
        ]);

        DB::table('users')->insert([
            'first' => "Timmy",
            'last' => "Tucan",
            'permissions' => 'user',
            'email' => 'timmyt@gmail.com',
            'company_name' => "Tucan Inc.",
            'hourly_rate_one' => 45.00,
            'gst_number' => 'A458EHE5',
            'password' => bcrypt('password')
        ]);   

        DB::table('users')->insert([
            'first' => "Penny",
            'last' => "Pink",
            'permissions' => 'user',
            'email' => 'pennyp@hotmail.com',
            'company_name' => "Penny Ltd.",
            'hourly_rate_one' => 40.00,
            'gst_number' => 'UOUE458E',
            'password' => bcrypt('password1')
        ]);

        DB::table('users')->insert([
            'first' => "Cam",
            'last' => "Kool",
            'permissions' => 'user',
            'email' => 'koolcam@gmail.com',
            'company_name' => "Kool Co.",
            'hourly_rate_one' => 45.00,
            'gst_number' => 'UOTE448TE',
            'password' => bcrypt('password2')
        ]);   

        DB::table('projects')->insert([
            'province' => "Alberta",
            'location' => "Near the stones on the hill",
            'details' => 'This is a project',
            'client_company_name' => 'Big Jims Oil Co.',
            'client_contact_name' => 'Jimbo',
            'client_contact_phone' => '458-568-8962',
            'first_contact_by' => "Jimbo",
            'first_contact_date' => '2017-06-26'
        ]);                               
    }
}
