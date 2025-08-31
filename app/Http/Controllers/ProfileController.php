<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

class ProfileController extends Controller
{
    /**
     * Affiche les informations du profil de l'utilisateur authentifié.
     * GET /api/profile
     */
    public function show(Request $request)
    {
        try {
            // Récupère l'utilisateur authentifié.
            $user = $request->user();

            if (!$user) {
                return response()->json(['message' => 'Utilisateur non authentifié.'], 401);
            }

            // Retourne la ressource de l'utilisateur.
            return new UserResource($user);

        } catch (\Exception $e) {
            // Gère les erreurs serveur inattendues.
            return response()->json(['message' => 'Une erreur est survenue lors de la récupération du profil.'], 500);
        }
    }

    /**
     * Met à jour les informations du profil de l'utilisateur authentifié.
     * PUT /api/profile
     */
    public function update(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['message' => 'Utilisateur non authentifié.'], 401);
            }

            // 1. Validation des données entrantes.
            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => [
                    'sometimes',
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($user->id),
                ],
                'telephone' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('users')->ignore($user->id),
                ],
            ]);

            // 2. Mise à jour des informations de l'utilisateur.
            $user->update($validatedData);

            // 3. Mise à jour des informations spécifiques au rôle.
            if ($user->hasRole('Locataire')) {
                $request->validate([
                    'profession' => 'sometimes|string|max:255|nullable',
                    'etatCivil' => 'sometimes|string|max:255|nullable',
                    'pieceIdentite' => 'sometimes|string|max:255|nullable',
                ]);
                $user->locataire->update($request->only('profession', 'etatCivil', 'pieceIdentite'));
            } elseif ($user->hasRole('Bailleur')) {
                $request->validate([
                    'rccm' => 'sometimes|string|max:255|nullable',
                    'nif' => 'sometimes|string|max:255|nullable',
                ]);
                $user->bailleur->update($request->only('rccm', 'nif'));
            }

            // 4. Renvoi de la ressource avec les données mises à jour.
            return new UserResource($user->fresh());

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel gère déjà les exceptions de validation, mais le bloc permet de le rendre explicite.
            return response()->json([
                'message' => 'Les données fournies ne sont pas valides.',
                'errors' => $e->errors(),
            ], 422);

        } catch (QueryException $e) {
            // Gère les erreurs de la base de données.
            return response()->json(['message' => 'Une erreur de base de données est survenue lors de la mise à jour.'], 500);

        } catch (\Exception $e) {
            // Gère toute autre erreur inattendue.
            return response()->json(['message' => 'Une erreur inattendue est survenue.'], 500);
        }
    }
}
