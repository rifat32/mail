<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Exception;

class EmailController extends Controller
{
    /**
     * Send contact form email
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendEmail(Request $request)
    {
        // 1. Validate the form data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email',
            'subject'    => 'required|string',
            'message'    => 'required|string|min:3',
        ]);

        // 2. Define the Receiver
        // $receiverEmail = "info@feedgenius.ai";
        $receiverEmail = "web@kalloshr.com";

        // 3. Send the Email
        try {
            Mail::to([$receiverEmail, "rifatblalphilips@gmail.com"])->send(new ContactFormMail($validated));

            return response()->json(['success' => 'Thank you! Your message has been sent successfully.'], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, something went wrong. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
