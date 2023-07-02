<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Attendance::create([
            'date' => "2023-07-03",
            "start_time" => "00:33:32",
            "user_id" => 1
        ]);

    }
}
