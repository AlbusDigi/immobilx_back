<?php

namespace App\Http\Controllers\Contrat;

use App\Http\Controllers\Controller;
use App\Models\Contrat;
use Illuminate\Http\Request;
use App\Http\Resources\ContratResource;
use Illuminate\Support\Facades\Auth;

class ContratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Vérifiez si l'utilisateur est bien un bailleur
        if (!$user || !$user->bailleur) {
            return response()->json(['message' => 'Unauthorized or not a landlord'], 403);
        }

        // Accédez à la relation contrats via le modèle Bailleur
        $contrats = $user->bailleur->contrats()->with(['locataire.user', 'logement'])->get();
        return ContratResource::collection($contrats);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->bailleur) {
            return response()->json(['message' => 'Unauthorized or not a landlord'], 403);
        }

        $request->validate([
            'locataire_id' => 'required|exists:locataires,id',
            'logement_id' => [
                'required',
                'exists:logements,id',
                function ($attribute, $value, $fail) use ($user) {
                    $exists = \App\Models\Logement::where('id', $value)
                        ->whereHas('parcelle', function ($query) use ($user) {
                            $query->where('bailleur_id', $user->bailleur->id);
                        })->exists();
                    if (!$exists) {
                        $fail('The selected logement is invalid or does not belong to you.');
                    }
                },
            ],
            'dateDebut' => 'required|date',
            'dateFin' => 'required|date|after:dateDebut',
            'caution' => 'nullable|numeric',
            'loyerMensuel' => 'required|numeric',
        ]);

        $contrat = Contrat::create([
            'bailleur_id' => $user->bailleur->id, // ID du bailleur authentifié
            'locataire_id' => $request->locataire_id,
            'logement_id' => $request->logement_id,
            'dateDebut' => $request->dateDebut,
            'dateFin' => $request->dateFin,
            'caution' => $request->caution,
            'loyerMensuel' => $request->loyerMensuel,
        ]);

        return new ContratResource($contrat);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contrat $contrat)
    {
        $user = Auth::user();
        if (!$user || !$user->bailleur || $contrat->bailleur_id !== $user->bailleur->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return new ContratResource($contrat->load(['locataire', 'logement']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contrat $contrat)
    {
        $user = Auth::user();
        if (!$user || !$user->bailleur || $contrat->bailleur_id !== $user->bailleur->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'locataire_id' => 'required|exists:locataires,id',
            'logement_id' => [
                'required',
                'exists:logements,id',
                function ($attribute, $value, $fail) use ($user) {
                    $exists = \App\Models\Logement::where('id', $value)
                        ->whereHas('parcelle', function ($query) use ($user) {
                            $query->where('bailleur_id', $user->bailleur->id);
                        })->exists();
                    if (!$exists) {
                        $fail('The selected logement is invalid or does not belong to you.');
                    }
                },
            ],
            'dateDebut' => 'required|date',
            'dateFin' => 'required|date|after:dateDebut',
            'caution' => 'nullable|numeric',
            'loyerMensuel' => 'required|numeric',
        ]);

        $contrat->update($request->all());

        return new ContratResource($contrat->load(['locataire', 'logement']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contrat $contrat)
    {
        $user = Auth::user();
        if (!$user || !$user->bailleur || $contrat->bailleur_id !== $user->bailleur->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $contrat->delete();

        return response()->json(null, 204);
    }
}
