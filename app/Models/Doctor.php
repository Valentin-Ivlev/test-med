<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'lmf_name',
        'gender',
        'phone',
        'email',
        'speciality_id',
        'additional_info'
    ];
}
