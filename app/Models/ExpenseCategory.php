<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'created_user_id',
        'expense_category_name',
        'is_visible',
    ];

    public function scopeVisible (Builder $query) {
        $query->where('is_visible', 1);
    }

    public function expenseCategoryCreator()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }
}
