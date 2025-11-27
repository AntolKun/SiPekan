<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuarantineRecord extends Model
{
  use HasFactory;

  protected $fillable = [
    'fish_id',
    'quantity',
    'start_date',
    'end_date',
    'treatment',
    'status',
  ];

  protected $casts = [
    'quantity' => 'integer',
    'start_date' => 'datetime',
    'end_date' => 'datetime',
  ];

  public function fish()
  {
    return $this->belongsTo(Fish::class);
  }

  // Scope untuk quarantine yang masih aktif
  public function scopeActive($query)
  {
    return $query->where('status', 'aktif');
  }

  // Scope untuk quarantine yang sudah selesai
  public function scopeCompleted($query)
  {
    return $query->where('status', 'selesai');
  }

  // Get quarantine duration in days
  public function getDurationAttribute()
  {
    if (!$this->end_date) {
      return $this->start_date->diffInDays(now());
    }
    return $this->start_date->diffInDays($this->end_date);
  }

  // Check if quarantine is overdue (more than 14 days)
  public function isOverdue()
  {
    return $this->status === 'aktif' && $this->start_date->diffInDays(now()) > 14;
  }

  // Auto update fish health status when quarantine created
  protected static function boot()
  {
    parent::boot();

    static::created(function ($quarantine) {
      $quarantine->fish->update(['health_status' => 'karantina']);
    });

    static::updated(function ($quarantine) {
      if ($quarantine->status === 'selesai') {
        $quarantine->fish->update(['health_status' => 'sehat']);
      }
    });
  }
}
