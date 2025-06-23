<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Live extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'held_date',
        'entry_due'
    ];

    protected $casts = [
        'held_date' => 'datetime',
        'entry_due' => 'datetime'
    ];

    /**
     * ライブに参加するバンドとのリレーション
     */
    public function bands()
    {
        return $this->hasMany(Band::class);
    }
}
