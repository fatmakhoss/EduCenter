<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Connexion
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        Log::info('Tentative de connexion :', ['email' => $credentials['email']]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            Log::warning('Utilisateur non trouvé :', ['email' => $credentials['email']]);
            return response()->json(['message' => 'Identifiants incorrects : Email non trouvé'], 401);
        }

        if (!$user->hasVerifiedEmail() && !$user->isAdmin()) {
            Log::warning('Email non vérifié :', ['email' => $user->email, 'role' => $user->role]);
            return response()->json(['message' => 'Veuillez activer votre email d’abord'], 403);
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            Log::warning('Mot de passe incorrect :', ['email' => $user->email]);
            return response()->json(['message' => 'Identifiants incorrects : Mot de passe erroné'], 401);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        Log::info('Connexion réussie :', ['email' => $user->email, 'role' => $user->role]);

        return response()->json([
            'message' => 'Connexion réussie',
            'token' => $token,
            'role' => $user->role,
        ], 200);
    }

    // Déconnexion
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnexion réussie'], 200);
    }

    // Envoi du lien de réinitialisation de mot de passe
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            Log::warning('Mot de passe oublié : Utilisateur non trouvé', ['email' => $request->email]);
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        $status = Password::sendResetLink($request->only('email'));

        Log::info('Statut de l’oubli de mot de passe :', ['status' => $status]);

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Un lien de réinitialisation a été envoyé à votre email'], 200)
            : response()->json(['message' => 'Échec de l’envoi du lien de réinitialisation'], 400);
    }

    // Réinitialisation du mot de passe
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => 'Mot de passe réinitialisé avec succès'], 200)
            : response()->json(['message' => 'Échec de la réinitialisation du mot de passe'], 400);
    }
}
