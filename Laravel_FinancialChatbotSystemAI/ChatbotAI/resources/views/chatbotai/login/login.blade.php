

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Đăng Nhập</title>
    <link rel="stylesheet" href="style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-image: url('https://media.ftv.com.vn/media/tai-chinh-la-gi-1.jpg'); /* Thay 'path_to_your_image.jpg' bằng đường dẫn đến ảnh của bạn */
            background-size: cover; /* Đảm bảo ảnh phủ toàn bộ màn hình */
            background-position: center center; /* Căn giữa ảnh nền */
            background-attachment: fixed; /* Giữ ảnh nền cố định khi cuộn trang */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Tạo lớp phủ bán trong suốt trên ảnh nền */
        body::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8); /* Đặt màu đen với độ trong suốt 50% */
            z-index: -1; /* Đảm bảo lớp phủ nằm phía dưới các phần tử khác */
        }


        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 15px;
        }
        .toggle-container {
            margin-top: 20px;
            font-size: 14px;
        }

        .toggle-container a {
            color: #007bff;
            text-decoration: none;
        }

        .toggle-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Đăng Nhập</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="input-group">
                <label for="username">Tài khoản:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" required>
            </div>
            @error('login_failed')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <button type="submit">Đăng Nhập</button>
        </form>
        <div class="toggle-container">
            <p>Bạn chưa có tài khoản? <a href="{{ route('register') }}">Đăng Ký</a></p>
        </div>
    </div>

    <script src="script.js">
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const errorMessage = document.getElementById('error-message');

            // Kiểm tra thông tin đăng nhập (giả sử tài khoản và mật khẩu đã biết)
            if (username === 'admin' && password === '1234') {
                alert('Đăng nhập thành công!');
                errorMessage.textContent = '';
            } else {
                errorMessage.textContent = 'Tài khoản hoặc mật khẩu không chính xác!';
            }
        });
    </script>
</body>
</html>