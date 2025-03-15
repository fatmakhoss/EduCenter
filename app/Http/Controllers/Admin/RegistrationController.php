<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inscription;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        $inscriptions = Inscription::with('langue', 'niveau')->orderBy('created_at', 'desc')->get();
        
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
        
        return response()->json($formattedInscriptions);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected'
        ]);

        $inscription = Inscription::findOrFail($id);
        $inscription->status = $request->status;
        $inscription->save();

        return response()->json([
            'message' => 'Statut mis à jour avec succès',
            'registration' => $inscription
        ]);
    }
} 