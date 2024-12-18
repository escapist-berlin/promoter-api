<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Skill extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
    ];

    public function promoters(): BelongsToMany
    {
        return $this->belongsToMany(Promoter::class, 'promoter_skill', 'skill_id', 'promoter_id')
            ->withTimestamps();
    }

    public function promoterGroups(): BelongsToMany
    {
        return $this->belongsToMany(PromoterGroup::class, 'promoter_group_skill', 'skill_id', 'promoter_group_id')
            ->withTimestamps();
    }
}
