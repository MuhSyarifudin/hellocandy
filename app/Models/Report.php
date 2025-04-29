<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_name',
        'report_date',
        'status',
        'note',
        'user_id'
    ];

    protected $casts = [
        'report_date' => 'datetime',
    ];

    // Relasi banyak ke satu (Laporan dibuat oleh satu pengguna)
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relasi satu ke banyak (Laporan memiliki banyak detail laporan)
    public function reportDetails() {
        return $this->hasMany(ReportDetail::class);
    }

    public function weeklyReports()
    {
        return $this->hasMany(WeeklyReport::class);
    }
}