<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promoter extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'birthday_date',
        'gender',
        'email',
        'phone',
        'address',
        'availabilities',
    ];

    protected function casts(): array
    {
        return [
            'birthday_date' => 'date',
            'availabilities' => 'array',
        ];
    }
}
