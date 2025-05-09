<?php
// D:\Project\Python\Laravel\ChatbotAI\app\Http\Controllers\ControllerChatbotAI.php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

use Illuminate\Http\Request;

class ControllerChatbotAI extends Controller
{
    // form chatbot
    public function index(){
        return view('chatbotai.index');
    }

    public function demo(){
        return view('chatbotai.demo');
    }

    public function fetchFastAPI(Request $request)
    {
        // Lấy dữ liệu message từ form
        $message = $request->input('message');

        // Khởi tạo Guzzle client
        $client = new Client();

        // URL của FastAPI endpoint
        $fastApiUrl = 'http://127.0.0.1:8000/ask';

        try {
            // Gửi yêu cầu POST đến FastAPI với dữ liệu JSON
            $response = $client->post($fastApiUrl, [
                'json' => ['question' => $message],
                'timeout' => 60, // thời gian timeout (giây)
            ]);

            $result = json_decode($response->getBody(), true);

            // Lấy kết quả trả về từ FastAPI
            $answer = isset($result['answer']) ? $result['answer'] : "Không nhận được câu trả lời từ FastAPI.";
        } catch (\Exception $e) {
            // Nếu có lỗi xảy ra, trả về thông báo lỗi
            $answer = "Có lỗi xảy ra: " . $e->getMessage();
        }

        // Nếu request là AJAX thì trả về JSON
        if ($request->ajax()) {
            return response()->json(['answer' => $answer]);
        }

        // Nếu không phải AJAX, chuyển sang view (trường hợp khác)
        return view('chatbotai.index', compact('answer'));
    }
}
