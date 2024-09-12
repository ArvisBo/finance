<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_user_id',
        'expense_name',
        'expense_date',
        'expense_category_id',
        'account_id',
        'count',
        'unit_price',
        'total_price',
        'file',
        'additional_information',
        'warranty_until',
    ];

    // atlasa visus ielogotā lietotāja ierakstus.
    // public function scopeVisible (Builder $query) {
    //     $query->where('created_user_id', auth()->id());
    // }

    public function expenseCreator()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    public function expenseAccount()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }


    // Nodrošina, ka modeļa lauka "file" vērtība tiek saglabāta, kā string
    protected $casts = [
        'file' => 'string',
    ];

    // "Booted" metode tiks izmantota, lai piesaistītu "deleting" notikuma klausītāju
    protected static function booted()
    {
        static::deleting(function ($expense) {
            // Pārbauda vai expense ir pievienots fails
            if ($expense->file) {
                // Izdzēš failu no glabātuves
                Storage::disk('public')->delete($expense->file);
            }
        });
    // nodrošina, ka autorizētais lietotājs var piekļūt tikai tiem šī modeļa datiem, kur viņš ir created_user_id
        // static::addGlobalScope('expense_created_user', function (Builder $builder) {
        //     if (auth()->check()) {
        //         $builder->where('created_user_id', auth()->id());
        //     }
        // });

        static::addGlobalScope('expense_access', function (Builder $builder) {
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
