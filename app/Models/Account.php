<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    // atlasa visus ielogotā lietotāja ierakstus.
    public function scopeVisible (Builder $query) {
        $query->where('account_owner_id', auth()->id());
    }

        // Define the relationship to User model
        public function accountOwner()
        {
            return $this->belongsTo(User::class, 'account_owner_id');
        }

        // Define the relationship to User model
        public function accountCreator()
        {
            return $this->belongsTo(User::class, 'created_user_id');
        }

    protected static function booted()
    {
    // nodrošina, ka autorizētais lietotājs var piekļūt tikai tiem šī modeļa datiem, kur viņš ir created_user_id
        static::addGlobalScope('account_owner_user', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where('account_owner_id', auth()->id());
            }
        });
    }

}
