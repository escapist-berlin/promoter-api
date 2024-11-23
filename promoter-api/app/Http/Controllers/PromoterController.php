<?php

namespace App\Http\Controllers;

use App\Models\Promoter;
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
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthday_date' => 'required|date|before:today',
            'gender' => 'required|string|in:male,female,other',
            'email' => 'required|email|unique:promoters,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'availabilities' => 'nullable|array',
            'availabilities.*' => 'string|max:255',
        ]);

        $promoter = Promoter::create($validated);

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
    public function update(Request $request, Promoter $promoter)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthday_date' => 'required|date|before:today',
            'gender' => 'required|string|in:male,female,other',
            'email' => 'required|email|unique:promoters,email,' . $promoter->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'availabilities' => 'nullable|array',
            'availabilities.*' => 'string|max:255',
        ]);

        $promoter->update($validated);

        return response()->json([
            'ok' => true,
            'message' => 'Promoter updated successfully',
            'promoter' => $promoter,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promoter $promoter)
    {
        //
    }
}
