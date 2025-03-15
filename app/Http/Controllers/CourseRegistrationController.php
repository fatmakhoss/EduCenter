<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseRegistration;
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
            // Enregistrer l'inscription
            $registration = CourseRegistration::create([
                'full_name' => $request->fullName,
                'email' => $request->email,
                'country' => $request->country,
                'phone' => $request->phone,
                'level' => $request->level,
                'course' => $request->course,
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
} 