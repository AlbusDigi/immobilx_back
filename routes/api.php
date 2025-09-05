<?php

use App\Http\Controllers\Bailleur\ParcelleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes protégées (nécessitent un jeton d'authentification)
|--------------------------------------------------------------------------
| Toutes les routes dans ce groupe sont protégées par le middleware 'auth:sanctum'.
*/
Route::middleware('auth:sanctum')->group(function () {

    // Route de test pour obtenir l'utilisateur authentifié
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Routes pour la gestion du profil utilisateur

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);


    //parcelles routes
    Route::apiResource('/parcelles', ParcelleController::class);


});


require __DIR__.'/auth.php';
