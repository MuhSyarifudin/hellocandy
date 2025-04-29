<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'week_number',
        'total_sales',
        'total_expenses',
    ];

    /**
     * Get the report that owns the weekly report.
     */
    public function report()
    {
        return $this->belongsTo(Report::class);
    }
    
}