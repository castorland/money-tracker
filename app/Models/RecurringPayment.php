<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecurringPayment extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_id', 'next_due'];

    protected $casts = [
        'next_due' => 'date:Y-m-d',
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
