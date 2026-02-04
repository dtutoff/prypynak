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
        // Остановки
        $stop1 = \App\Models\Stop::firstOrCreate(['name' => 'Микрорайон Казимировка']);
        $stop2 = \App\Models\Stop::firstOrCreate(['name' => 'Улица Космонавтов']);
        $stop3 = \App\Models\Stop::firstOrCreate(['name' => 'Площадь Орджоникидзе']);
        $stop4 = \App\Models\Stop::firstOrCreate(['name' => 'Площадь Ленина']);
        $stop5 = \App\Models\Stop::firstOrCreate(['name' => 'Диагностический центр']);
        $stop6 = \App\Models\Stop::firstOrCreate(['name' => 'Могилёвский рынок']);
        $stop7 = \App\Models\Stop::firstOrCreate(['name' => 'Проспект Мира']);
        $stop8 = \App\Models\Stop::firstOrCreate(['name' => 'Гостиница «Турист»']);
        $stop9 = \App\Models\Stop::firstOrCreate(['name' => 'Улица 30 лет Победы']);
        $stop10 = \App\Models\Stop::firstOrCreate(['name' => 'Железнодорожный вокзал']);

        // Транспорт
        $bus1 = \App\Models\Transport::firstOrCreate([
            'number' => '4',
            'type' => 'bus',
            'name' => 'Казимировка — Приднепровье',
        ]);

        $bus2 = \App\Models\Transport::firstOrCreate([
            'number' => '6',
            'type' => 'bus',
            'name' => 'Площадь Ленина — Проспект Мира',
        ]);

        // Связь автобусов и остановок
        // Путь Туда
        $bus1->stops()->attach([
            $stop1->id => ['order' => 1, 'is_backward' => false],
            $stop2->id => ['order' => 2, 'is_backward' => false],
            $stop3->id => ['order' => 3, 'is_backward' => false],
            $stop4->id => ['order' => 4, 'is_backward' => false],
            $stop5->id => ['order' => 5, 'is_backward' => false],
        ]);

        // Путь Обратно
        $bus1->stops()->attach([
            $stop5->id => ['order' => 1, 'is_backward' => true],
            $stop4->id => ['order' => 2, 'is_backward' => true],
            $stop3->id => ['order' => 3, 'is_backward' => true],
            $stop2->id => ['order' => 4, 'is_backward' => true],
            $stop1->id => ['order' => 5, 'is_backward' => true],
        ]);

        // Путь Туда
        $bus2->stops()->attach([
            $stop6->id => ['order' => 1, 'is_backward' => false],
            $stop7->id => ['order' => 2, 'is_backward' => false],
            $stop8->id => ['order' => 3, 'is_backward' => false],
            $stop9->id => ['order' => 4, 'is_backward' => false],
            $stop10->id => ['order' => 5, 'is_backward' => false],
        ]);

        // Путь Обратно
        $bus2->stops()->attach([
            $stop10->id => ['order' => 1, 'is_backward' => true],
            $stop9->id => ['order' => 2, 'is_backward' => true],
            $stop8->id => ['order' => 3, 'is_backward' => true],
            $stop7->id => ['order' => 4, 'is_backward' => true],
            $stop6->id => ['order' => 5, 'is_backward' => true],
        ]);
    }
}
