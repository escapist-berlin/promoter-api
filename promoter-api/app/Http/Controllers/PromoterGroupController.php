<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrUpdatePromoterGroupRequest;
use App\Models\PromoterGroup;
use Illuminate\Http\Request;

class PromoterGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promoterGroups = PromoterGroup::with(['promoters', 'skills'])->get();

        return response()->json([
            "ok" => true,
            "promoterGroups" => $promoterGroups
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrUpdatePromoterGroupRequest $request)
    {
        $promoterGroup = PromoterGroup::create($request->validated());

        $this->syncRelationships($promoterGroup, $request);

        return response()->json([
            'ok' => true,
            'message' => 'Promoter group created successfully',
            'promoter' => $promoterGroup->load(['skills', 'promoters']),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(PromoterGroup $promoterGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreOrUpdatePromoterGroupRequest $request, PromoterGroup $promoterGroup)
    {
        $promoterGroup->update($request->validated());

        $this->syncRelationships($promoterGroup, $request);

        return response()->json([
            'ok' => true,
            'message' => 'Promoter group updated successfully',
            'promoter_group' => $promoterGroup->load(['skills', 'promoters']),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PromoterGroup $promoterGroup)
    {
        //
    }

    /**
     * Sync skills and promoters for the given promoter group.
     *
     * @param PromoterGroup $promoterGroup
     * @param StoreOrUpdatePromoterGroupRequest $request
     */
    private function syncRelationships(PromoterGroup $promoterGroup, StoreOrUpdatePromoterGroupRequest $request): void
    {
        if ($request->filled('skill_ids')) {
            $promoterGroup->skills()->sync($request->input('skill_ids'));
        }

        if ($request->filled('promoter_ids')) {
            $promoterGroup->promoters()->sync($request->input('promoter_ids'));
        }
    }
}
