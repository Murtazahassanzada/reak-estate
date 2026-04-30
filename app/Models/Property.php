<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Property extends Model
{
    use SoftDeletes;


    // ✅ اینجا باید قرار بگیرد

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
    'user_id',
    'approved_by',
    'approved_at',
    'rejection_reason',
];

    protected $casts = [
        'price' => 'float',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'area' => 'integer',
        'approved_at' => 'datetime',
    ];

 

    protected $hidden = [
        'deleted_at',
    ];

  public function user()
{
    return $this->belongsTo(User::class);
}

public function approver()
{
    return $this->belongsTo(User::class, 'approved_by');
}

    public function images()
    {
       return $this->hasMany(PropertyImage::class)->orderBy('id','desc');
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function compares()
    {
        return $this->hasMany(Compare::class);
    }
    public function messages()
{
    return $this->hasMany(Message::class);
}

// ======================
// 🔥 SCOPES (ENTERPRISE)
// ======================
public function scopeApproved($query)
{
    return $query->where('status', 'approved');
}

public function scopePending($query)
{
    return $query->where('status', 'pending');
}

public function scopeFilter($query, $filters)
{
    return $query
        ->when($filters['location'] ?? null, fn($q, $v) =>
            $q->where('location', 'like', "%$v%"))

        ->when($filters['purpose'] ?? null, fn($q, $v) =>
            $q->where('purpose', $v))

        ->when($filters['type'] ?? null, fn($q, $v) =>
            $q->where('type', $v));
}
}
