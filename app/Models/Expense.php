<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
  use HasFactory;

  protected $fillable = [
    'category',
    'description',
    'amount',
    'expense_date',
  ];

  protected $casts = [
    'amount' => 'decimal:2',
    'expense_date' => 'datetime',
  ];

  // Category labels untuk display
  public static $categories = [
    'pakan' => '🥘 Pakan',
    'listrik' => '⚡ Listrik',
    'air_treatment' => '💧 Air & Treatment',
    'gaji' => '👤 Gaji Karyawan',
    'sewa' => '🏠 Sewa Toko',
    'peralatan' => '🔧 Peralatan',
    'maintenance' => '🛠️ Maintenance',
    'lainnya' => '📝 Lainnya',
  ];

  public function getCategoryLabelAttribute()
  {
    return self::$categories[$this->category] ?? $this->category;
  }

  // Scope untuk filter by category
  public function scopeByCategory($query, $category)
  {
    return $query->where('category', $category);
  }

  // Scope untuk filter by month
  public function scopeByMonth($query, $month, $year = null)
  {
    $year = $year ?? now()->year;
    return $query->whereMonth('expense_date', $month)
      ->whereYear('expense_date', $year);
  }
}
