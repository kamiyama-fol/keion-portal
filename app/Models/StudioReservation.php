<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudioReservation extends Model
{
    use HasFactory;

    protected $fillable = ['datetime', 'reserved_person', 'reserved_band', 'studio'];
}