<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class StudioReservation extends Model
{
    use HasFactory;

    protected $fillable = ['use_datetime', 'reserved_user_id', 'reserved_band_id', 'studio_id'];

    //Carbonで日付対応させる
    protected function casts(): array{
        return [
            'use_datetime' => 'datetime'
        ];
    }

    // ユーザーとのリレーション
    public function reservedUser()
    {
        return $this->belongsTo(User::class, 'reserved_user_id');
    }

    // スタジオとのリレーション
    public function studio()
    {
        return $this->belongsTo(Studio::class, 'studio_id');
    }
}
