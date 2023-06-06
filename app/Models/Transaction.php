<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'category_id',
        'note',
        'transaction_date',
        'is_recurring',
        'recurring_frequency',
        'recurring_period',
        'recurring_on',
    ];

    protected $casts = [
        'is_recurring' => 'boolean',
        'transaction_date' => 'date:Y-m-d',
        'recurring_on' => 'date:Y-m-d',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function recurring(): HasOne
    {
        return $this->hasOne(RecurringPayment::class);
    }

    public function getNextPaymentAttribute($attr)
    {
        if ($this->is_recurring) {
            $dateString = $this->recurring_frequency . ' ' . $this->recurring_period;
            $interval = \DateInterval::createFromDateString($dateString);
            $date = new \DateTime($this->recurring_on);
            return $date->add($interval)->format('Y-m-d');
        }
    }
}
