<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\AuthLoginResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    /**
     * Gère une requête de connexion (authentification).
     *
     * @param LoginRequest $request Requête contenant les données de connexion (email + mot de passe validés)
     * @return AuthLoginResource|JsonResponse Retourne soit un objet ressource avec token, soit une réponse d'erreur
     */
    public function store(LoginRequest $request): AuthLoginResource | JsonResponse
    {
        try {
            $request->authenticate();

            $user = User::where('email', $request->email)->first();

            // Génération d’un token d’authentification via Laravel Sanctum
            $token = $user->createToken($user->email)->plainTextToken;

            // Ajoute manuellement le token dans l’objet utilisateur
            $user->token = $token;

            return new AuthLoginResource($user);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Email ou mot de passe incorrect',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            $message = config('app.debug') ? $e->getMessage() : 'Une erreur est survenue lors de la connexion.';
            return response()->json(['message' => $message], 500);
        }
    }

    /**
     * Déconnecte l'utilisateur (suppression du token d'accès actuel).
     *
     * @param Request $request La requête contenant l'utilisateur authentifié
     * @return JsonResponse Réponse confirmant la déconnexion
     */
    public function destroy(Request $request): JsonResponse
    {
        $user  = $request->user(); // Récupère l'utilisateur actuellement connecté via le token

        // Vérifie si l'utilisateur est bien authentifié
        if (!($user instanceof User)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Supprime le token actuel (le déconnecte)
        $request->user()->currentAccessToken()->delete();

        // Réponse de confirmation
        return response()->json(['logout' => true]);
    }
}
