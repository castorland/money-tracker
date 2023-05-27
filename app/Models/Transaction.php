<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'category_id',
        'is_recurring',
        'recurring_frequency',
        'recurring_on',
    ];

    protected $casts = [
        'is_recurring' => 'boolean',
    ];
}
