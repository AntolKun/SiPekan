<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
  use HasFactory;

  protected $fillable = [
    'sale_id',
    'fish_id',
    'quantity',
    'price',
    'subtotal',
  ];

  protected $casts = [
    'quantity' => 'integer',
    'price' => 'decimal:2',
    'subtotal' => 'decimal:2',
  ];

  public function sale()
  {
    return $this->belongsTo(Sale::class);
  }

  public function fish()
  {
    return $this->belongsTo(Fish::class);
  }
}
