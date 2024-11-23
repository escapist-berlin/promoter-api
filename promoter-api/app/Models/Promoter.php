<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Promoter extends Model
{
    use HasFactory;
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

    public function promoterGroups(): BelongsToMany
    {
        return $this->belongsToMany(PromoterGroup::class, 'promoter_promoter_group', 'promoter_id', 'promoter_group_id');
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'promoter_skill', 'promoter_id', 'skill_id');
    }
}
