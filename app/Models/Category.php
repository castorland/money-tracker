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

    public static function getCategoryTypes()
    {
        static::$types = [
            'expenses' => __('Expenses'),
            'incomes' => __('Incomes'),
            'savings' => __('Savings'),
            'loan' => __('Loan Repayment'),
        ];

        return static::$types;
    }
}
