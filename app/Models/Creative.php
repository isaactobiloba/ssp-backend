<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creative extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_url',
        'campaign_id',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
