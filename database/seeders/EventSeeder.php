<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        Event::create([
            'title'    => 'Laravel Meetup Kyiv',
            'date'     => Carbon::now()->addDays(5),
            'capacity' => 100,
        ]);

        Event::create([
            'title'    => 'Vue.js Conference',
            'date'     => Carbon::now()->addDays(15),
            'capacity' => 200,
        ]);

        Event::create([
            'title'    => 'PHP Hackathon',
            'date'     => Carbon::now()->subDays(3),
            'capacity' => 50,
        ]);
    }
}
