<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rest;

class RestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rest::create([
            "start_time" => "00:33:32",
            "end_time" => "00:33:35",
            "attendance_id" => 1
        ]);

        // Rest::create([
        //     "start_time" => "00:37:32",
        //     "attendance_id" => 1
        // ]);
    }
}
