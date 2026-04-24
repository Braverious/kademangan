<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ChatbotSetting;

class ChatbotController extends Controller
{
    public function adminIndex()
    {
        $settings = ChatbotSetting::pluck('value', 'key');

        $title = "Konfigurasi AI Chatbot";
        $breadcrumbs = [
            ['label' => 'Pengaturan', 'route' => 'admin.dashboard'],
            ['label' => $title, 'route' => null]
        ];

        return view('admin.chatbot.index', compact('settings', 'title', 'breadcrumbs'));
    }

    public function adminUpdate(Request $request)
    {
        $request->validate([
            'system_prompt' => 'required',
            'chatbot_name' => 'required|max:50',
            'chatbot_subtitle' => 'required|max:100',
            'chatbot_color' => 'required'
        ]);

        foreach ($request->except('_token') as $key => $value) {
            ChatbotSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Konfigurasi Chatbot berhasil diperbarui!');
    }

    public function handleChat(Request $request)
    {
        $userMessage = $request->input('message');
        $apiKey = config('services.gemini.key');

        // URL Model 2.5 Flash yang paling stabil
        $url = "https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash-lite:generateContent?key={$apiKey}";
        $dbPrompt = ChatbotSetting::where('key', 'system_prompt')->first();

        $systemContext = $dbPrompt ? $dbPrompt->value : "Anda adalah asisten virtual resmi Kelurahan Kademangan.";

        // Gabungkan dengan penutup agar AI tahu ini adalah pesan dari warga
        $fullPrompt = $systemContext . "\n\nPertanyaan Warga: " . $userMessage;

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
