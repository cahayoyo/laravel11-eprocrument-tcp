<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialVendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'material_category_id',
        'vendor_id',
    ];

    public function materialCategory()
    {
        return $this->belongsTo(MaterialCategory::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
