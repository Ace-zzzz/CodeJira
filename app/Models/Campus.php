<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    protected $fillable = [
        'name',
        'location',
        'description',
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
