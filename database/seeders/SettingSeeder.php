<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;
class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'key' => 'is_rate_fixed',
            'value' => true,
        ]);
        Setting::create([
            'key' => 'rate',
            'value' => null,
        ]);
        Setting::create([
            'key' => 'notification_time',
            'value' => 7,
        ]);

        Setting::create([
            'key' => "name",
            'value' => 'Meriem Abid',
        ]);
        Setting::create([
            'key' => "speciality",
            'value' => 'Dermatologue',
        ]);
        Setting::create([
            'key' => 'address',
            'value' => 'App 3 2 eme étage mhamid 1 c num 283. ( au dessus du café boughaz)
            Mhamid 40054 Marrakech Maroc',
        ]);
    }
}
