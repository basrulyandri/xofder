<?php

use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$kasir_is_blocked = \DB::table('settings')->whereSettingKey('kasir_is_blocked')->first();

    	if(!$kasir_is_blocked){
	        \DB::table('settings')->insert([
	        	'setting_key' => 'kasir_is_blocked',
	        	'setting_value' => '0',
	        	'created_at' => \Carbon\Carbon::now(),
	        	'updated_at' => \Carbon\Carbon::now(),
	        ]);    		
    	}
    }
}
