<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiController extends Controller
{
    public function generateChapter(Request $request)
    {

        $prompt = $request->input('prompt');
        $apiKey = env('HUGGINGFACE_API_KEY');
        if (!$apiKey) {
            return response()->json(['error' => 'API key not found in .env'], 500);
        }

        $url = 'https://api-inference.huggingface.co/models/mistralai/Mixtral-8x7B-Instruct-v0.1/v1/chat/completions';

        $postData = [
            'model' => 'mistralai/Mixtral-8x7B-Instruct-v0.1',
            'messages' => [
                ['role' => 'system', 'content' => 'Ты — опытный писатель. Отвечай только на русском языке.'],
                ['role' => 'user', 'content' => $prompt]],
            'stream' => false,
        ];


        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return response()->json(['error' => 'cURL Error: ' . $error], 500);
        }

        curl_close($ch);
        $responseData = json_decode($response, true);

        if (isset($responseData['error'])) {
            return response()->json(['error' => 'API Error: ' . $responseData['error']], 500);
        }

        $generatedText = $responseData['choices'][0]['message']['content'] ?? 'No content generated';
        return response()->json([['generated_text' => $generatedText]]);
    }
}
