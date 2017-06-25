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
    }
}
