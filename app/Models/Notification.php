<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'body',
        'is_read',
    'property_id'
    ];
protected $casts = [
    'is_read' => 'boolean',
];
    // ✅ اضافه کن
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ اضافه کن
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
