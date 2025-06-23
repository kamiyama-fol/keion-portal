<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BandMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'band_id',
        'member_id',
        'name',
        'part',
    ];

    /**
     * メンバー（ユーザー）とのリレーション
     */
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    /**
     * このメンバーが所属するバンドを取得
     */
    public function band()
    {
        return $this->belongsTo(Band::class);
    }
}
