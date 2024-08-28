<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
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
        'date',
        'amount',
        'additional_information',
    ];
    // atlasa visus ielogotā lietotāja ierakstus.
    public function scopeVisible (Builder $query) {
        $query->where('user_id', auth()->id());
    }
    // izveidots gadījumam, ja Income formā tiks pievienots ievadlaugs "tags input"
    // protected $casts = [
    //     'tags' => 'array',
    // ];

        // Define the relationship to User model
        public function user()
        {
            return $this->belongsTo(User::class, 'user_id');
        }

        // Define the relationship to IncomeCategory model
        public function incomecategory()
        {
            return $this->belongsTo(IncomeCategory::class, 'category_id');
        }
}
