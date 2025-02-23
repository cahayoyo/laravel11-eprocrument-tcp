<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contract_id',
        'amount',
        'payment_date',
        'payment_type',
        'description',
        'proof_document',
        'status',
        'approved_by',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
