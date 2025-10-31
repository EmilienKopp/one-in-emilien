<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{
    /**
     * Send contact form email
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'inquiry' => 'required|string|max:500',
            'message' => 'nullable|string|max:5000'
        ]);

        try {
            // Get the contact email from config or env
            $contactEmail = config('mail.contact_email', config('mail.from.address'));

            // Send the email
            Mail::to($contactEmail)->send(new ContactFormSubmission($validated));

            // Log successful submission
            Log::info('Contact form submitted', [
                'customer_name' => $validated['customer_name'],
                'email' => $validated['email'],
                'inquiry' => $validated['inquiry']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thank you for your message! I will get back to you soon.'
            ], 200);

        } catch (\Exception $e) {
            // Log the error
            Log::error('Contact form email failed', [
                'error' => $e->getMessage(),
                'data' => $validated
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Sorry, there was an error sending your message. Please try again later.'
            ], 500);
        }
    }
}
