{{-- resources\views\chatbotai\manager\admin.blade.php --}}
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Admin - Quản lý Người dùng</title>
    <link rel="stylesheet" href="style.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Tổng thể bố cục */
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 10px;
        }

        /* Thanh công cụ (tìm kiếm + nút thêm) */
        .toolbar {
            display: flex;
            align-items: center;
            margin-bottom: 1em;
        }

        .toolbar #searchInput {
            flex: 1;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .toolbar #addUserBtn {
            margin-left: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 16px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
        }

        .toolbar #addUserBtn:hover {
            background-color: #45a049;
        }

        /* Bảng danh sách người dùng */
        #userTable {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
        }

        #userTable th,
        #userTable td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        #userTable thead th {
            background-color: #f1f1f1;
        }

        #userTable tbody tr:hover {
            background-color: #f9f9f9;
        }

        /* Nút trong bảng (Sửa/Xóa) */
        .edit-btn,
        .delete-btn {
            border: none;
            color: #fff;
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
        }

        .edit-btn {
            background-color: #2196F3;
        }

        .delete-btn {
            background-color: #f44336;
        }

        .edit-btn:hover {
            background-color: #0b7dda;
        }

        .delete-btn:hover {
            background-color: #d32f2f;
        }

        .edit-btn {
            margin-right: 5px;
        }

        /* Form thêm/sửa user */
        #userFormEdit,
        #userForm {
            border: 1px solid #ccc;
            background-color: #fafafa;
            padding: 20px;
            width: 300px;
            /* Đặt chiều rộng form */
            margin: auto;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            /* Căn giữa form theo cả chiều ngang và chiều dọc */
            display: none;
            /* Đảm bảo form ẩn lúc đầu */
            z-index: 1000;
            /* Đảm bảo form hiển thị phía trên các phần tử khác */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Tạo bóng cho form */
        }

        #userFormEdit h3,
        #userForm h3 {
            margin-top: 0;
            text-align: center;
        }

        #userFormEdit label,
        #userForm label {
            display: block;
            margin: 8px 0;
        }

        #userFormEdit input,
        #userForm input,
        #userFormEdit select,
        #userForm select {
            width: 100%;
            padding: 6px;
            margin-top: 2px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-buttons {
            text-align: right;
            margin-top: 10px;
        }

        #saveUserBtn,
        #cancelBtn {
            border: none;
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
        }

        #saveUserBtn {
            background-color: #008CBA;
            /* xanh dương */
            color: #fff;
        }

        #saveUserBtn:hover {
            background-color: #007bb5;
        }

        #cancelBtn {
            background-color: #6c757d;
            /* xám đậm */
            color: #fff;
            margin-left: 5px;
        }

        #cancelBtn:hover {
            background-color: #5a6268;
        }

        /* Phân trang */
        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .pagination button {
            padding: 8px 16px;
            font-size: 14px;
            border: 1px solid #ddd;
            background-color: #f1f1f1;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 5px;
        }

        .pagination button:hover {
            background-color: #ddd;
        }

        .pagination button:disabled {
            background-color: #f9f9f9;
            cursor: not-allowed;
        }

        #userFormDelete {
            display: none;
            /* Ẩn form ban đầu */
            position: fixed;
            /* Đặt form ở vị trí cố định */
            top: 50%;
            /* Căn giữa theo chiều dọc */
            left: 50%;
            /* Căn giữa theo chiều ngang */
            transform: translate(-50%, -50%);
            /* Điều chỉnh vị trí để form hoàn toàn căn giữa */
            background-color: white;
            /* Màu nền trắng cho form */
            padding: 20px;
            /* Khoảng cách bên trong form */
            border: 1px solid #ccc;
            /* Đường viền xung quanh form */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            /* Hiệu ứng đổ bóng nhẹ */
            z-index: 1000;
            /* Đảm bảo form xuất hiện trên các phần tử khác */
        }

        .form-container {
            max-width: 400px;
            /* Đặt chiều rộng tối đa của form */
            width: 100%;
            /* Form sẽ có chiều rộng tối đa là 400px nhưng vẫn có thể co giãn theo màn hình */
        }

        .form-buttons {
            display: flex;
            justify-content: space-between;
            /* Đặt các nút "Xóa" và "Hủy" cách nhau */
        }
    </style>

</head>

<body>
    <div class="container">
        <!-- Hiển thị thông báo nếu có -->
        @if (session('success'))
            <div id="successMessage" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h1>Quản lý Người dùng</h1>
        <!-- Thanh tìm kiếm và nút Thêm -->
        <div class="toolbar">
            <input type="text" id="searchInput" placeholder="Tìm kiếm người dùng...">
            <button id="addUserBtn" class="add-btn" style="margin-right: 5px">Thêm Người dùng</button>

            <button id="LoadingBtn" style="pointer-events: none; opacity: 0.5;">Loading...</button>
            <!-- Nút bấm để gửi yêu cầu -->
            <button id="StatusBtn" style="display: none; pointer-events: none; opacity: 0.5;">Đang cập nhật...</button>
            <button id="startTaskBtn" style="display: none;">Cập nhật</button>

            <script>
                // Hàm gọi API để kiểm tra trạng thái tác vụ
                function checkTaskStatus() {
                    // API của bạn, ví dụ: /chatbotai/admin
                    fetch('http://localhost:8000/check_task/task') // Thay URL phù hợp
                        .then(response => response.json()) // Giải mã JSON trả về
                        .then(data => {
                            // Cập nhật trạng thái tác vụ lên giao diện
                            const taskStatus = document.getElementById("taskStatus");
                            if (data.result === true) {
                                // taskStatus.innerText = "Task is in progress..."; // Nếu trạng thái là true
                                document.getElementById("StatusBtn").style.display = "block";
                                document.getElementById("LoadingBtn").style.display = "none";
                                document.getElementById("startTaskBtn").style.display = "none";
                            } else {
                                // taskStatus.innerText = "Task has completed."; // Nếu trạng thái là false
                                document.getElementById("startTaskBtn").style.display = "block";
                                document.getElementById("LoadingBtn").style.display = "none";
                                document.getElementById("StatusBtn").style.display = "none";
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            document.getElementById("taskStatus").innerText = "Error fetching task status.";
                        });
                }
                // Gọi hàm checkTaskStatus mỗi 5 giây (5000ms)
                setInterval(checkTaskStatus, 10000);
            </script>
        </div>

        <!-- Bảng danh sách User -->
        <table id="userTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <!-- Các hàng người dùng sẽ được render bằng JS -->
            </tbody>
        </table>

        <!-- Phân trang -->
        <div id="pagination" class="pagination">
            <button id="prevPage" onclick="changePage('prev')">Quay lại</button>
            <button id="nextPage" onclick="changePage('next')">Tiếp theo</button>
        </div>

        <!-- Form thêm User (ẩn lúc đầu) -->
        <div id="userForm" class="form-container">
            <h3 id="formTitle">Thêm Người Dùng</h3>
            <form id="userFormAction" method="POST" action="{{ route('userstore') }}">
                @csrf
                <label>Tên: <input type="text" id="nameField" name="username" required></label>
                <label>Email: <input type="email" id="emailField" name="email" required></label>
                <label>Vai trò:
                    <select id="roleField" name="role">
                        <option value="user">Người dùng</option>
                        <option value="admin">Quản trị viên</option>
                    </select>
                </label>
                <label>Mật khẩu:<input type="password" id="passwordField" name="password" required></label>
                <label>Xác nhận mật khẩu:<input type="password" id="confirmPasswordField" name="password_confirmation"
                        required></label>
                <div class="form-buttons">
                    <button type="submit" id="saveUserBtn">Lưu</button>
                    <button type="button" id="cancelBtn">Hủy</button>
                </div>
            </form>
        </div>

        <!-- Form thêm Sửa (ẩn lúc đầu) -->
        <div id="userFormEdit" class="form-container">
            <h3 id="formTitle">Sửa Người Dùng</h3>
            <form id="userFormEditAction" method="POST" action="{{ route('userupdate') }}">
                <input type="hidden" id="userid" name="userid">
                @csrf
                @method('PUT')
                <label>Tên:
                    <input type="text" id="nameFieldEdit" name="username" required>
                </label>

                <label>Email:
                    <input type="email" id="emailFieldEdit" name="email" required>
                </label>

                <label>Vai trò:
                    <select id="roleFieldEdit" name="role">
                        <option value="user">Người dùng</option>
                        <option value="admin">Quản trị viên</option>
                    </select>
                </label>

                <label>Mật khẩu:
                    <input type="password" id="passwordFieldEdit" name="password" required>
                </label>

                <label>Xác nhận mật khẩu:
                    <input type="password" id="confirmPasswordFieldEdit" name="password_confirmation" required>
                </label>

                <div class="form-buttons">
                    <button type="submit" id="saveBtnEdit">Lưu</button>
                    <button type="button" id="cancelBtnEdit">Hủy</button>
                </div>
            </form>
        </div>

        <!-- Form Xóa Người Dùng (ẩn lúc đầu) -->
        <div id="userFormDelete" class="form-container">
            <h3>Xóa Người Dùng</h3>
            <h4 id="usernameDelete">người dùng</h4>
            <p>Bạn có chắc muốn xóa người dùng này?</p>
            <form method="POST" action="" id="deleteUserForm">
                @csrf
                @method('DELETE')
                <input type="hidden" id="userid" name="userid">
                <div class="form-buttons">
                    <button type="submit"
                        onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">Xóa</button>
                    <button type="button" id="cancelDeleteBtn">Hủy</button>
                </div>
            </form>
        </div>

    </div>

    <script>
        // Load dữ liệu
        let users = @json($users);

        let editingIndex = null;

        // Trang hiện tại và số lượng user mỗi trang
        let currentPage = parseInt(localStorage.getItem('currentPage')) ||
            1; // Khôi phục trang hiện tại từ localStorage hoặc mặc định là trang 1
        const usersPerPage = 10;
        const tableBody = document.getElementById("userTableBody");
        const searchInput = document.getElementById("searchInput");
        const userFormDiv = document.getElementById("userForm");
        const userFormEdit = document.getElementById("userFormEdit");
        const userFormDelete = document.getElementById("userFormDelete");
        const userid = document.getElementById("userid");
        const nameField = document.getElementById("nameField");
        const emailField = document.getElementById("emailField");
        const nameFieldEdit = document.getElementById("nameFieldEdit");
        const emailFieldEdit = document.getElementById("emailFieldEdit");
        const roleField = document.getElementById("roleField");
        const roleFieldEdit = document.getElementById("roleFieldEdit");
        const saveBtn = document.getElementById("saveUserBtn");
        const saveBtnEdit = document.getElementById("saveBtnEdit");
        const cancelBtn = document.getElementById("cancelBtn");
        const cancelBtnEdit = document.getElementById("cancelBtnEdit");
        const cancelDeleteBtn = document.getElementById("cancelDeleteBtn");
        const addBtn = document.getElementById("addUserBtn");

        // Hàm hiển thị lại bảng user từ dữ liệu
        function renderTable() {
            tableBody.innerHTML = "";
            const startIndex = (currentPage - 1) * usersPerPage;
            const endIndex = startIndex + usersPerPage;
            const currentUsers = users.slice(startIndex, endIndex);

            currentUsers.forEach((user, index) => {
                const row = document.createElement("tr");

                // Cột ID
                const idCell = document.createElement("td");
                idCell.textContent = user.id; // Hiển thị ID
                row.appendChild(idCell);

                // Cột Tên
                const nameCell = document.createElement("td");
                nameCell.textContent = user.username;
                row.appendChild(nameCell);

                // Cột Email
                const emailCell = document.createElement("td");
                emailCell.textContent = user.email;
                row.appendChild(emailCell);

                // Cột Vai trò
                const roleCell = document.createElement("td");
                roleCell.textContent = user.role;
                row.appendChild(roleCell);

                // Cột Thao tác (Sửa, Xóa)
                const actionCell = document.createElement("td");

                const editBtn = document.createElement("button");
                editBtn.textContent = "Sửa";
                editBtn.className = "edit-btn";
                editBtn.onclick = () => {
                    document.getElementById("userid").value = user.id;
                    editingIndex = index + startIndex;
                    document.getElementById("nameFieldEdit").readOnly = true;
                    nameFieldEdit.value = user.username;
                    emailFieldEdit.value = user.email;
                    roleFieldEdit.value = user.role;
                    passwordField.value = '';
                    confirmPasswordField.value = '';
                    userFormEdit.style.display = "block";
                };

                const deleteBtn = document.createElement("button");
                deleteBtn.textContent = "Xóa";
                deleteBtn.className = "delete-btn";
                deleteBtn.onclick = () => {
                    document.getElementById("userid").value = user.id;
                    // Cập nhật URL trong form để truyền ID vào route
                    document.getElementById("deleteUserForm").action = `/chatbotai/admin/${user.id}`;
                    document.getElementById("usernameDelete").textContent = user.username;
                    userFormDelete.style.display = "block";
                };

                actionCell.appendChild(editBtn);
                actionCell.appendChild(document.createTextNode(" "));
                actionCell.appendChild(deleteBtn);
                row.appendChild(actionCell);
                tableBody.appendChild(row);
            });

            // Cập nhật trạng thái các nút phân trang
            updatePagination();
        }

        // Gắn sự kiện cho thanh tìm kiếm
        searchInput.addEventListener("keyup", filterUsers);

        // Gắn sự kiện cho nút Thêm Người dùng
        addBtn.onclick = () => {
            editingIndex = null;
            document.getElementById("nameField").readOnly = false;
            formTitle.innerText = "Thêm Người Dùng Mới";
            nameField.value = "";
            emailField.value = "";
            roleField.value = "Người dùng";
            userFormDiv.style.display = "block";
        };

        // Sự kiện nút Hủy trong form
        cancelBtn.onclick = () => {
            userFormDiv.style.display = "none";
            editingIndex = null;
        };

        // Sự kiện nút Hủy trong form
        cancelBtnEdit.onclick = () => {
            userFormEdit.style.display = "none";
            editingIndex = null;
        };

        cancelDeleteBtn.onclick = () => {
            userFormDelete.style.display = "none";
            editingIndex = null;
        }

        // Khi tải trang lần đầu, hiển thị bảng với dữ liệu ban đầu
        renderTable();

        // Sự kiện nút Lưu (thêm)
        saveBtn.onclick = () => {
            const name = nameField.value.trim();
            const email = emailField.value.trim();
            const role = roleField.value;
            const password = document.getElementById("passwordField").value.trim();
            const confirmPassword = document.getElementById("confirmPasswordField").value.trim();

            // Kiểm tra mật khẩu và xác nhận mật khẩu
            if (!name || !email || !password || !confirmPassword) {
                alert("Vui lòng nhập đầy đủ Tên, Email, Mật khẩu và Xác nhận mật khẩu.");
                return;
            }

            if (password !== confirmPassword) {
                alert("Mật khẩu và Xác nhận mật khẩu không khớp!");
                return;
            }

            // Kiểm tra độ dài mật khẩu (ví dụ, ít nhất 6 ký tự)
            if (password.length < 6) {
                alert("Mật khẩu phải có ít nhất 6 ký tự.");
                return;
            }

            if (editingIndex === null) {
                // Thêm user mới
                users.push({
                    name,
                    email,
                    role,
                    password // Lưu mật khẩu vào dữ liệu
                });
            } else {
                // Cập nhật user hiện tại
                users[editingIndex].name = name;
                users[editingIndex].email = email;
                users[editingIndex].role = role;
                users[editingIndex].password = password; // Cập nhật mật khẩu
            }

            // Cập nhật lại giao diện và reset form
            userFormDiv.style.display = "none";
            renderTable();
            filterUsers(); // Giữ nguyên bộ lọc tìm kiếm hiện tại (nếu có)
        };

        // Sự kiện nút Lưu (cập nhật user)
        saveBtnEdit.onclick = () => {
            const name = nameFieldEdit.value.trim();
            const email = emailFieldEdit.value.trim();
            const role = roleFieldEdit.value;
            const password = document.getElementById("passwordFieldEdit").value.trim();
            const confirmPassword = document.getElementById("confirmPasswordFieldEdit").value.trim();

            // Kiểm tra mật khẩu và xác nhận mật khẩu
            if (!name || !email || !password || !confirmPassword) {
                alert("Vui lòng nhập đầy đủ Tên, Email, Mật khẩu và Xác nhận mật khẩu.");
                return;
            }

            if (password !== confirmPassword) {
                alert("Mật khẩu và Xác nhận mật khẩu không khớp!");
                return;
            }

            // Kiểm tra độ dài mật khẩu (ví dụ, ít nhất 6 ký tự)
            if (password.length < 6) {
                alert("Mật khẩu phải có ít nhất 6 ký tự.");
                return;
            }

            if (editingIndex === null) {
                // Thêm user mới
                users.push({
                    name,
                    email,
                    role,
                    password // Lưu mật khẩu vào dữ liệu
                });
            } else {
                // Cập nhật user hiện tại
                users[editingIndex].name = name;
                users[editingIndex].email = email;
                users[editingIndex].role = role;
                users[editingIndex].password = password; // Cập nhật mật khẩu
            }

            // Cập nhật lại giao diện và reset form
            userFormDiv.style.display = "none";
            renderTable();
            filterUsers(); // Giữ nguyên bộ lọc tìm kiếm hiện tại (nếu có)
        };

        // Hàm cập nhật các nút phân trang
        function updatePagination() {
            const prevButton = document.getElementById("prevPage");
            const nextButton = document.getElementById("nextPage");

            const totalPages = Math.ceil(users.length / usersPerPage);

            // Kiểm tra nếu đang ở trang đầu tiên thì disable nút quay lại
            prevButton.disabled = currentPage === 1;
            // Kiểm tra nếu đang ở trang cuối thì disable nút tiếp theo
            nextButton.disabled = currentPage === totalPages;

            // Lưu trang hiện tại vào localStorage
            localStorage.setItem('currentPage', currentPage);
        }

        // Hàm thay đổi trang
        function changePage(direction) {
            const totalPages = Math.ceil(users.length / usersPerPage);

            if (direction === "next" && currentPage < totalPages) {
                currentPage++;
            } else if (direction === "prev" && currentPage > 1) {
                currentPage--;
            }

            renderTable(); // Gọi hàm render lại bảng sau khi thay đổi trang
            updatePagination(); // Cập nhật các nút phân trang sau khi thay đổi trang
        }

        // Gọi hàm renderTable() để hiển thị bảng ban đầu khi tải trang
        renderTable();

        // Hàm lọc bảng theo từ khóa tìm kiếm
        function filterUsers() {
            const filter = searchInput.value.toLowerCase();
            const rows = tableBody.getElementsByTagName("tr");
            for (let row of rows) {
                const nameText = row.cells[0].innerText.toLowerCase();
                const emailText = row.cells[1].innerText.toLowerCase();
                if (nameText.includes(filter) || emailText.includes(filter)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        }

        @if (session('success'))
            setTimeout(function() {
                var successMessage = document.getElementById('successMessage');
                if (successMessage) {
                    successMessage.style.display = 'none'; // Ẩn thông báo
                }
            }, 2000); // 5 giây (5000ms)
        @endif

        // Lưu vị trí cuộn vào sessionStorage
        window.addEventListener('beforeunload', function() {
            sessionStorage.setItem('scrollPosition', window.scrollY);
        });

        // Tải lại trang
        function reloadPage() {
            location.reload();
        }

        // Quay lại vị trí cuộn cũ sau khi tải lại trang
        window.addEventListener('load', function() {
            var savedScrollPosition = sessionStorage.getItem('scrollPosition');
            if (savedScrollPosition !== null) {
                window.scrollTo(0, savedScrollPosition); // Di chuyển đến vị trí đã lưu
            }
        });

        // Lắng nghe sự kiện click của nút
        document.getElementById('startTaskBtn').addEventListener('click', function() {
            let taskId = 'task'; // Bạn có thể thay đổi giá trị này theo yêu cầu

            // Gửi yêu cầu POST đến FastAPI (không cần xử lý dữ liệu trả về)
            fetch(`http://localhost:8000/start_task/${taskId}`, {
                    method: 'POST', // Phương thức POST
                    headers: {
                        'Content-Type': 'application/json', // Đảm bảo gửi đúng kiểu dữ liệu
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content') // CSRF Token nếu cần
                    }
                })
                .then(response => {
                    // Bạn không cần phải làm gì với dữ liệu trả về
                    if (response.ok) {
                        console.log(`Task ${taskId} started successfully!`);
                        // Có thể hiển thị thông báo cho người dùng nếu muốn
                    } else {
                        console.log("Error starting task.");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            
            // Hiển thị thông báo cho người dùng
            alert("Dữ liệu đang được cập nhật!!");

            // Dùng setTimeout để trì hoãn việc tải lại trang sau 3 giây (3000 ms)
            setTimeout(function() {
                location.reload();  // Tải lại trang
            }, 1500);  // 3000 ms = 3 giây

        });
    </script>
</body>

</html>
