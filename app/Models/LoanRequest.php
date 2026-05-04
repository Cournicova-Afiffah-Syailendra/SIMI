<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanRequest extends Model
{
    protected $fillable = [
        'user_id',
        'borrower_name',
        'organization',
        'inventory_id',
        'duration_days',
        'surat_link',
        'bukti_transfer_url',  // ← tambah ini
        'surat_file_url',      // ← tambah ini
        'status',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
    public function returnItem()
    {
        return $this->hasOne(\App\Models\ReturnItem::class, 'loan_request_id');
    }
}
