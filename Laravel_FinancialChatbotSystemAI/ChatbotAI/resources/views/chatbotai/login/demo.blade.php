<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Thêm CSRF token để bảo mật -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel & FastAPI Integration</title>
</head>
<body>
    <h1>Send a Message to FastAPI</h1>

    <!-- Form nhập message -->
    <form id="messageForm" method="POST" action="{{ route('fetchFastAPI') }}">
        @csrf
        <div>
            <label for="message">Message:</label>
            <input type="text" id="message" name="message" required>
        </div>
        <button type="submit">Send</button>
    </form>

    <h2>Response from FastAPI:</h2>
    <!-- Hiển thị loading khi chờ kết quả -->
    <div id="loadingMessage" style="display:none;">Loading...</div>
    <pre id="response"></pre>

    <!-- Sử dụng Fetch API để xử lý submit form -->
    <script>
        document.getElementById('messageForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Ngăn chặn submit form theo kiểu thông thường

            // Lấy giá trị message
            const message = document.getElementById('message').value;
            // Hiển thị thông báo loading
            document.getElementById('loadingMessage').style.display = 'block';

            // Gửi yêu cầu bằng Fetch API
            fetch(this.action, {
                method: 'POST',
                headers: {
'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: message })
            })
            .then(response => response.json())
            .then(data => {
                // Ẩn loading khi đã nhận được kết quả
                document.getElementById('loadingMessage').style.display = 'none';
                // Hiển thị kết quả trên trang
                document.getElementById('response').innerText = data.answer;
            })
            .catch(error => {
                document.getElementById('loadingMessage').style.display = 'none';
                document.getElementById('response').innerText = 'Error: ' + error;
            });
        });
    </script>
</body>
</html>
