<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrUpdateSkillRequest;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $skills = Skill::with(['promoters', 'promoterGroups'])->get();

        return response()->json([
            "ok" => true,
            "skills" => $skills
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrUpdateSkillRequest $request): JsonResponse
    {
        $skill = Skill::create($request->only(['name', 'description']));

        if ($request->has('promoter_group_ids')) {
            $skill->promoterGroups()->sync($request->input('promoter_group_ids'));
        }

        return response()->json([
            'message' => 'Skill created successfully',
            'skill' => $skill->load('promoterGroups'),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        $skill->load(['promoters', 'promoterGroups']);

        return response()->json([
            "ok" => true,
            "skill" => $skill
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreOrUpdateSkillRequest $request, Skill $skill): JsonResponse
    {
        $skill->update($request->only(['name', 'description']));

        if ($request->has('promoter_group_ids')) {
            $skill->promoterGroups()->sync($request->input('promoter_group_ids'));
        }

        return response()->json([
            'message' => 'Skill updated successfully',
            'skill' => $skill->load('promoterGroups'),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill): JsonResponse
    {
        $skill->delete();

        return response()->json([
            'message' => 'Skill deleted successfully',
        ], 200);
    }
}
