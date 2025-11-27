<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
  use HasFactory;

  protected $fillable = [
    'supplier_id',
    'fish_id',
    'quantity',
    'price_per_unit',
    'transport_cost',
    'total_cost',
    'purchase_date',
  ];

  protected $casts = [
    'quantity' => 'integer',
    'price_per_unit' => 'decimal:2',
    'transport_cost' => 'decimal:2',
    'total_cost' => 'decimal:2',
    'purchase_date' => 'datetime',
  ];

  public function supplier()
  {
    return $this->belongsTo(Supplier::class);
  }

  public function fish()
  {
    return $this->belongsTo(Fish::class);
  }

  // Auto calculate total cost
  protected static function boot()
  {
    parent::boot();

    static::saving(function ($purchase) {
      $purchase->total_cost = ($purchase->quantity * $purchase->price_per_unit) + $purchase->transport_cost;
    });
  }

  public function getUnitCostAttribute()
  {
    if ($this->quantity == 0) return 0;
    return $this->total_cost / $this->quantity;
  }
}
