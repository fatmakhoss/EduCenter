<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseRegistration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = CourseRegistration::orderBy('created_at', 'desc')->get();
        return response()->json($registrations);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $registration = CourseRegistration::findOrFail($id);
        $registration->status = $request->status;
        $registration->save();

        return response()->json([
            'message' => 'Statut mis à jour avec succès',
            'registration' => $registration
        ]);
    }
} 