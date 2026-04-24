<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function handleChat(Request $request)
    {
        $userMessage = $request->input('message');
        $apiKey = config('services.gemini.key');

        // URL Model 2.5 Flash yang paling stabil
        $url = "https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash-lite:generateContent?key={$apiKey}";
        // JALAN TIKUS: Kita jadikan instruksi sistem sebagai "Konteks" di awal pesan
        $systemContext = "Anda adalah asisten virtual resmi Kelurahan Kademangan. Bantu warga dengan informasi layanan publik yang akurat dan ramah.\n\n---\nPertanyaan Warga: ";

        // Payload yang super aman, pasti diterima Google
        $payload = [
            "contents" => [
                [
                    "role" => "user",
                    "parts" => [
                        // Kita gabungkan konteks kelurahan dengan pertanyaan user
                        ["text" => $systemContext . $userMessage]
                    ]
                ]
            ],
            "generationConfig" => [
                "temperature" => 0.7,
                "maxOutputTokens" => 1000
            ]
        ];

        try {
            $response = Http::withoutVerifying()
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, $payload);

            if ($response->failed()) {
                $errorData = $response->json();
                $errorMessage = $errorData['error']['message'] ?? 'Unknown Error';
                return response()->json(['reply' => "Google Error: " . $errorMessage], 500);
            }

            $result = $response->json();

            // Ekstrak jawaban
            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                $reply = $result['candidates'][0]['content']['parts'][0]['text'];
            } else {
                $reply = "Maaf, saya tidak bisa menjawab pertanyaan itu karena kebijakan keamanan.";
            }

            return response()->json(['reply' => $reply]);
        } catch (\Exception $e) {
            return response()->json(['reply' => 'Exception: ' . $e->getMessage()], 500);
        }
    }
}
