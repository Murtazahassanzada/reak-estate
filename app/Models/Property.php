<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'status',
        'purpose',
        'type',
        'location',
        'price',
        'bedrooms',
        'bathrooms',
        'area',
    ];

    protected $casts = [
        'price' => 'float',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'area' => 'integer',
    ];

    protected $with = ['images'];

    protected $hidden = [
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class)->latest();
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function compares()
    {
        return $this->hasMany(Compare::class);
    }
}
