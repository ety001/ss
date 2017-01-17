<?php

use Illuminate\Database\Seeder;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ss_service')->insert([
            'service_id' => 1,
            'service_name' => 'D1型套餐',
            'service_type' => '2',
            'service_val' => '1',
            'service_status' => '1',
            'service_money' => '1'
        ]);
        DB::table('ss_service')->insert([
            'service_id' => 2,
            'service_name' => 'D7型套餐',
            'service_type' => '2',
            'service_val' => '7',
            'service_status' => '1',
            'service_money' => '5'
        ]);
        DB::table('ss_service')->insert([
            'service_id' => 3,
            'service_name' => 'D30型套餐',
            'service_type' => '2',
            'service_val' => '30',
            'service_status' => '1',
            'service_money' => '10'
        ]);
        DB::table('ss_service')->insert([
            'service_id' => 4,
            'service_name' => 'D90型套餐',
            'service_type' => '2',
            'service_val' => '90',
            'service_status' => '1',
            'service_money' => '30'
        ]);
        DB::table('ss_service')->insert([
            'service_id' => 5,
            'service_name' => 'D360型套餐',
            'service_type' => '2',
            'service_val' => '360',
            'service_status' => '1',
            'service_money' => '60'
        ]);
    }
}
