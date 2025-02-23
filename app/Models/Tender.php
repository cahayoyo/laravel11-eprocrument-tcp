<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tender extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'requirements',
        'budget_amount',
        'start_date',
        'end_date',
        'status',
        'created_by',
    ];

    public function category()
    {
        return $this->belongsTo(TenderCategory::class);
    }
}
