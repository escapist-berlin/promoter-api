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
        return response()->json(["ok" => true, "promoters" => Promoter::all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Promoter $promoter): JsonResponse
    {
        return response()->json(["ok" => true, "promoter" => $promoter], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promoter $promoter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promoter $promoter)
    {
        //
    }
}
