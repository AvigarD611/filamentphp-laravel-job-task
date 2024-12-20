<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'canva_url',
        'ad_id',
    ];

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }
}
