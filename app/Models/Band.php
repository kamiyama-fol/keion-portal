<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Band extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'made_by',
        'vote',
        'live_id'
    ];

    /**
     * バンドを作成したユーザーとのリレーション
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'made_by');
    }

    /**
     * ライブとのリレーション
     */
    public function live()
    {
        return $this->belongsTo(Live::class);
    }

    /**
     * バンドメンバーとのリレーション
     */
    public function members()
    {
        return $this->hasMany(BandMember::class);
    }
}
