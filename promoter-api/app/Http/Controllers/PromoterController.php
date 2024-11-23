<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrUpdatePromoterRequest;
use App\Models\Promoter;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PromoterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $promoters = Promoter::with(['promoterGroups', 'skills'])->get();

        return response()->json([
            "ok" => true,
            "promoters" => $promoters
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrUpdatePromoterRequest $request): JsonResponse
    {
        $promoter = Promoter::create($request->validated());

        return response()->json([
            'ok' => true,
            'message' => 'Promoter registered successfully',
            'promoter' => $promoter,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Promoter $promoter): JsonResponse
    {
        $promoter->load(['promoterGroups', 'skills']);

        return response()->json([
            "ok" => true,
            "promoter" => $promoter
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreOrUpdatePromoterRequest $request, Promoter $promoter): JsonResponse
    {
        $promoter->update($request->validated());

        return response()->json([
            'ok' => true,
            'message' => 'Promoter updated successfully',
            'promoter' => $promoter,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promoter $promoter): JsonResponse
    {
        $promoter->delete();

        return response()->json([
            'message' => 'Promoter deleted successfully'
        ], 200);
    }

    /**
     * Add a skill to a promoter's profile after course completion.
     *
     * This method associates a specific skill with a promoter. The promoter's profile
     * will be updated with the new skill.
     *
     * @param Request $request
     * @param Promoter $promoter
     */
    public function addSkillToPromoter(Request $request, Promoter $promoter): JsonResponse
    {
        $skill = Skill::findOrFail($request->input('skill_id'));

        $promoter->skills()->attach($skill->id);

        return response()->json([
            'message' => 'Skill successfully added to promoter.',
        ], 200);
    }
}
