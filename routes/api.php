<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LangueController;
use App\Http\Controllers\InscriptionController;
use App\Models\User;
use App\Http\Controllers\CourseRegistrationController;

// Route d'authentification
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Routes publiques
Route::get('/langue', [LangueController::class, 'index']);
Route::get('/langue/{nom}', [LangueController::class, 'show']);
Route::post('/inscription', [InscriptionController::class, 'store']);

// Route pour la compatibilité avec l'ancien endpoint d'inscription aux cours
Route::post('/course-registration', [CourseRegistrationController::class, 'register']);

// Route لتفعيل الإيميل
Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {
    $user = User::findOrFail($id);

    if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        return response()->json(['message' => 'Invalid verification link'], 400);
    }

    if ($user->hasVerifiedEmail()) {
        return response()->json(['message' => 'Email already verified'], 400);
    }

    $user->markEmailAsVerified();

    return response()->json(['message' => 'Email verified successfully']);
})->middleware('signed')->name('verification.verify');

// Routes protégées par Sanctum
Route::middleware(['auth:sanctum'])->group(function () {
    // Routes pour tous les utilisateurs authentifiés
    Route::post('/password/email', [AuthController::class, 'forgotPassword']);
    Route::post('/password/reset', [AuthController::class, 'resetPassword']);

    // Routes pour les administrateurs uniquement
    Route::middleware(['admin'])->group(function () {
        // Route pour récupérer toutes les inscriptions (admin)
        Route::get('/inscription', [InscriptionController::class, 'index']);
        Route::put('/inscription/{id}/status', [InscriptionController::class, 'updateStatus']);
        
        // Route pour la rétrocompatibilité avec l'ancien endpoint
        Route::get('/course-registration', [CourseRegistrationController::class, 'index']);
    });
});

// Routes protégées pour l'administration
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::get('/registrations', [App\Http\Controllers\Admin\RegistrationController::class, 'index']);
    Route::put('/registrations/{id}/status', [App\Http\Controllers\Admin\RegistrationController::class, 'updateStatus']);
});
