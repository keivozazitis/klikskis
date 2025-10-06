<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    // Šeit norādi, kurus laukus var masīvi piešķirt
    protected $fillable = ['name'];
}
