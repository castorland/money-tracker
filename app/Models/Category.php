<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
    ];

    public static $types = [];

    public static function getCategoryTypes($slug = null)
    {
        static::$types = [
            'expenses' => __('Expenses'),
            'incomes' => __('Incomes'),
            'savings' => __('Savings'),
            'loans' => __('Loan Repayment'),
        ];

        if ($slug) {
            return static::$types[$slug];
        }
        return static::$types;
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
