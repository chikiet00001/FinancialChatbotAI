<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot Website</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('https://www.vib.com.vn/wps/wcm/connect/9da8e971-71e4-4c0b-a2b0-9e12f2233073/1/chu-ky-kinh-te-1.jpg?MOD=AJPERES'); /* Thay 'path_to_your_image.jpg' bằng đường dẫn đến ảnh của bạn */
            background-size: cover; /* Đảm bảo ảnh phủ toàn bộ màn hình */
            background-position: center center; /* Căn giữa ảnh nền */
            background-attachment: fixed; /* Giữ ảnh nền cố định khi cuộn trang */
            display: flex;
            justify-content: center; /* Căn giữa theo chiều ngang */
            align-items: center; /* Căn giữa theo chiều dọc */
            height: 100vh; /* Chiều cao đầy đủ của màn hình */
        }

        /* Tạo lớp phủ bán trong suốt trên ảnh nền */
        body::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Đặt màu đen với độ trong suốt 50% */
            z-index: -1; /* Đảm bảo lớp phủ nằm phía dưới các phần tử khác */
        }

        /* Header Styles */
        header {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
            position: fixed; /* Giữ header luôn ở trên cùng */
            width: 100%; /* Đảm bảo header chiếm hết chiều rộng */
            top: 0; /* Cố định ở phía trên */
            z-index: 1000; /* Đảm bảo header nằm trên các phần tử khác */
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .login-container button {
            margin-right: 30px; 
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: #0056b3;
        }

        /* Chatbot Styles */
        .chatbox-container {
            width: 70%; /* Kích thước rộng của hộp chat */
            height: 600px; /* Kích thước cao của hộp chat */
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column; /* Căn chỉnh các phần tử theo chiều dọc */
            justify-content: space-between;
            margin-top: 60px; /* Đẩy chatbox xuống dưới header */
        }

        .chatbox-header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .chatbox-messages {
            flex-grow: 1;
            overflow-y: auto;
            padding: 10px;
            background-color: #f9f9f9;
            border-bottom: 1px solid #ccc;
        }

        /* Các tin nhắn */
        .chatbox-messages p {
            margin: 5px 0;
            padding: 8px;
            border-radius: 5px;
        }

        /* Tin nhắn của người dùng (hiển thị bên phải) */
        .chatbox-messages .user-message {
            background-color: #d1ffd6;
            text-align: right;
            margin-left: 50px; /* Đẩy ra để không bị chồng lên */
        }

        /* Tin nhắn của chatbot (hiển thị bên trái) */
        .chatbox-messages .bot-message {
            background-color: #f0f0f0;
            text-align: left;
            margin-right: 50px; /* Đẩy ra để không bị chồng lên */
        }

        input[type="text"] {
            width: calc(100% - 70px);
            padding: 8px;
            margin: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 8px 16px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }
        .btnController{
            width: 20%;
            height: 50px;
            margin-top: 10px;
            border-radius: 10px;
        }

    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <h1 style="margin-left: 30px">Chatbot</h1>
            <div class="login-container" style="display: flex;">

                {{-- @if (empty(Auth::user())){
                    $user = 
                }
                @else

                @endif --}}
                <h3 style="margin-right: 30px">Xin chào, {{Auth::user()->username}}</h3>

                @if (Auth::user()->role == "admin")
                    <button id="loginBtn" class="btnController">
                        Admin
                    </button>
                @else
                    <button id="loginBtn" class="btnController" style="pointer-events: none; opacity: 0.5;">
                        User
                    </button>
                @endif
                
                @if (!Auth::check())
                    <button id="loginBtn" class="btnController">
                        <a href="{{ route('register') }}"Đăng Nhập>
                    </button>
                @else
                @auth
                    <form action="{{ route('logout') }}" method="POST" style="display: inline; width: 20%; margin-right: 30px">
                        @csrf
                        <button type="submit" style="width: 100%; height: 50px; margin-top: 10px; border-radius: 10px;">
                            Đăng Xuất
                        </button>
                    </form>
                @endauth
                @endif
            </div>
        </div>
    </header>

    <!-- Chatbot Area -->
    <div class="chatbox-container">
        <div class="chatbox-header">
            <span>Chatbot</span>
        </div>
        <div class="chatbox-messages" id="chatMessages">
            <!-- Messages will appear here -->
        </div>
        <input type="text" id="userInput" placeholder="Nhập tin nhắn..." />
        <button id="sendBtn">Gửi</button>
    </div>

    {{-- <script src="script.js"></script> --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
        const loginBtn = document.getElementById("loginBtn");
        const sendBtn = document.getElementById("sendBtn");
        const userInput = document.getElementById("userInput");
        const chatMessages = document.getElementById("chatMessages");

        // Hiển thị hoặc ẩn màn hình đăng nhập
        loginBtn.addEventListener("click", () => {
            const username = prompt("Nhập tên tài khoản:");
            if (username) {
                loginBtn.textContent = `Xin chào, ${username}`;
                loginBtn.disabled = true;
            }
        });

        // Chức năng gửi tin nhắn của chatbot
        sendBtn.addEventListener("click", () => {
            const message = userInput.value.trim();
            if (message) {
                // Tạo tin nhắn của người dùng
                const userMessage = document.createElement("p");
                userMessage.textContent = `Bạn: ${message}`;
                userMessage.classList.add('user-message'); // Thêm class cho tin nhắn người dùng
                    chatMessages.appendChild(userMessage);
                    
                    // Tạo phản hồi từ chatbot
                    setTimeout(() => {
                        const botMessage = document.createElement("p");
                        botMessage.textContent = `Chatbot: Đang xử lý...`;
                        botMessage.classList.add('bot-message'); // Thêm class cho tin nhắn chatbot
                        chatMessages.appendChild(botMessage);
                        chatMessages.scrollTop = chatMessages.scrollHeight; // Cuộn xuống cuối
                    }, 500);

                    userInput.value = ""; // Xóa input
                }
            });
        });
    </script>
</body>
</html>