<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'total_sales',
        'total_expenses',
        'period_start',
        'period_end'
    ];

    // Relasi banyak ke satu (Detail laporan terkait dengan satu laporan)
    public function report() {
        return $this->belongsTo(Report::class);
    }
}