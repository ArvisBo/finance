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
    public function scopeVisible (Builder $query) {
        $query->where('created_user_id', auth()->id());
    }

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
    // nodrošina, ka autorizētais lietotājs var piekļūt tikai tiem šī modeļa datiem, kur viņš ir created_user_id
        static::addGlobalScope('income_created_user', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where('created_user_id', auth()->id());
            }
        });
    }
}
