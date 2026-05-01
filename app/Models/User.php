<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Property;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
 protected $fillable = [
    'name',
    'email',
    'password',
    'role'
];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // 🔥 relationships

public function compares()
{
    return $this->hasMany(Compare::class);
}
public function properties()
{
    return $this->hasMany(Property::class);
}
public function favorites()
{
    return $this->belongsToMany(
        Property::class,
        'favorites',
        'user_id',
        'property_id'
    );
}
public function sentMessages()
{
    return $this->hasMany(Message::class,'sender_id');
}

public function receivedMessages()
{
    return $this->hasMany(Message::class,'receiver_id');
}
public function notifications()
{
    return $this->hasMany(Notification::class);
}
public function isAdmin()
{
    return $this->role === 'admin';
}
public function scopeAdmins($query)
{
    return $query->where('role', 'admin');
}
}
