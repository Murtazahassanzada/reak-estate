<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'property_id',
        'report_type',
        'notes',
    ];

    // 🔥 relationship
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
