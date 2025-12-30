<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 20) as $bookingId) {
            DB::table('payments')->insert([
                'booking_id' => $bookingId,
                'method' => 'cash',
                'amount' => rand(300, 800),
                'status' => 'success',
                'transaction_id' => null,
            ]);
        }
    }
}
