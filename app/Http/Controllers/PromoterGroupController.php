<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrUpdatePromoterGroupRequest;
use App\Models\PromoterGroup;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Promoter groups",
 *     description="Operations related to promoter groups"
 * )
 */
class PromoterGroupController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/promoter-groups",
     *     summary="Get all promoter groups with their related promoters and skills",
     *     description="Retrieve a list of all promoter groups, including their associated promoters and skills.",
     *     tags={"Promoter Groups"},
     *     @OA\Response(
     *         response=200,
     *         description="List of promoter groups retrieved successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="ok", type="boolean", example=true),
     *             @OA\Property(
     *                 property="promoterGroups",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Latte-Art Baristas"),
     *                     @OA\Property(property="description", type="string", example="Diese Gruppe besteht aus Baristas, die sich durch ihre Latte-Art-Fähigkeiten auszeichnen..."),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                     @OA\Property(
     *                         property="promoters",
     *                         type="array",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="first_name", type="string", example="Maude"),
     *                             @OA\Property(property="last_name", type="string", example="Eichmann"),
     *                             @OA\Property(property="birthday_date", type="string", format="date-time", example="1991-08-13T00:00:00.000000Z"),
     *                             @OA\Property(property="gender", type="string", example="male"),
     *                             @OA\Property(property="email", type="string", example="gleichner.tatum@example.org"),
     *                             @OA\Property(property="phone", type="string", example="(667) 889-1013"),
     *                             @OA\Property(property="address", type="string", example="635 Wilford Well Suite 426\nMaribelshire, KS 57689-8866"),
     *                             @OA\Property(
     *                                 property="availabilities",
     *                                 type="array",
     *                                 @OA\Items(type="string"),
     *                                 example={"Sunday"}
     *                             ),
     *                             @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                             @OA\Property(
     *                                 property="pivot",
     *                                 type="object",
     *                                 @OA\Property(property="promoter_group_id", type="integer", example=1),
     *                                 @OA\Property(property="promoter_id", type="integer", example=1),
     *                                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z")
     *                             )
     *                         )
     *                     ),
     *                     @OA\Property(
     *                         property="skills",
     *                         type="array",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="name", type="string", example="Latte-Art-Zertifikat"),
     *                             @OA\Property(property="description", type="string", example="Fähigkeit, fortgeschrittene Latte-Art-Techniken zu beherrschen..."),
     *                             @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                             @OA\Property(
     *                                 property="pivot",
     *                                 type="object",
     *                                 @OA\Property(property="promoter_group_id", type="integer", example=1),
     *                                 @OA\Property(property="skill_id", type="integer", example=1),
     *                                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z")
     *                             )
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $promoterGroups = PromoterGroup::with(['promoters', 'skills'])->get();

        return response()->json([
            "ok" => true,
            "promoterGroups" => $promoterGroups
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/promoter-groups",
     *     summary="Create a new promoter group",
     *     description="Create a new promoter group and associate it with skills and promoters.",
     *     tags={"Promoter Groups"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "description"},
     *             @OA\Property(property="name", type="string", description="The name of the promoter group.", example="Outdoor-Abenteuer-Guides"),
     *             @OA\Property(property="description", type="string", description="A description of the promoter group.", example="Ein Team von erfahrenen Spezialisten für Outdoor-Aktivitäten wie Wandern, Camping und Survival-Training..."),
     *             @OA\Property(
     *                 property="skill_ids",
     *                 type="array",
     *                 description="An array of skill IDs to associate with the promoter group.",
     *                 @OA\Items(type="integer"),
     *                 example={1, 2}
     *             ),
     *             @OA\Property(
     *                 property="promoter_ids",
     *                 type="array",
     *                 description="An array of promoter IDs to associate with the promoter group.",
     *                 @OA\Items(type="integer"),
     *                 example={3}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Promoter group created successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="ok", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Promoter group created successfully"),
     *             @OA\Property(
     *                 property="promoter",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=7),
     *                 @OA\Property(property="name", type="string", example="Outdoor-Abenteuer-Guides"),
     *                 @OA\Property(property="description", type="string", example="Ein Team von erfahrenen Spezialisten für Outdoor-Aktivitäten wie Wandern, Camping und Survival-Training..."),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-25T21:56:11.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-25T21:56:11.000000Z"),
     *                 @OA\Property(
     *                     property="skills",
     *                     type="array",
     *                     description="The skills associated with the promoter group.",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Latte-Art-Zertifikat"),
     *                         @OA\Property(property="description", type="string", example="Fähigkeit, fortgeschrittene Latte-Art-Techniken zu beherrschen..."),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                         @OA\Property(
     *                             property="pivot",
     *                             type="object",
     *                             @OA\Property(property="promoter_group_id", type="integer", example=7),
     *                             @OA\Property(property="skill_id", type="integer", example=1),
     *                             @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-25T21:56:11.000000Z"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-25T21:56:11.000000Z")
     *                         )
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="promoters",
     *                     type="array",
     *                     description="The promoters associated with the promoter group.",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=3),
     *                         @OA\Property(property="first_name", type="string", example="Joanie"),
     *                         @OA\Property(property="last_name", type="string", example="Effertz"),
     *                         @OA\Property(property="birthday_date", type="string", format="date-time", example="2002-05-13T00:00:00.000000Z"),
     *                         @OA\Property(property="gender", type="string", example="male"),
     *                         @OA\Property(property="email", type="string", example="pierce.spencer@example.net"),
     *                         @OA\Property(property="phone", type="string", example="+1-424-457-1997"),
     *                         @OA\Property(property="address", type="string", example="719 Cruickshank Lodge Apt. 453\nEinarshire, NV 03629-9226"),
     *                         @OA\Property(
     *                             property="availabilities",
     *                             type="array",
     *                             @OA\Items(type="string"),
     *                             example={"Sunday", "Thursday", "Saturday", "Wednesday", "Monday"}
     *                         ),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                         @OA\Property(
     *                             property="pivot",
     *                             type="object",
     *                             @OA\Property(property="promoter_group_id", type="integer", example=7),
     *                             @OA\Property(property="promoter_id", type="integer", example=3),
     *                             @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-25T21:56:11.000000Z"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-25T21:56:11.000000Z")
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreOrUpdatePromoterGroupRequest $request): JsonResponse
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
     * @OA\Get(
     *     path="/api/promoter-groups/{promoter_group_id}",
     *     summary="Get a specific promoter group with related promoters and skills",
     *     description="Retrieve details of a specific promoter group by its ID, including associated promoters and skills.",
     *     tags={"Promoter Groups"},
     *     @OA\Parameter(
     *         name="promoter_group_id",
     *         in="path",
     *         required=true,
     *         description="The ID of the promoter group to retrieve.",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Promoter group retrieved successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="ok", type="boolean", example=true),
     *             @OA\Property(
     *                 property="promoterGroup",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Latte-Art Baristas"),
     *                 @OA\Property(property="description", type="string", example="Diese Gruppe besteht aus Baristas, die sich durch ihre Latte-Art-Fähigkeiten auszeichnen..."),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                 @OA\Property(
     *                     property="promoters",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="first_name", type="string", example="Maude"),
     *                         @OA\Property(property="last_name", type="string", example="Eichmann"),
     *                         @OA\Property(property="birthday_date", type="string", format="date-time", example="1991-08-13T00:00:00.000000Z"),
     *                         @OA\Property(property="gender", type="string", example="male"),
     *                         @OA\Property(property="email", type="string", example="gleichner.tatum@example.org"),
     *                         @OA\Property(property="phone", type="string", example="(667) 889-1013"),
     *                         @OA\Property(property="address", type="string", example="635 Wilford Well Suite 426\nMaribelshire, KS 57689-8866"),
     *                         @OA\Property(
     *                             property="availabilities",
     *                             type="array",
     *                             @OA\Items(type="string"),
     *                             example={"Sunday"}
     *                         ),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                         @OA\Property(
     *                             property="pivot",
     *                             type="object",
     *                             @OA\Property(property="promoter_group_id", type="integer", example=1),
     *                             @OA\Property(property="promoter_id", type="integer", example=1),
     *                             @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z")
     *                         )
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="skills",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Latte-Art-Zertifikat"),
     *                         @OA\Property(property="description", type="string", example="Fähigkeit, fortgeschrittene Latte-Art-Techniken zu beherrschen..."),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                         @OA\Property(
     *                             property="pivot",
     *                             type="object",
     *                             @OA\Property(property="promoter_group_id", type="integer", example=1),
     *                             @OA\Property(property="skill_id", type="integer", example=1),
     *                             @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z")
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function show(PromoterGroup $promoterGroup): JsonResponse
    {
        $promoterGroup->load(['promoters', 'skills']);

        return response()->json([
            "ok" => true,
            "promoterGroup" => $promoterGroup
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/promoter-groups/{promoter_group_id}",
     *     summary="Update a promoter group",
     *     description="Update the details of a specific promoter group by its ID, including updating associated skills and promoters.",
     *     tags={"Promoter Groups"},
     *     @OA\Parameter(
     *         name="promoter_group_id",
     *         in="path",
     *         required=true,
     *         description="The ID of the promoter group to update.",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "description"},
     *             @OA\Property(property="name", type="string", description="The updated name of the promoter group.", example="Urban Adventure Guides"),
     *             @OA\Property(property="description", type="string", description="The updated description of the promoter group.", example="Ein Team von Experten für urbane Erkundungen, das Gruppen durch Stadtabenteuer wie Street Art-Touren und Nachtwanderungen führt."),
     *             @OA\Property(
     *                 property="skill_ids",
     *                 type="array",
     *                 description="An array of updated skill IDs to associate with the promoter group.",
     *                 @OA\Items(type="integer"),
     *                 example={3, 4}
     *             ),
     *             @OA\Property(
     *                 property="promoter_ids",
     *                 type="array",
     *                 description="An array of updated promoter IDs to associate with the promoter group.",
     *                 @OA\Items(type="integer"),
     *                 example={1}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Promoter group updated successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="ok", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Promoter group updated successfully"),
     *             @OA\Property(
     *                 property="promoter_group",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=5),
     *                 @OA\Property(property="name", type="string", example="Urban Adventure Guides"),
     *                 @OA\Property(property="description", type="string", example="Ein Team von Experten für urbane Erkundungen, das Gruppen durch Stadtabenteuer wie Street Art-Touren und Nachtwanderungen führt."),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-25T22:30:26.000000Z"),
     *                 @OA\Property(
     *                     property="skills",
     *                     type="array",
     *                     description="The updated skills associated with the promoter group.",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=3),
     *                         @OA\Property(property="name", type="string", example="Bedienung von Siebträgermaschinen"),
     *                         @OA\Property(property="description", type="string", example="Fachkenntnisse im professionellen Umgang mit Siebträgermaschinen..."),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                         @OA\Property(
     *                             property="pivot",
     *                             type="object",
     *                             @OA\Property(property="promoter_group_id", type="integer", example=5),
     *                             @OA\Property(property="skill_id", type="integer", example=3),
     *                             @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-25T22:30:26.000000Z"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-25T22:30:26.000000Z")
     *                         )
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="promoters",
     *                     type="array",
     *                     description="The updated promoters associated with the promoter group.",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="first_name", type="string", example="Maude"),
     *                         @OA\Property(property="last_name", type="string", example="Eichmann"),
     *                         @OA\Property(property="birthday_date", type="string", format="date-time", example="1991-08-13T00:00:00.000000Z"),
     *                         @OA\Property(property="gender", type="string", example="male"),
     *                         @OA\Property(property="email", type="string", example="gleichner.tatum@example.org"),
     *                         @OA\Property(property="phone", type="string", example="(667) 889-1013"),
     *                         @OA\Property(property="address", type="string", example="635 Wilford Well Suite 426\nMaribelshire, KS 57689-8866"),
     *                         @OA\Property(
     *                             property="availabilities",
     *                             type="array",
     *                             @OA\Items(type="string"),
     *                             example={"Sunday"}
     *                         ),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                         @OA\Property(
     *                             property="pivot",
     *                             type="object",
     *                             @OA\Property(property="promoter_group_id", type="integer", example=5),
     *                             @OA\Property(property="promoter_id", type="integer", example=1),
     *                             @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-25T22:30:26.000000Z"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-25T22:30:26.000000Z")
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function update(StoreOrUpdatePromoterGroupRequest $request, PromoterGroup $promoterGroup): JsonResponse
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
     * @OA\Delete(
     *     path="/api/promoter-groups/{promoter_group_id}",
     *     summary="Delete a promoter group",
     *     description="Delete a specific promoter group by its ID.",
     *     tags={"Promoter Groups"},
     *     @OA\Parameter(
     *         name="promoter_group_id",
     *         in="path",
     *         required=true,
     *         description="The ID of the promoter group to delete.",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Promoter group deleted successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Promoter group deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Promoter group not found.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Promoter group not found.")
     *         )
     *     )
     * )
     */
    public function destroy(PromoterGroup $promoterGroup): JsonResponse
    {
        $promoterGroup->delete();

        return response()->json([
            'message' => 'Promoter group deleted successfully',
        ], 200);
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
