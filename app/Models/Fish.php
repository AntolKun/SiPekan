<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fish extends Model
{
  use HasFactory;

  protected $table = 'fish';

  protected $fillable = [
    'name',
    'type',
    'size',
    'color',
    'stock',
    'purchase_price',
    'selling_price',
    'tank_location',
    'health_status',
    'photo',
    'minimum_stock',
  ];

  protected $casts = [
    'stock' => 'integer',
    'purchase_price' => 'decimal:2',
    'selling_price' => 'decimal:2',
    'minimum_stock' => 'integer',
  ];

  public function saleItems()
  {
    return $this->hasMany(SaleItem::class);
  }

  public function purchases()
  {
    return $this->hasMany(Purchase::class);
  }

  public function mortalityRecords()
  {
    return $this->hasMany(MortalityRecord::class);
  }

  public function quarantineRecords()
  {
    return $this->hasMany(QuarantineRecord::class);
  }

  public function isLowStock()
  {
    return $this->stock < $this->minimum_stock;
  }

  public function getProfitMarginAttribute()
  {
    if ($this->selling_price == 0) return 0;
    return (($this->selling_price - $this->purchase_price) / $this->selling_price) * 100;
  }

  public function isInQuarantine()
  {
    return $this->health_status === 'karantina';
  }

  public function isSick()
  {
    return $this->health_status === 'sakit';
  }

  public function isHealthy()
  {
    return $this->health_status === 'sehat';
  }
}
