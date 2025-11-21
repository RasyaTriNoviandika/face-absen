<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip',
        'name',
        'email',
        'phone',
        'department',
        'position',
        'photo',
        'is_active',
        'face_registered',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'face_registered' => 'boolean',
    ];

    public function faceDescriptors()
    {
        return $this->hasMany(FaceDescriptor::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function todayAttendance()
    {
        return $this->hasOne(Attendance::class)->whereDate('date', today());
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}