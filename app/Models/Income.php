<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_user_id',
        'income_category_id',
        'account_id',
        'income_date',
        'amount',
        'description',
    ];

    // atlasa visus ielogotā lietotāja ierakstus.
    // public function scopeVisible (Builder $query) {
    //     $query->where('created_user_id', auth()->id());
    // }

    public function incomeCreator()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function incomeCategory()
    {
        return $this->belongsTo(IncomeCategory::class, 'income_category_id');
    }

    public function incomeAccount()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    protected static function booted()
    {
        static::addGlobalScope('income_access', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where(function ($query) {
                    $query->whereIn('account_id', function ($subQuery) {
                        $subQuery->select('id')
                            ->from('accounts')
                            ->where('account_owner_id', auth()->id());
                    })
                    ->orWhereIn('account_id', function ($subQuery) {
                        $subQuery->select('account_id')
                            ->from('user_account_permissions')
                            ->where('user_id', auth()->id());
                    });
                });
            }
        });
    }
}
