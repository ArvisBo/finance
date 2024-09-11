<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAccountRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_id',
        'role_id',
    ];
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function permission(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
