<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'created_user_id',
        'user_id',
        'category_id',
        'product_name',
        'date',
        'count',
        'price',
        'total_price',
        'receipt_image',
        'additional_information',
        'warranty_until',
    ];

    // Define the relationship to User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define the relationship to ExpenseCategory model
    public function expencecategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }
}
