<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MortalityRecord extends Model
{
  use HasFactory;

  protected $fillable = [
    'fish_id',
    'quantity',
    'reason',
    'loss_amount',
    'recorded_date',
  ];

  protected $casts = [
    'quantity' => 'integer',
    'loss_amount' => 'decimal:2',
    'recorded_date' => 'datetime',
  ];

  public function fish()
  {
    return $this->belongsTo(Fish::class);
  }

  // Auto calculate loss amount based on fish purchase price
  protected static function boot()
  {
    parent::boot();

    static::creating(function ($mortality) {
      if (!$mortality->loss_amount && $mortality->fish) {
        $mortality->loss_amount = $mortality->quantity * $mortality->fish->purchase_price;
      }
    });

    // Update fish stock when mortality recorded
    static::created(function ($mortality) {
      $mortality->fish->decrement('stock', $mortality->quantity);
    });
  }

  // Common mortality reasons
  public static $reasons = [
    'Penyakit',
    'Kualitas Air Buruk',
    'Stres Transport',
    'Serangan Hama',
    'Usia Tua',
    'Kecelakaan',
    'Tidak Diketahui',
  ];
}
