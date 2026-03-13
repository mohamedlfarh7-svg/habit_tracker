<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Http\Requests\HabitRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class HabitController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = $request->user()->habits();

        if ($request->has('active')) {
            $isActive = filter_var($request->active, FILTER_VALIDATE_BOOLEAN);
            $query->where('is_active', $isActive);
        }

        return response()->json($data = ["data" => $query->get(), "message" => 'Habitudes récupérées'], 200);
    }

    public function store(HabitRequest $request): JsonResponse
    {
        $habit = $request->user()->habits()->create($request->validated());

        return $this->successResponse($habit, 'Habitude créée avec succès', 201);
    }

    public function show(Request $request, $id): JsonResponse
    {
        $habit = Habit::find($id);
        if ($habit->user_id !== $request->user()->id) {
            return $this->errorResponse('Non autorisé', 403);
        }

        return $this->successResponse($habit, 'Détail de l\'habitude');
    }

    public function update(HabitRequest $habitrequest, Habit $habit): JsonResponse
    {
        if ($habit->user_id !== Auth::id()) {
            return $this->errorResponse('Non autorisé', 403);
        }

        $habit->update($habitrequest->validated());

        return $this->successResponse($habit, 'Habitude mise à jour');
    }

    public function delete(Request $request, Habit $habit): JsonResponse
    {
        if ($habit->user_id !== $request->user()->id) {
            return $this->errorResponse('Non autorisé', 403);
        }

        $habit->delete();

        return $this->successResponse(null, 'Habitude supprimée');
    }
}
