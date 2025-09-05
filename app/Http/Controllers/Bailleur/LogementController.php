<?php

namespace App\Http\Controllers\Bailleur;

use App\Http\Controllers\Controller;
use App\Http\Resources\Bailleur\LogementResource;
use App\Models\Logement;
use App\Models\Parcelle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LogementController extends Controller
{
    /**
     * Liste des logements avec recherche et pagination
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Logement::query()->whereHas('parcelle', function($q) use ($user) {
            $q->where('bailleur_id', $user->bailleur->id);
        });

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 10);
        $logements = $query->paginate($perPage);

        return LogementResource::collection($logements);
    }

    /**
     * Crée un nouveau logement
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        // Vérification de la parcelle et du bailleur
        $parcelle = Parcelle::find($request->input('parcelle_id'));
        if (!$parcelle || $parcelle->bailleur_id !== $user->bailleur->id) {
            return response()->json(['message' => 'Unauthorized or parcelle not found'], 401);
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'parcelle_id' => 'required|exists:parcelles,id',
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('logements')->where(function ($query) use ($request) {
                    return $query->where('parcelle_id', $request->parcelle_id)
                        ->whereNull('deleted_at');
                })
            ],
            'floor' => 'nullable|integer|min:0',
            'rooms' => 'nullable|integer|min:0',
            'living_area' => 'nullable|numeric',
            'construction_year' => 'nullable|digits:4',
            'equipments' => 'nullable|string',
            'rent' => 'nullable|numeric|min:0',
            'charges' => 'nullable|numeric|min:0',
            'deposit' => 'nullable|numeric|min:0',
            'availability' => 'nullable|in:available,occupied,maintenance',
            'state' => 'nullable|in:active,blocked,pending',
            'internal_rules' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        if ($validator->fails()) return response()->json($validator->errors(), 422);

        $data = $validator->validated();
        $data['state'] = 'active'; // activée par défaut

        try {
            $logement = Logement::create($data);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Un logement avec ce nom existe déjà dans cette parcelle.'
            ], 422);
        }

        return response()->json([
            'status' => true,
            'data' => new LogementResource($logement),
        ], 201);
    }

    /**
     * Affiche un logement spécifique
     */
    public function show($id)
    {
        $user = auth()->user();
        $logement = Logement::where('id', $id)
            ->whereHas('parcelle', fn($q) => $q->where('bailleur_id', $user->bailleur->id))
            ->first();

        if (!$logement) return response()->json(['message' => 'Logement non trouvé'], 404);

        return new LogementResource($logement);
    }

    /**
     * Met à jour un logement
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();

        $logement = Logement::where('id', $id)
            ->whereHas('parcelle', fn($q) => $q->where('bailleur_id', $user->bailleur->id))
            ->first();

        if (!$logement) return response()->json(['message' => 'Logement non trouvé'], 404);

        $validator = Validator::make($request->all(), [
            'parcelle_id' => 'sometimes|exists:parcelles,id',
            'name' => [
                'sometimes', 'string', 'max:255',
                Rule::unique('logements')->ignore($logement->id)->where(function ($query) use ($request, $logement) {
                    $parcelleId = $request->input('parcelle_id', $logement->parcelle_id);
                    return $query->where('parcelle_id', $parcelleId)
                        ->whereNull('deleted_at');
                })
            ],
            'floor' => 'nullable|integer|min:0',
            'rooms' => 'nullable|integer|min:0',
            'living_area' => 'nullable|numeric',
            'construction_year' => 'nullable|digits:4',
            'equipments' => 'nullable|string',
            'rent' => 'nullable|numeric|min:0',
            'charges' => 'nullable|numeric|min:0',
            'deposit' => 'nullable|numeric|min:0',
            'availability' => 'nullable|in:available,occupied,maintenance',
            'state' => 'nullable|in:active,blocked,pending',
            'internal_rules' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        if ($validator->fails()) return response()->json($validator->errors(), 422);

        $logement->update($validator->validated());

        return new LogementResource($logement);
    }

    /**
     * Supprime un logement
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $logement = Logement::where('id', $id)
            ->whereHas('parcelle', fn($q) => $q->where('bailleur_id', $user->bailleur->id))
            ->first();

        if (!$logement) return response()->json(['message' => 'Logement non trouvé'], 404);

        $logement->delete();

        return response()->json(['status' => true, 'message' => 'Logement supprimé'], 200);
    }
}
