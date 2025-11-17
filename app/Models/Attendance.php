<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'check_in',
        'check_out',
        'status',
        'check_in_photo',
        'check_out_photo',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getIsLateAttribute()
    {
        if (!$this->check_in) return false;
        
        try {
            $workStartTime = Setting::get('work_start_time', '08:00:00');
            $lateTolerance = (int) Setting::get('late_tolerance_minutes', 15);
            
            $startTime = Carbon::parse($workStartTime)->addMinutes($lateTolerance);
            $checkIn = Carbon::parse($this->check_in);
            
            return $checkIn->greaterThan($startTime);
        } catch (\Exception $e) {
            return false;
        }
    }
}