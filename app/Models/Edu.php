<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edu extends Model
{
    use HasFactory;

    protected $fillable = [
    	'doctor_id',
        'city_id',
        'org',
        'end_year'
    ];
}
