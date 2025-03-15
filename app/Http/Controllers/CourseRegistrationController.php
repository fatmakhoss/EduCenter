<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscription;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CourseRegistrationController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'country' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'course' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Obtenir les IDs de langue et niveau à partir des noms
            $langue_id = 1; // Valeur par défaut, à adapter
            $niveau_id = 1; // Valeur par défaut, à adapter
            
            // Si la langue ou le niveau sont disponibles par nom, il faudrait récupérer leur ID
            // Exemple: $langue = Langue::where('nom', $request->course)->first();
            // if ($langue) $langue_id = $langue->id;
            
            // Enregistrer l'inscription
            $registration = Inscription::create([
                'name' => $request->fullName,
                'email' => $request->email,
                'pays' => $request->country,
                'telephone' => $request->phone,
                'langue_id' => $langue_id,
                'niveau_id' => $niveau_id,
                'status' => 'pending'
            ]);

            // Envoyer un email de confirmation
            // Mail::to($request->email)->send(new CourseRegistrationMail($registration));

            return response()->json([
                'message' => 'Inscription réussie',
                'data' => $registration
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de l\'inscription',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        try {
            $inscriptions = Inscription::with('langue', 'niveau')->get();
            
            // Transformer les données au format attendu par le frontend
            $formattedInscriptions = $inscriptions->map(function ($inscription) {
                return [
                    'id' => $inscription->id,
                    'full_name' => $inscription->name,
                    'email' => $inscription->email,
                    'country' => $inscription->pays,
                    'phone' => $inscription->telephone,
                    'course' => $inscription->langue->nom ?? 'N/A',
                    'level' => $inscription->niveau->nom ?? 'N/A',
                    'status' => $inscription->status,
                    'created_at' => $inscription->created_at,
                    'updated_at' => $inscription->updated_at,
                ];
            });
            
            return response()->json([
                'success' => true,
                'registrations' => $formattedInscriptions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération des inscriptions',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 