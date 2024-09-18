<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser



{


    use HasFactory, SoftDeletes, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'is_admin',
        'default_account_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
        // return str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
    }

        // atlasa visus ielogotā lietotāja ierakstus.
    public function scopeVisible (Builder $query) {
        if (auth()->user()->is_admin) {
            return $query;
        } else {
            return $query->where('id', auth()->id());
        }
    }

    // lietotājam ir viens noklusējuma konts
    public function defaultAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'default_account_id');
    }

    // lietotājam var būt vairāki konti
    public function ownedAccounts(): HasMany
    {
        return $this->hasMany(Account::class, 'account_owner_id');
    }

    // lietotāji var veidot vairākus kontus
    public function createdAccounts(): HasMany
    {
        return $this->hasMany(Account::class, 'created_user_id');
    }

    // lietotājam var būt vairākas izdevumu categorijas
    public function createdExpenseCategory(): HasMany
    {
        return $this->hasMany(ExpenseCategory::class, 'created_user_id');
    }

    // lietotājam var būt vairākas ienākumu categorijas
    public function createdIncomeCategory(): HasMany
    {
        return $this->hasMany(IncomeCategory::class, 'created_user_id');
    }
}
