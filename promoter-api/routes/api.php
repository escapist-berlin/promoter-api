<?php

use App\Http\Controllers\PromoterController;
use App\Http\Controllers\PromoterGroupController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    'promoters' => PromoterController::class,
    'promoter-groups' => PromoterGroupController::class,
    'skills' => SkillController::class,
]);

// The route for adding a skill to the promoter's profile after completing a course
Route::post('/promoters/{promoter}/skills', [PromoterController::class, 'addSkillToPromoter']);
