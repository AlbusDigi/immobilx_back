<?php

namespace App\Http\Controllers\Bailleur;

use App\Http\Controllers\Controller;
use App\Http\Resources\Bailleur\ParcelleResource;
use App\Models\Parcelle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ParcelleController extends Controller
{
    /**
     * Display a listing of the resource.
     * Search by name, cadastral_number, address + pagination
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $bailleur = $user->bailleur;
        if (!$bailleur) return response()->json(['message' => 'Unauthorized'], 401);

        $query = Parcelle::where('bailleur_id', $bailleur->id);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('cadastral_number', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 10);
        $parcelles = $query->paginate($perPage);

        return ParcelleResource::collection($parcelles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $bailleur = $user->bailleur;
        if (!$bailleur) return response()->json(['message' => 'Unauthorized'], 401);

        // Validation initiale
        $validator = Validator::make($request->all(), [
            'name' => [
                'required','string','max:255',
                Rule::unique('parcelles')->where(function ($query) use ($bailleur) {
                    return $query->where('bailleur_id', $bailleur->id)
                        ->whereNull('deleted_at');
                })
            ],
            'address' => 'required|string|max:255',
            'area' => 'nullable|numeric',
            'internal_rules' => 'nullable|string',
            'cadastral_number' => [
                'nullable','string','max:255',
                Rule::unique('parcelles')->whereNull('deleted_at')
            ],
            'land_title_number' => [
                'nullable','string','max:255',
                Rule::unique('parcelles')->whereNull('deleted_at')
            ],
            'land_title_date' => 'nullable|date',
            'legal_status' => 'nullable|in:registered,customary,state',
            'housing_units' => 'nullable|integer|min:0',
            'floors' => 'nullable|integer|min:0',
            'construction_year' => 'nullable|digits:4',
            'urban_zone' => 'nullable|in:residential,commercial,industrial,mixed,agricultural,protected',
            'note' => 'nullable|string',
            'status' => 'nullable|in:active,blocked,pending',
        ]);

        if ($validator->fails()) return response()->json($validator->errors(), 422);

        $data = $validator->validated();
        $data['bailleur_id'] = $bailleur->id;
        $data['status'] = 'active'; // activée par défaut

        try {
            $parcelle = Parcelle::create($data);
        } catch (\Illuminate\Database\QueryException $e) {
            // Catch unique constraint errors
            return response()->json([
                'status' => false,
                'message' => 'Le numéro cadastral ou le numéro de titre foncier existe déjà.'
            ], 422);
        }

        return response()->json([
            'status' => true,
            'data' => new ParcelleResource($parcelle),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = auth()->user();
        $bailleur = $user->bailleur;
        if (!$bailleur) return response()->json(['message' => 'Unauthorized'], 401);

        $parcelle = Parcelle::where('bailleur_id', $bailleur->id)->find($id);
        if (!$parcelle) return response()->json(['message' => 'Parcel not found'], 404);

        return new ParcelleResource($parcelle);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = auth()->user();
        $bailleur = $user->bailleur;
        if (!$bailleur) return response()->json(['message' => 'Unauthorized'], 401);

        $parcelle = Parcelle::where('bailleur_id', $bailleur->id)->find($id);
        if (!$parcelle) return response()->json(['message' => 'Parcel not found'], 404);

        $validator = Validator::make($request->all(), [
            'name' => [
                'sometimes','string','max:255',
                Rule::unique('parcelles')->ignore($parcelle->id)->where(function ($query) use ($bailleur) {
                    return $query->where('bailleur_id', $bailleur->id)
                        ->whereNull('deleted_at');
                })
            ],
            'address' => 'sometimes|string|max:255',
            'area' => 'nullable|numeric',
            'internal_rules' => 'nullable|string',
            'cadastral_number' => [
                'nullable','string','max:255',
                Rule::unique('parcelles')->ignore($parcelle->id)->whereNull('deleted_at')
            ],
            'land_title_number' => [
                'nullable','string','max:255',
                Rule::unique('parcelles')->ignore($parcelle->id)->whereNull('deleted_at')
            ],
            'land_title_date' => 'nullable|date',
            'legal_status' => 'nullable|in:registered,customary,state',
            'housing_units' => 'nullable|integer|min:0',
            'floors' => 'nullable|integer|min:0',
            'construction_year' => 'nullable|digits:4',
            'urban_zone' => 'nullable|in:residential,commercial,industrial,mixed,agricultural,protected',
            'note' => 'nullable|string',
            'status' => 'nullable|in:active,blocked,pending',
        ]);

        if ($validator->fails()) return response()->json($validator->errors(), 422);

        $parcelle->update($validator->validated());

        return new ParcelleResource($parcelle);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = auth()->user();
        $bailleur = $user->bailleur;
        if (!$bailleur) return response()->json(['message' => 'Unauthorized'], 401);

        $parcelle = Parcelle::where('bailleur_id', $bailleur->id)->find($id);
        if (!$parcelle) return response()->json(['message' => 'Parcel not found'], 404);

        $parcelle->delete();

        return response()->json(['status' => true, 'message' => 'Parcel deleted'], 200);
    }
}
