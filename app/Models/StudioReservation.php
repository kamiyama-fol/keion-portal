<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;



class StudioReservation extends Model
{
    use HasFactory;
    use SoftDeletes; // 論理削除を有効化

    protected $fillable = ['use_datetime', 'reserved_user_id', 'reserved_band_id', 'studio_id'];



    protected $dates = ['deleted_at'];

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
