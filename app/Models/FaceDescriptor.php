<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaceDescriptor extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'descriptor',
        'photo_path',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getDescriptorArrayAttribute()
    {
        return json_decode($this->descriptor, true);
    }
}