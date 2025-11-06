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
    public function region()
{
    return $this->belongsTo(Region::class);
}
// Lietotāji, kurus es esmu likojis
public function likesGiven() {
    return $this->hasMany(Like::class, 'user_id');
}

// Lietotāji, kas like uz mani
public function likesReceived() {
    return $this->hasMany(Like::class, 'liked_user_id');
}

// Matches
public function matches() {
    return $this->belongsToMany(User::class, 'likes', 'user_id', 'liked_user_id')
                ->wherePivot('matched', true);
}

}
