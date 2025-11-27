<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'contact',
    'address',
    'survival_rate',
  ];

  protected $casts = [
    'survival_rate' => 'decimal:2',
  ];

  public function purchases()
  {
    return $this->hasMany(Purchase::class);
  }

  public function getTotalPurchaseAmountAttribute()
  {
    return $this->purchases()->sum('total_cost');
  }

  public function getAverageFishQualityAttribute()
  {
    // Bisa dikembangkan dengan logic lebih kompleks
    return $this->survival_rate;
  }
}
