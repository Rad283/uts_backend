<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class patients extends Model
{
    use HasFactory;

    // mengatur data pasien yang dapat diisi
    protected $fillable = [
        'name', 'phone', 'address', 'status', 'in_date_at', 'out_date_at'
    ];
}
