<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run(): void
{
    $settings = [
        ['key' => 'work_start_time', 'value' => '08:00:00', 'type' => 'time'],
        ['key' => 'work_end_time', 'value' => '17:00:00', 'type' => 'time'],
        ['key' => 'late_tolerance_minutes', 'value' => '15', 'type' => 'number'],
        ['key' => 'face_recognition_threshold', 'value' => '0.6', 'type' => 'number'],
        ['key' => 'company_name', 'value' => 'PT. Example Company', 'type' => 'string'],
    ];

    foreach ($settings as $setting) {
        DB::table('settings')->updateOrInsert(
            ['key' => $setting['key']], // cek key ada atau tidak
            array_merge($setting, [
                'updated_at' => now(),
                'created_at' => now(),
            ])
        );
    }
}
}