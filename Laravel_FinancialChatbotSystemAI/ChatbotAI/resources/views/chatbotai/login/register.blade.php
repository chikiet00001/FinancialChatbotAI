<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Đăng Ký</title>
    <link rel="stylesheet" href="style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-image: url('https://media.ftv.com.vn/media/tai-chinh-la-gi-3.jpg'); /* Thay 'path_to_your_image.jpg' bằng đường dẫn đến ảnh của bạn */
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

        .register-container {
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
        input[type="email"],
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
    <div class="register-container">
        <h2>Đăng Ký Tài Khoản</h2>
        <form id="registerForm" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="input-group">
                <label for="username">Tên đăng nhập:</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" required>
                @error('username')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
    
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
    
            <div class="input-group">
                <label for="password1">Mật khẩu:</label>
                <input type="password" id="password1" name="password1" required>
                @error('password1')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
    
            <div class="input-group">
                <label for="password2">Nhập lại mật khẩu:</label>
                <input type="password" id="password2" name="password2" required>
                @error('password2')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
    
            <button type="submit">Đăng Ký</button>
            <p id="error-message" class="error-message"></p>
        </form>
        <div class="toggle-container">
            <p>Bạn đã có tài khoản? <a href="{{ route('login') }}">Đăng Nhập</a></p>
        </div>
    </div>

    <script src="script.js">
        document.getElementById('registerForm').addEventListener('submit', function(event) {
        event.preventDefault();
    
        const username = document.getElementById('username').value;
        const email = document.getElementById('email').value;
        const password1 = document.getElementById('password1').value;
        const password2 = document.getElementById('password2').value;
        const errorMessage = document.getElementById('error-message');
    
        // Kiểm tra mật khẩu có khớp hay không
        if (password1 !== password2) {
            errorMessage.textContent = 'Mật khẩu không khớp!';
            return;
        }
    
        // Kiểm tra độ dài mật khẩu (ít nhất 6 ký tự)
        if (password1.length < 6) {
            errorMessage.textContent = 'Mật khẩu phải có ít nhất 6 ký tự!';
            return;
        }
    
        // Nếu tất cả đều hợp lệ
        alert('Đăng ký thành công!');
            errorMessage.textContent = '';
        });
    </script>
</body>
</html>
