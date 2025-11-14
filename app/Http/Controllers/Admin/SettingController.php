<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'work_start_time' => Setting::get('work_start_time', '08:00:00'),
            'work_end_time' => Setting::get('work_end_time', '17:00:00'),
            'late_tolerance_minutes' => Setting::get('late_tolerance_minutes', '15'),
            'face_recognition_threshold' => Setting::get('face_recognition_threshold', '0.6'),
            'company_name' => Setting::get('company_name', 'PT. Example Company'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'work_start_time' => 'required|date_format:H:i',
            'work_end_time' => 'required|date_format:H:i|after:work_start_time',
            'late_tolerance_minutes' => 'required|integer|min:0|max:60',
            'face_recognition_threshold' => 'required|numeric|min:0|max:1',
            'company_name' => 'required|string|max:255',
        ]);

        foreach ($validated as $key => $value) {
            $type = in_array($key, ['late_tolerance_minutes']) ? 'number' : 
                    (in_array($key, ['work_start_time', 'work_end_time']) ? 'time' : 'string');
            
            Setting::set($key, $value, $type);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}