<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập Thành Công</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background: #f1f1f1;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }

        .success-box {
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        .success-box h2 {
            color: #4CAF50;
            margin-bottom: 10px;
        }

        .success-box p {
            color: #555;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="success-box">
        <h2>🎉 Đăng Nhập thành công!</h2>
        <p>Đang chuyển hướng đến trang Chatbot...</p>
    </div>

    <script>
        setTimeout(() => {
            window.location.href = "{{ route('chatbotai') }}";
        }, 500); // 0.5 giây
    </script>
</body>
</html>
