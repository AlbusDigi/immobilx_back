<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\BailleurResource;
use App\Http\Resources\LocataireResource;
use App\Models\Bailleur;
use App\Models\Concierge;
use App\Models\Locataire;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function bailleurRegister(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'string', 'confirmed', 'min:8'],
                'telephone' => ['required', 'string', 'unique:users'],

                'rccm' => ['required', 'string'],
                'nif' => ['required', 'string'],
                'type' => ['required', 'in:individual,professional'],
                'address' => ['required', 'string'],
                'description' => ['nullable', 'string'],
                'legal_name' => ['nullable', 'string'],
                'head_office_address' => ['nullable', 'string'],
                'legal_form' => ['nullable', 'string'],
                'registration_date' => ['nullable', 'date'],
                'legal_contact' => ['nullable', 'string'],
                'property_insurance' => ['nullable', 'string'],
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            // Récupération des données validées
            $data = $validator->validated();

            // Création de l'utilisateur
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'telephone' => $data['telephone'],
            ]);

            $user->assignRole('Bailleur');

            // Création du bailleur
            $bailleur = Bailleur::create([
                'user_id' => $user->id,
                'rccm' => $data['rccm'],
                'nif' => $data['nif'],
                'type' => $data['type'],
                'address' => $data['address'],
                'description' => $data['description'] ?? null,
                'legal_name' => $data['legal_name'] ?? null,
                'head_office_address' => $data['head_office_address'] ?? null,
                'legal_form' => $data['legal_form'] ?? null,
                'registration_date' => $data['registration_date'] ?? null,
                'legal_contact' => $data['legal_contact'] ?? null,
                'property_insurance' => $data['property_insurance'] ?? null,
            ]);

            return response()->json([
                'message' => 'Bailleur registered successfully',
                'user' => $user,
                'bailleur' => new BailleurResource($bailleur),
            ], 201);

        } catch (\Exception $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ], 500);
        }
    }


    public function locataireRegister(Request $request)
    {
        try {
            $user  = auth()->user();
            if(!$user){
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'string', 'confirmed', 'min:8'],
                'telephone' => ['required', 'string', 'unique:users'],

                'profession' => ['required', 'string'],
                'marital_status' => ['required', 'string'],
                'residence_address' => ['required', 'string'],
                'date_of_birth' => ['required', 'date'],
                'place_of_birth' => ['required', 'string'],
                'identity_document' => ['required', 'string'],
                'document_issued_date' => ['required', 'date'],
                'document_issued_by' => ['required', 'string'],
                'emergency_phone' => ['required', 'string'],
                'guarantor_name' => ['nullable', 'string'],
                'guarantor_phone' => ['nullable', 'string'],
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $data = $validator->validated();

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'telephone' => $data['telephone'],
            ]);

            $user->assignRole('Locataire');

            $locataire = Locataire::create([
                'user_id' => $user->id,
                'profession' => $data['profession'],
                'marital_status' => $data['marital_status'],
                'residence_address' => $data['residence_address'],
                'date_of_birth' => $data['date_of_birth'],
                'place_of_birth' => $data['place_of_birth'],
                'identity_document' => $data['identity_document'],
                'document_issued_date' => $data['document_issued_date'],
                'document_issued_by' => $data['document_issued_by'],
                'emergency_phone' => $data['emergency_phone'],
                'guarantor_name' => $data['guarantor_name'] ?? null,
                'guarantor_phone' => $data['guarantor_phone'] ?? null,
            ]);

            return response()->json([
                'message' => 'Locataire registered successfully',
                'user' => $user,
                'locataire' => new LocataireResource($locataire),
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }


}
