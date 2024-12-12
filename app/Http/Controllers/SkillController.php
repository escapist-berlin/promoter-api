<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrUpdateSkillRequest;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Skills",
 *     description="Operations related to skills"
 * )
 */
class SkillController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/skills",
     *     summary="Get all skills with related promoters and promoter groups",
     *     description="Retrieve a list of all skills, including associated promoters and promoter groups.",
     *     tags={"Skills"},
     *     @OA\Response(
     *         response=200,
     *         description="Skills retrieved successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="ok", type="boolean", example=true),
     *             @OA\Property(
     *                 property="skills",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Latte-Art-Zertifikat"),
     *                     @OA\Property(property="description", type="string", example="Fähigkeit, fortgeschrittene Latte-Art-Techniken zu beherrschen und ein offizielles Zertifikat zu besitzen."),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                     @OA\Property(
     *                         property="promoters",
     *                         type="array",
     *                         description="Promoters associated with the skill.",
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
     *                                 @OA\Property(property="skill_id", type="integer", example=1),
     *                                 @OA\Property(property="promoter_id", type="integer", example=1),
     *                                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z")
     *                             )
     *                         )
     *                     ),
     *                     @OA\Property(
     *                         property="promoter_groups",
     *                         type="array",
     *                         description="Promoter groups associated with the skill.",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="name", type="string", example="Latte-Art Baristas"),
     *                             @OA\Property(property="description", type="string", example="Diese Gruppe besteht aus Baristas, die sich durch ihre Latte-Art-Fähigkeiten auszeichnen..."),
     *                             @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                             @OA\Property(
     *                                 property="pivot",
     *                                 type="object",
     *                                 @OA\Property(property="skill_id", type="integer", example=1),
     *                                 @OA\Property(property="promoter_group_id", type="integer", example=1),
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
        $skills = Skill::with(['promoters', 'promoterGroups'])->get();

        return response()->json([
            "ok" => true,
            "skills" => $skills
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/skills",
     *     summary="Create a new skill",
     *     description="Create a new skill and associate it with promoter groups if provided.",
     *     tags={"Skills"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "description"},
     *             @OA\Property(property="name", type="string", description="The name of the skill.", example="Latte-Art-Zertifikat"),
     *             @OA\Property(property="description", type="string", description="A description of the skill.", example="Fähigkeit, fortgeschrittene Latte-Art-Techniken zu beherrschen und ein offizielles Zertifikat zu besitzen."),
     *             @OA\Property(
     *                 property="promoter_group_ids",
     *                 type="array",
     *                 description="An array of promoter group IDs to associate with the skill.",
     *                 @OA\Items(type="integer"),
     *                 example={1}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Skill created successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Skill created successfully"),
     *             @OA\Property(
     *                 property="skill",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=16),
     *                 @OA\Property(property="name", type="string", example="Latte-Art-Zertifikat"),
     *                 @OA\Property(property="description", type="string", example="Fähigkeit, fortgeschrittene Latte-Art-Techniken zu beherrschen und ein offizielles Zertifikat zu besitzen."),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-25T22:16:49.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-25T22:16:49.000000Z"),
     *                 @OA\Property(
     *                     property="promoter_groups",
     *                     type="array",
     *                     description="Promoter groups associated with the skill.",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Latte-Art Baristas"),
     *                         @OA\Property(property="description", type="string", example="Diese Gruppe besteht aus Baristas, die sich durch ihre Latte-Art-Fähigkeiten auszeichnen..."),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                         @OA\Property(
     *                             property="pivot",
     *                             type="object",
     *                             @OA\Property(property="skill_id", type="integer", example=16),
     *                             @OA\Property(property="promoter_group_id", type="integer", example=1),
     *                             @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-25T22:16:49.000000Z"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-25T22:16:49.000000Z")
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/skills/{skill_id}",
     *     summary="Get details of a specific skill",
     *     description="Retrieve details of a specific skill by its ID, including associated promoters and promoter groups.",
     *     tags={"Skills"},
     *     @OA\Parameter(
     *         name="skill_id",
     *         in="path",
     *         required=true,
     *         description="The ID of the skill to retrieve.",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Skill retrieved successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="ok", type="boolean", example=true),
     *             @OA\Property(
     *                 property="skill",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Latte-Art-Zertifikat"),
     *                 @OA\Property(property="description", type="string", example="Fähigkeit, fortgeschrittene Latte-Art-Techniken zu beherrschen und ein offizielles Zertifikat zu besitzen."),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                 @OA\Property(
     *                     property="promoters",
     *                     type="array",
     *                     description="Promoters associated with the skill.",
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
     *                             @OA\Property(property="skill_id", type="integer", example=1),
     *                             @OA\Property(property="promoter_id", type="integer", example=1),
     *                             @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z")
     *                         )
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="promoter_groups",
     *                     type="array",
     *                     description="Promoter groups associated with the skill.",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Latte-Art Baristas"),
     *                         @OA\Property(property="description", type="string", example="Diese Gruppe besteht aus Baristas, die sich durch ihre Latte-Art-Fähigkeiten auszeichnen..."),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                         @OA\Property(
     *                             property="pivot",
     *                             type="object",
     *                             @OA\Property(property="skill_id", type="integer", example=1),
     *                             @OA\Property(property="promoter_group_id", type="integer", example=1),
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
    public function show(Skill $skill): JsonResponse
    {
        $skill->load(['promoters', 'promoterGroups']);

        return response()->json([
            "ok" => true,
            "skill" => $skill
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/skills/{skill_id}",
     *     summary="Update a skill",
     *     description="Update the details of a specific skill by its ID, including updating associated promoter groups.",
     *     tags={"Skills"},
     *     @OA\Parameter(
     *         name="skill_id",
     *         in="path",
     *         required=true,
     *         description="The ID of the skill to update.",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "description"},
     *             @OA\Property(property="name", type="string", description="The updated name of the skill.", example="Latte-Art-Zertifikat"),
     *             @OA\Property(property="description", type="string", description="The updated description of the skill.", example="Fähigkeit, fortgeschrittene Latte-Art-Techniken zu beherrschen und ein offizielles Zertifikat zu besitzen."),
     *             @OA\Property(
     *                 property="promoter_group_ids",
     *                 type="array",
     *                 description="An array of promoter group IDs to associate with the skill.",
     *                 @OA\Items(type="integer"),
     *                 example={}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Skill updated successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Skill updated successfully"),
     *             @OA\Property(
     *                 property="skill",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Latte-Art-Zertifikat"),
     *                 @OA\Property(property="description", type="string", example="Fähigkeit, fortgeschrittene Latte-Art-Techniken zu beherrschen und ein offizielles Zertifikat zu besitzen."),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                 @OA\Property(
     *                     property="promoter_groups",
     *                     type="array",
     *                     description="The updated promoter groups associated with the skill.",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Latte-Art Baristas"),
     *                         @OA\Property(property="description", type="string", example="Diese Gruppe besteht aus Baristas, die sich durch ihre Latte-Art-Fähigkeiten auszeichnen..."),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T14:28:26.000000Z"),
     *                         @OA\Property(
     *                             property="pivot",
     *                             type="object",
     *                             @OA\Property(property="skill_id", type="integer", example=1),
     *                             @OA\Property(property="promoter_group_id", type="integer", example=1),
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
     * @OA\Delete(
     *     path="/api/skills/{skill_id}",
     *     summary="Delete a skill",
     *     description="Delete a specific skill by its ID.",
     *     tags={"Skills"},
     *     @OA\Parameter(
     *         name="skill_id",
     *         in="path",
     *         required=true,
     *         description="The ID of the skill to delete.",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Skill deleted successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Skill deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Skill not found.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Skill not found.")
     *         )
     *     )
     * )
     */
    public function destroy(Skill $skill): JsonResponse
    {
        $skill->delete();

        return response()->json([
            'message' => 'Skill deleted successfully',
        ], 200);
    }
}
