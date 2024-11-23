<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PromoterGroup extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function promoters(): BelongsToMany
    {
        return $this->belongsToMany(Promoter::class, 'promoter_promoter_group', 'promoter_group_id', 'promoter_id')
            ->withTimestamps();
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'promoter_group_skill', 'promoter_group_id', 'skill_id')
            ->withTimestamps();
    }
}
