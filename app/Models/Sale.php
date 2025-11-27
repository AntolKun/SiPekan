<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
  use HasFactory;

  protected $fillable = [
    'customer_id',
    'total_amount',
    'discount',
    'payment_method',
    'notes',
    'sale_date',
  ];

  protected $casts = [
    'total_amount' => 'decimal:2',
    'discount' => 'decimal:2',
    'sale_date' => 'datetime',
  ];

  public function customer()
  {
    return $this->belongsTo(Customer::class);
  }

  public function items()
  {
    return $this->hasMany(SaleItem::class);
  }

  public function getNetAmountAttribute()
  {
    return $this->total_amount - $this->discount;
  }
}
