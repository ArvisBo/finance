<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;

      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_name',
        'category_type_id',
        'is_visible',
    ];

    // Relationship to Expenses
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'category_id');
    }

}
