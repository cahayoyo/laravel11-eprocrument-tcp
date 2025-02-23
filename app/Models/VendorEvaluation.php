<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorEvaluation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'vendor_id',
        'quality_score',
        'timeline_score',
        'cooperation_score',
        'notes',
        'evaluated_by',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
