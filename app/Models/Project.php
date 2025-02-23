<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contract_id',
        'manager_id',
        'name',
        'description',
        'progress_percentage',
        'start_date',
        'end_date',
        'status',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class);
    }
}
