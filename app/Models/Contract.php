<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tender_id',
        'vendor_id',
        'proposal_id',
        'contract_number',
        'contract_amount',
        'start_date',
        'end_date',
        'terms_and_conditions',
        'status',
        'signed_at',
    ];

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
