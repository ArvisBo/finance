<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'created_user_id',
        'account_owner_id',
        'name',
        'account_number',

    ];

    // atlasa visus ielogotā lietotāja ierakstus. (šo vairs nevajag lietotāja ieraksti atlasīti ir GlobalScope)
    // public function scopeVisible (Builder $query) {
    //     $query->where('account_owner_id', auth()->id());
    // }

    // Define the relationship to User model
    public function accountOwner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'account_owner_id');
    }

    // Define the relationship to User model
    public function accountCreator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    // Konts var tikt sharots ar vairākiem lietotājiem. Tiek izmantot CreateAccount un EditAccount
    public function userPermissionsToAccount(): HasMany
    {
        return $this->hasMany(UserAccountPermission::class, 'account_id');
    }

    // kontam var būt vairāki ienākumi
    public function incomes(): HasMany
    {
        return $this->hasMany(Income::class);
    }

    // kontam var būt vairāki izdevumi
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    protected static function booted()
    {
    // šis nodrošina, ka var piekļūt saviem un shared kontiem.
        static::addGlobalScope('account_owner_or_shared_user', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where(function ($query) {
                    // Show accounts where the user is the account owner
                    $query->where('account_owner_id', auth()->id())
                        // Or where the account is shared with the user
                        ->orWhereHas('userPermissionsToAccount', function ($query) {
                            $query->where('user_id', auth()->id());
                        });
                });
            }
        });
    }
}
