<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            [
                'group' => 'booking',
                'key' => 'cancellation_fee_percent',
                'label' => 'Cancellation Fee (%)',
                'value' => '10',
                'type' => 'number',
            ],
            [
                'group' => 'booking',
                'key' => 'cancellation_min_fee',
                'label' => 'Minimum Cancellation Fee',
                'value' => '0',
                'type' => 'number',
            ],
            [
                'group' => 'booking',
                'key' => 'cancellation_max_fee',
                'label' => 'Maximum Cancellation Fee',
                'value' => '0',
                'type' => 'number',
            ],
        ]);
    }
}
