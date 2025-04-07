<!--  resources\views\chatbotai\login\demo.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div id="userForm" class="form-container">
        <h3 id="formTitle">Thêm Người Dùng</h3>
        <form action="{{ route('store') }}" method="POST">
            @csrf
            <label>Tên:
                <input type="text" id="nameField" name="username" required>
            </label>
    
            <label>Email:
                <input type="email" id="emailField" name="email" required>
            </label>
    
            <label>Vai trò:
                <select id="roleField" name="role">
                    <option value="user">Người dùng</option>
                    <option value="admin">Quản trị viên</option>
                </select>
            </label>
    
            <label>Mật khẩu:
                <input type="password" id="passwordField" name="password" required>
            </label>
    
            <label>Xác nhận mật khẩu:
                <input type="password" id="confirmPasswordField" name="password_confirmation" required>
            </label>
    
            <div class="form-buttons">
                <button type="submit" id="saveUserBtn">Lưu</button>
                <button type="button" id="cancelBtn">Hủy</button>
            </div>
        </form>
    </div>
    
</body>
</html>