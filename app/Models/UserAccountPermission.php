<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserAccountPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_id',
        'permission_id',
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
        return $this->belongsTo(Permission::class);
    }
}
