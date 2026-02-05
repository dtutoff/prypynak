<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TransportSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Список остановок
        $stopNames = [
            'Микрорайон Казимировка', 'Улица Космонавтов', 'Площадь Орджоникидзе',
            'Площадь Ленина', 'Диагностический центр', 'Могилёвский рынок',
            'Проспект Мира', 'Гостиница «Турист»', 'Улица 30 лет Победы',
            'Железнодорожный вокзал',
        ];

        $stopsPool = collect($stopNames)->map(function ($name) {
            return \App\Models\Stop::firstOrCreate(['name' => $name]);
        });

        // 2. Список автобусов
        $busNumbers = ['4', '2', '40', '12', '1'];

        foreach ($busNumbers as $number) {
            $transport = \App\Models\Transport::firstOrCreate(
                ['number' => $number, 'type' => 'bus'],
                ['name' => "Маршрут №$number (Тестовый)"],
            );

            $routeStops = $stopsPool->random(rand(6, 8));

            $this->buildRoute($transport, $routeStops, false);
            $this->buildRoute($transport, $routeStops->reverse(), true);
        }
    }

    private function buildRoute($transport, $stops, $isBackward)
    {
        $order = 1;
        foreach ($stops as $stop) {
            $transport->stops()->attach([
                $stop->id => ['order' => $order++, 'is_backward' => $isBackward],
            ]);
        }

        $departureFromTerminal = \Carbon\Carbon::createFromTime(6, 0, 0);

        while ($departureFromTerminal->hour < 23) {
            $currentTimeAtStop = $departureFromTerminal->copy();

            foreach ($stops as $stop) {
                \App\Models\Schedule::create([
                    'transport_id' => $transport->id,
                    'stop_id' => $stop->id,
                    'arrival_time' => $currentTimeAtStop->format('H:i:s'),
                    'day_type' => 'workday',
                    'is_backward' => $isBackward,
                ]);

                $currentTimeAtStop->addMinutes(5);
            }
            $departureFromTerminal->addMinutes(20);
        }
    }
}
