<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rest;
use Carbon\Carbon;

class RestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $today = Carbon::today();
        Rest::create([
            "start_time" => $today->addHour(),
            "end_time" =>$today->addHour()->addMinutes(5),
            "attendance_id" => 1
        ]);

    }
}
