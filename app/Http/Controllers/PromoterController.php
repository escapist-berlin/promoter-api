<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrUpdatePromoterRequest;
use App\Models\Promoter;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Promoters",
 *     description="Operations related to promoters"
 * )
 */

class PromoterController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/promoters/",
     *     summary="Retrieve a list of promoters",
     *     description="Fetches all promoters along with their associated promoter groups and skills.",
     *     operationId="getPromoters",
     *     tags={"Promoters"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of promoters",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="ok",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="promoters",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="first_name", type="string", example="Maude"),
     *                     @OA\Property(property="last_name", type="string", example="Eichmann"),
     *                     @OA\Property(property="birthday_date", type="string", format="date", example="1991-08-13"),
     *                     @OA\Property(property="gender", type="string", example="male"),
     *                     @OA\Property(property="email", type="string", format="email", example="gleichner.tatum@example.org"),
     *                     @OA\Property(property="phone", type="string", example="(667) 889-1013"),
     *                     @OA\Property(property="address", type="string", example="635 Wilford Well Suite 426\nMaribelshire, KS 57689-8866"),
     *                     @OA\Property(
     *                         property="availabilities",
     *                         type="array",
     *                         @OA\Items(type="string", example="Sunday")
     *                     ),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                     @OA\Property(
     *                         property="promoter_groups",
     *                         type="array",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="name", type="string", example="Latte-Art Baristas"),
     *                             @OA\Property(property="description", type="string", example="Diese Gruppe besteht aus Baristas, die sich durch ihre Latte-Art-Fähigkeiten auszeichnen."),
     *                             @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                             @OA\Property(
     *                                 property="pivot",
     *                                 type="object",
     *                                 @OA\Property(property="promoter_id", type="integer", example=1),
     *                                 @OA\Property(property="promoter_group_id", type="integer", example=1),
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
     *                             @OA\Property(property="description", type="string", example="Fähigkeit, fortgeschrittene Latte-Art-Techniken zu beherrschen."),
     *                             @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                             @OA\Property(
     *                                 property="pivot",
     *                                 type="object",
     *                                 @OA\Property(property="promoter_id", type="integer", example=1),
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
        $promoters = Promoter::with(['promoterGroups', 'skills'])->get();

        return response()->json([
            "ok" => true,
            "promoters" => $promoters
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/promoters/",
     *     summary="Create a new promoter",
     *     description="Creates a new promoter with the provided data and returns the created promoter details.",
     *     operationId="createPromoter",
     *     tags={"Promoters"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"first_name", "last_name", "birthday_date", "gender", "email", "phone", "address", "availabilities"},
     *             @OA\Property(property="first_name", type="string", example="John"),
     *             @OA\Property(property="last_name", type="string", example="Doe"),
     *             @OA\Property(property="birthday_date", type="string", format="date", example="1990-05-15"),
     *             @OA\Property(property="gender", type="string", example="male"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.de"),
     *             @OA\Property(property="phone", type="string", example="+4915123456789"),
     *             @OA\Property(property="address", type="string", example="123 Promoter Lane, Berlin, Germany"),
     *             @OA\Property(
     *                 property="availabilities",
     *                 type="array",
     *                 @OA\Items(type="string", example="Monday")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Promoter created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="ok", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Promoter created successfully"),
     *             @OA\Property(
     *                 property="promoter",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=6),
     *                 @OA\Property(property="first_name", type="string", example="John"),
     *                 @OA\Property(property="last_name", type="string", example="Doe"),
     *                 @OA\Property(property="birthday_date", type="string", format="date-time", example="1990-05-15T00:00:00.000000Z"),
     *                 @OA\Property(property="gender", type="string", example="male"),
     *                 @OA\Property(property="email", type="string", format="email", example="john.doe@example.de"),
     *                 @OA\Property(property="phone", type="string", example="+4915123456789"),
     *                 @OA\Property(property="address", type="string", example="123 Promoter Lane, Berlin, Germany"),
     *                 @OA\Property(
     *                     property="availabilities",
     *                     type="array",
     *                     @OA\Items(type="string", example="Monday")
     *                 ),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-25T21:24:35.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-25T21:24:35.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="ok", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation error"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 example={
     *                     "first_name": {"The first name field is required."},
     *                     "email": {"The email must be a valid email address."}
     *                 }
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreOrUpdatePromoterRequest $request): JsonResponse
    {
        $promoter = Promoter::create($request->validated());

        return response()->json([
            'ok' => true,
            'message' => 'Promoter created successfully',
            'promoter' => $promoter,
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/promoters/{promoter_id}",
     *     summary="Retrieve a single promoter",
     *     description="Fetches a specific promoter along with their associated promoter groups and skills.",
     *     operationId="getPromoterById",
     *     tags={"Promoters"},
     *     @OA\Parameter(
     *         name="promoter_id",
     *         in="path",
     *         description="ID of the promoter to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Details of a promoter",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="ok",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="promoter",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=3),
     *                 @OA\Property(property="first_name", type="string", example="Joanie"),
     *                 @OA\Property(property="last_name", type="string", example="Effertz"),
     *                 @OA\Property(property="birthday_date", type="string", format="date-time", example="2002-05-13T00:00:00.000000Z"),
     *                 @OA\Property(property="gender", type="string", example="male"),
     *                 @OA\Property(property="email", type="string", format="email", example="pierce.spencer@example.net"),
     *                 @OA\Property(property="phone", type="string", example="+1-424-457-1997"),
     *                 @OA\Property(property="address", type="string", example="719 Cruickshank Lodge Apt. 453\nEinarshire, NV 03629-9226"),
     *                 @OA\Property(
     *                     property="availabilities",
     *                     type="array",
     *                     @OA\Items(type="string", example="Monday")
     *                 ),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                 @OA\Property(
     *                     property="promoter_groups",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=3),
     *                         @OA\Property(property="name", type="string", example="Sales Promoter"),
     *                         @OA\Property(property="description", type="string", example="Die Sales Promoter sind Verkaufsspezialisten, die über umfassende Kenntnisse in Produktpräsentation und Kundenkommunikation verfügen."),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                         @OA\Property(
     *                             property="pivot",
     *                             type="object",
     *                             @OA\Property(property="promoter_id", type="integer", example=3),
     *                             @OA\Property(property="promoter_group_id", type="integer", example=3),
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
     *                         @OA\Property(property="id", type="integer", example=7),
     *                         @OA\Property(property="name", type="string", example="Verkaufstechniken (z. B. Upselling, Cross-Selling)"),
     *                         @OA\Property(property="description", type="string", example="Beherrschung effektiver Verkaufstechniken, um zusätzliche Produkte oder höherwertige Alternativen anzubieten."),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                         @OA\Property(
     *                             property="pivot",
     *                             type="object",
     *                             @OA\Property(property="promoter_id", type="integer", example=3),
     *                             @OA\Property(property="skill_id", type="integer", example=7),
     *                             @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z")
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Promoter not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="ok", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Promoter not found")
     *         )
     *     )
     * )
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
     * @OA\Put(
     *     path="/api/promoters/{promoter_id}",
     *     summary="Update a promoter",
     *     description="Updates the details of a specific promoter.",
     *     operationId="updatePromoter",
     *     tags={"Promoters"},
     *     @OA\Parameter(
     *         name="promoter_id",
     *         in="path",
     *         description="ID of the promoter to update",
     *         required=true,
     *         @OA\Schema(type="integer", example=6)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="first_name", type="string", example="John"),
     *             @OA\Property(property="last_name", type="string", example="Doe"),
     *             @OA\Property(property="birthday_date", type="string", format="date", example="1990-05-15"),
     *             @OA\Property(property="gender", type="string", example="male"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe.updated@example.com"),
     *             @OA\Property(property="phone", type="string", example="+4915123456789"),
     *             @OA\Property(property="address", type="string", example="123 Updated Address, Berlin, Germany"),
     *             @OA\Property(
     *                 property="availabilities",
     *                 type="array",
     *                 @OA\Items(type="string", example="Monday")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Promoter updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="ok",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Promoter updated successfully"
     *             ),
     *             @OA\Property(
     *                 property="promoter",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=6),
     *                 @OA\Property(property="first_name", type="string", example="John"),
     *                 @OA\Property(property="last_name", type="string", example="Doe"),
     *                 @OA\Property(property="birthday_date", type="string", format="date-time", example="1990-05-15T00:00:00.000000Z"),
     *                 @OA\Property(property="gender", type="string", example="male"),
     *                 @OA\Property(property="email", type="string", format="email", example="john.doe.updated@example.com"),
     *                 @OA\Property(property="phone", type="string", example="+4915123456789"),
     *                 @OA\Property(property="address", type="string", example="123 Updated Address, Berlin, Germany"),
     *                 @OA\Property(
     *                     property="availabilities",
     *                     type="array",
     *                     @OA\Items(type="string", example="Monday")
     *                 ),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-25T21:24:35.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-25T21:34:10.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Promoter not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="ok", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Promoter not found")
     *         )
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/promoters/{promoter_id}",
     *     summary="Delete a promoter",
     *     description="Deletes a specific promoter from the database.",
     *     operationId="deletePromoter",
     *     tags={"Promoters"},
     *     @OA\Parameter(
     *         name="promoter_id",
     *         in="path",
     *         description="ID of the promoter to delete",
     *         required=true,
     *         @OA\Schema(type="integer", example=6)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Promoter deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Promoter deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Promoter not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Promoter not found")
     *         )
     *     )
     * )
     */
    public function destroy(Promoter $promoter): JsonResponse
    {
        $promoter->delete();

        return response()->json([
            'message' => 'Promoter deleted successfully'
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/promoters/{promoter_id}/skills",
     *     summary="Add a skill to a promoter",
     *     description="Attach a skill to a promoter by their ID.",
     *     tags={"Promoters"},
     *     @OA\Parameter(
     *         name="promoter_id",
     *         in="path",
     *         required=true,
     *         description="The ID of the promoter to whom the skill will be added.",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"skill_id"},
     *             @OA\Property(
     *                 property="skill_id",
     *                 type="integer",
     *                 description="The ID of the skill to be added to the promoter."
     *             ),
     *             example={"skill_id": 3}
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Skill successfully added to the promoter.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Skill successfully added to promoter."
     *             ),
     *             @OA\Property(
     *                 property="promoter",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="first_name", type="string", example="Maude"),
     *                 @OA\Property(property="last_name", type="string", example="Eichmann"),
     *                 @OA\Property(property="birthday_date", type="string", format="date-time", example="1991-08-13T00:00:00.000000Z"),
     *                 @OA\Property(property="gender", type="string", example="male"),
     *                 @OA\Property(property="email", type="string", example="gleichner.tatum@example.org"),
     *                 @OA\Property(property="phone", type="string", example="(667) 889-1013"),
     *                 @OA\Property(property="address", type="string", example="635 Wilford Well Suite 426\nMaribelshire, KS 57689-8866"),
     *                 @OA\Property(
     *                     property="availabilities",
     *                     type="array",
     *                     @OA\Items(type="string"),
     *                     example={"Sunday"}
     *                 ),
     *                 @OA\Property(
     *                     property="skills",
     *                     type="array",
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
     *                             @OA\Property(property="promoter_id", type="integer", example=1),
     *                             @OA\Property(property="skill_id", type="integer", example=3),
     *                             @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-25T21:39:26.000000Z"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-25T21:39:26.000000Z")
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    public function addSkillToPromoter(Request $request, Promoter $promoter): JsonResponse
    {
        $skill = Skill::findOrFail($request->input('skill_id'));

        $promoter->skills()->attach($skill->id);

        return response()->json([
            'message' => 'Skill successfully added to promoter.',
            'promoter' => $promoter->load('skills'),
        ], 200);
    }
}
