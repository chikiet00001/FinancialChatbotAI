<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chatbot Website</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Favicon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+5hb7O+6MBZcUKFj5cI1kD2T5qbsW1Z7H5gJv6H" crossorigin="anonymous">
    <link rel="icon" type="image/png"
        href="https://www.shutterstock.com/shutterstock/photos/1374663482/display_1500/stock-vector-bot-icon-chatbot-icon-vector-flat-line-cartoon-illustration-isolated-on-white-background-voice-1374663482.jpg">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('https://www.vib.com.vn/wps/wcm/connect/9da8e971-71e4-4c0b-a2b0-9e12f2233073/1/chu-ky-kinh-te-1.jpg?MOD=AJPERES');
            /* Thay 'path_to_your_image.jpg' bằng đường dẫn đến ảnh của bạn */
            background-size: cover;
            /* Đảm bảo ảnh phủ toàn bộ màn hình */
            background-position: center center;
            /* Căn giữa ảnh nền */
            background-attachment: fixed;
            /* Giữ ảnh nền cố định khi cuộn trang */
            display: flex;
            justify-content: center;
            /* Căn giữa theo chiều ngang */
            align-items: center;
            /* Căn giữa theo chiều dọc */
            height: 100vh;
            /* Chiều cao đầy đủ của màn hình */
        }

        /* Tạo lớp phủ bán trong suốt trên ảnh nền */
        body::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Đặt màu đen với độ trong suốt 50% */
            z-index: -1;
            /* Đảm bảo lớp phủ nằm phía dưới các phần tử khác */
        }

        /* Header Styles */
        header {
            background-color: #ffffff;
            color: rgb(95, 87, 87);
            padding: 10px;
            text-align: center;
            position: fixed;
            /* Giữ header luôn ở trên cùng */
            width: 100%;
            /* Đảm bảo header chiếm hết chiều rộng */
            top: 0;
            /* Cố định ở phía trên */
            z-index: 1000;
            /* Đảm bảo header nằm trên các phần tử khác */
        }

        .header-container {
            border: 1pt solid #e3e3e3;     /* Viền xung quanh */
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .login-container button {
            margin-right: 30px;
            padding: 8px 16px;
            background-color: #11b066;
            color: white;
            border: none;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: #0056b3;
        }

        /* Chatbot Styles */
        .chatbox-container {
            align-items: center;      
            width: 100%;
            /* Kích thước rộng của hộp chat */
            height: 90%;
            /* Kích thước cao của hộp chat */
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            /* Căn chỉnh các phần tử theo chiều dọc */
            justify-content: space-between;
            margin-top: 60px;
            /* Đẩy chatbox xuống dưới header */
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
            width: 80%;
            flex-grow: 1;
            overflow-y: auto;
            padding: 10px;
            background-color: #ffffff;
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
            margin-left: 50px;
            /* Đẩy ra để không bị chồng lên */
        }

        /* Tin nhắn của chatbot (hiển thị bên trái) */
        .chatbox-messages .bot-message {
            background-color: #f0f0f0;
            text-align: left;
            margin-right: 50px;
            /* Đẩy ra để không bị chồng lên */
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

        .btnController {
            width: 20%;
            height: 50px;
            margin-top: 10px;
            border-radius: 10px;
        }

        .styled-textarea {
            width: 100%;                /* Đặt chiều rộng của textarea là 100% */
            height: 70px;               /* Đặt chiều cao của textarea */
            font-size: 16px;            /* Kích thước chữ */
            padding: 10px;              /* Khoảng cách trong textarea */
            border: 1px solid #ccc;    /* Viền mỏng xung quanh */
            border-radius: 10px;       /* Bo tròn các góc */
            background-color: #f9f9f9; /* Màu nền nhẹ */
            color: #333;               /* Màu chữ */
            box-sizing: border-box;    /* Bao gồm padding và border trong kích thước */
            resize: none;              /* Tắt tính năng thay đổi kích thước */
        }

        .styled-textarea:focus {
            border-color: #11b066;     /* Màu viền khi textarea được focus */
            outline: none;             /* Loại bỏ outline mặc định */
        }

        .button-container {
            width: 75%;
            display: flex;           /* Sử dụng Flexbox để xếp các phần tử theo chiều ngang */
            justify-content: flex-start;  /* Căn chỉnh các nút sang bên phải */
            gap: 10px;               /* Thêm khoảng cách giữa các nút */
        }
        .fasttext{
            border-radius: 10px;
            padding: 10px 20px;      /* Khoảng cách bên trong các nút */
            background-color: #eeeee8; /* Màu nền xanh cho nút */
            color: rgb(133, 132, 132);            /* Màu chữ trắng */
            border: none;            /* Loại bỏ viền nút */
            cursor: pointer;        /* Con trỏ chuột thay đổi khi di chuột vào nút */
            font-size: 14px;         /* Kích thước chữ */
        }
        .fasttext:hover {
            background-color: #ffffff;  /* Màu nền khi hover */
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <div style="margin-left: 45px; display: flex;">
                <img style="width: 60px; height: 60px; margin-top: 5px; border-radius: 100%; border: 1px solid #ccc;"
                    src="https://www.shutterstock.com/shutterstock/photos/1374663482/display_1500/stock-vector-bot-icon-chatbot-icon-vector-flat-line-cartoon-illustration-isolated-on-white-background-voice-1374663482.jpg"
                    alt="Mô tả hình ảnh">
                <h1>TÀI CHÍNH</h1>
            </div>

            <div class="login-container" style="display: flex;">

                @if (!Auth::user()){
                    <script>
                        window.location.href = "{{ route('login') }}"; // Chuyển hướng đến trang đăng nhập
                    </script>
                    }
                @else
                    <h3 style="margin-right: 30px">Xin chào, {{ Auth::user()->username }}</h3>
                    @if (Auth::user()->role == 'admin')
                        <form action="{{ route('admindisplay') }}" method="POST"
                            style="display: inline; width: 20%; margin-right: 30px">
                            @csrf
                            <button type="submit"
                                style="width: 100%; height: 30px; margin-top: 10px; border-radius: 10px; margin-top: 15px;">
                                <i class="fas fa-user-shield" style="margin-right: 5px;"></i>Admin
                            </button>
                        </form>
                    @else
                        <button id="loginBtn" class="btnController"
                            style="pointer-events: none; opacity: 0.5; margin-top: 15px;">
                            <i class="fas fa-user" style="margin-right: 5px;">User
                        </button>
                    @endif

                    @if (!Auth::check())
                        <button id="loginBtn" class="btnController">
                            <a href="{{ route('register') }}"Đăng Nhập>
                        </button>
                    @else
                        @auth
                            <form action="{{ route('logout') }}" method="POST"
                                style="display: inline; width: 20%; margin-right: 30px">
                                @csrf
                                <button type="submit"
                                    style="width: 110%; height: 30px; margin-top: 10px; border-radius: 10px; margin-top: 15px;">
                                    <i class="fas fa-sign-out-alt" style="margin-right: 5px;"></i>Đăng Xuất
                                </button>
                            </form>
                        @endauth
                    @endif
                @endif
            </div>
        </div>
    </header>

    <!-- Chatbot Area -->

    <div class="chatbox-container">
        <div class="chatbox-header"></div>
        <div class="chatbox-messages" id="chatMessages">
            <div style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <img style="width: 100px; height: 100px; margin-top: 50px; border-radius: 100%; border: 1px solid #ccc;"
                    src="https://www.shutterstock.com/shutterstock/photos/1374663482/display_1500/stock-vector-bot-icon-chatbot-icon-vector-flat-line-cartoon-illustration-isolated-on-white-background-voice-1374663482.jpg"
                    alt="Mô tả hình ảnh">
                <h1 style="color: #11b066; margin-top: 20px; margin-bottom: 0px; font-size: 35px;">Chào mừng đã đến với
                    CHATBOT TÀI CHÍNH</h1>
                <p style="color: #6b6b6b">bạn có thể hỏi tôi về bất kỳ điều gì liên quan đến tài chính</p>
            </div>

            <!-- Messages will appear here -->
        </div>

        <form id="messageForm" method="POST" action="{{ route('fetchFastAPI') }}" style="width: 100%;"
            onsubmit="return false;">
            @csrf
            <div style="display: flex; padding: 10px; margin-left: 10%; margin-right: 10%;">
                <textarea name="message" id="userInput" placeholder="Nhập câu hỏi về Tài chính..." class="styled-textarea" required></textarea>
                {{-- <input type="text" id="userInput" name="message" placeholder="Nhập tin nhắn..." required
                    style="height: 50px;" /> --}}
                <button id="sendBtn" type="submit" style="margin-left: 10px; margin-right: 10px; border-radius: 100%; background-color: #1db66f; height: 40px;"><i class="fas fa-paper-plane"></i></button>
            </div>
        </form>

        <div class="button-container" id="buttonContainer" style="margin-bottom: 20px;">
            <button class="fasttext">Kinh tế Việt Nam 2024 phát triển như thế nào?</button>
            <button class="fasttext">Tổng thống Mỹ đã áp thuế lên Việt Nam bao nhiêu?</button>
            <button class="fasttext">Lạm phát Việt Nam hiện tại là bao nhiêu?</button>
        </div>
    </div>
    
    <script>
        // Lắng nghe sự kiện click cho tất cả các button có class 'fasttext'
function enableFastTextButtons() {
    const buttons = document.querySelectorAll('#buttonContainer .fasttext');
    
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            // Lấy giá trị của button khi nhấn
            const buttonText = this.innerText;
            document.getElementById("userInput").value = buttonText; // Gán giá trị vào ô nhập liệu
        });
    });
}

// Khởi động lại sự kiện cho các button khi trang được tải
enableFastTextButtons();

        document.getElementById('messageForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Ngăn chặn submit form theo kiểu thông thường

            // Lấy giá trị message
            const message = document.getElementById('userInput').value.trim();
            if (message) {
                const chatMessages = document.getElementById("chatMessages");

                // Tạo tin nhắn của người dùng
                const userMessage = document.createElement("p");
                userMessage.textContent = `${message}`;
                userMessage.classList.add('user-message'); // Thêm class cho tin nhắn người dùng
                chatMessages.appendChild(userMessage);

                // // Tạo phản hồi từ chatbot
                // setTimeout(() => {
                //     const botMessage = document.createElement("p");
                //     botMessage.textContent = `Chatbot: Đang xử lý...`;
                //     botMessage.classList.add('bot-message'); // Thêm class cho tin nhắn chatbot
                //     chatMessages.appendChild(botMessage);
                //     chatMessages.scrollTop = chatMessages.scrollHeight; // Cuộn xuống cuối
                // }, 500);

                // Tạo phản hồi từ chatbot (Đang xử lý...)
                const botMessageProcessing = document.createElement("p");
                botMessageProcessing.style.display = "flex"; // Cách này để set thuộc tính CSS display
                botMessageProcessing.style.alignItems = "center"; // Set thuộc tính CSS align-items
                botMessageProcessing.innerHTML = `<i class="fas fa-spinner fa-spin"></i>  Chatbot: Đang xử lý...`;
                botMessageProcessing.classList.add('bot-message'); // Thêm class cho tin nhắn chatbot
                chatMessages.appendChild(botMessageProcessing);
                chatMessages.scrollTop = chatMessages.scrollHeight; // Cuộn xuống cuối

                // Gửi yêu cầu bằng Fetch API
                fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            message: message
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Hiển thị kết quả trả về từ chatbot
                        // const botMessage = document.createElement("p");
                        // botMessage.textContent = data.answer;
                        // botMessage.classList.add('bot-message'); // Thêm class cho tin nhắn chatbot
                        // chatMessages.appendChild(botMessage);
                        // chatMessages.scrollTop = chatMessages.scrollHeight; // Cuộn xuống cuối

                        // Cập nhật tin nhắn từ "Đang xử lý..." thành câu trả lời thực tế từ chatbot 
                        botMessageProcessing.innerHTML = `<img style="width: 40px; height: 40px; margin-right: 15px; border-radius: 100%; margin-right: 15px; border: 1px solid #ccc;"
                            src="https://www.shutterstock.com/shutterstock/photos/1374663482/display_1500/stock-vector-bot-icon-chatbot-icon-vector-flat-line-cartoon-illustration-isolated-on-white-background-voice-1374663482.jpg"
                            alt="Mô tả hình ảnh"> ${data.answer}`;
                        chatMessages.scrollTop = chatMessages.scrollHeight; // Cuộn xuống cuối
                    })
                    .catch(error => {
                        // const botMessage = document.createElement("p");
                        // botMessage.textContent = 'Chatbot: Lỗi - ' + error;
                        // botMessage.classList.add('bot-message');
                        // chatMessages.appendChild(botMessage);
                        // chatMessages.scrollTop = chatMessages.scrollHeight;

                        // Nếu có lỗi, thay thế tin nhắn bằng thông báo lỗi
                        botMessageProcessing.innerHTML = `<i class="fas fa-exclamation-circle"></i>Lỗi - ${error}`;
                        chatMessages.scrollTop = chatMessages.scrollHeight; // Cuộn xuống cuối
                    });

                // Xóa input sau khi gửi tin nhắn
                document.getElementById('userInput').value = "";
            }
        });
    </script>
</body>

</html>
