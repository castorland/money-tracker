<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
            'loan' => __('Loan Repayment'),
        ];

        if ($slug) {
            return static::$types[$slug];
        }
        return static::$types;
    }
}
