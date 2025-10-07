<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'gender',
        'weight',
        'bio',
        'region_id',
        'augums',
        'images',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'birth_date' => 'date',
        'images' => 'array',
        'email_verified_at' => 'datetime',
    ];
}
