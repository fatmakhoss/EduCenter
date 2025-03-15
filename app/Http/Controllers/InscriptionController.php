<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\DB;

class InscriptionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'langue_id' => 'required|exists:langues,id',
            'niveau_id' => 'required|exists:niveaux,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email|unique:inscriptions,email',
            'pays' => 'required|string',
            'telephone' => 'required|string',
        ]);

        $inscription = Inscription::create([
            'langue_id' => $request->langue_id,
            'niveau_id' => $request->niveau_id,
            'name' => $request->name,
            'email' => $request->email,
            'pays' => $request->pays,
            'telephone' => $request->telephone,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'طلب التسجيل تم إرساله بنجاح، في انتظار موافقة المدير'], 201);
    }

    public function index()
    {
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
        
        return response()->json(['registrations' => $formattedInscriptions]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $inscription = Inscription::findOrFail($id);
        $inscription->update(['status' => $request->status]);

        if ($request->status === 'accepted') {
            // Vérifier si l'email est déjà utilisé
            if (User::where('email', $inscription->email)->exists()) {
                return response()->json([
                    'message' => 'Cet email est déjà utilisé, impossible de créer un nouvel utilisateur.',
                ], 400);
            }

            DB::beginTransaction();
            try {
                $password = Str::random(8);

                $user = User::create([
                    'name' => $inscription->name,
                    'email' => $inscription->email,
                    'password' => bcrypt($password),
                    'role' => 'eleve',
                ]);

                Log::info('Attempting to send verification email:', ['email' => $inscription->email]);
                $user->sendEmailVerificationNotification();

                Log::info('Attempting to send welcome email:', ['email' => $inscription->email]);
                Mail::to($inscription->email)->send(new WelcomeEmail($inscription->name, $inscription->email, $password));

                Log::info('Emails sent successfully:', ['email' => $inscription->email]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error creating user or sending emails:', ['error' => $e->getMessage()]);
                return response()->json(['message' => 'Une erreur est survenue, veuillez réessayer.'], 500);
            }
        }

}
}
