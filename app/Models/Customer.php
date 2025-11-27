<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'phone',
    'address',
    'purchase_count',
  ];

  protected $casts = [
    'purchase_count' => 'integer',
  ];

  public function sales()
  {
    return $this->hasMany(Sale::class);
  }

  public function getTotalPurchaseAmountAttribute()
  {
    return $this->sales()->sum('total_amount');
  }

  public function getLastPurchaseDateAttribute()
  {
    return $this->sales()->latest('sale_date')->first()?->sale_date;
  }
}
