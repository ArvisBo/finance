<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeCategory extends Model
{
    use HasFactory;

        // Relationship to Income
        public function expenses()
        {
            return $this->hasMany(Income::class, 'category_id');
        }
}
