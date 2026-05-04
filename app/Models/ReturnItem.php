<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnItem extends Model
{
    protected $table = 'returns';

    protected $fillable = [
        'loan_request_id',
        'return_date',
        'denda',
        'status',
    ];

    public function loanRequest()
    {
        return $this->belongsTo(LoanRequest::class);
    }
}
