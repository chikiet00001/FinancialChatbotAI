<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Admin - Quản lý Người dùng</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* File: style.css */
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
  background-color: #4CAF50; /* xanh lá đậm */
  color: #fff;
  border: none;
  padding: 10px 16px;
  font-size: 14px;
  border-radius: 4px;
  cursor: pointer;
}
.toolbar #addUserBtn:hover {
  background-color: #45a049; /* xanh lá hơi sậm khi hover */
}

/* Bảng danh sách người dùng */
#userTable {
  width: 100%;
  border-collapse: collapse;
  font-size: 16px;
}
#userTable th, #userTable td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}
#userTable thead th {
  background-color: #f1f1f1; /* nền xám nhạt cho hàng tiêu đề */
}
#userTable tbody tr:hover {
  background-color: #f9f9f9; /* đổi nền khi hover hàng */
}

/* Nút trong bảng (Sửa/Xóa) */
.edit-btn, .delete-btn {
  border: none;
  color: #fff;
  padding: 6px 12px;
  font-size: 14px;
  border-radius: 4px;
  cursor: pointer;
}
.edit-btn { background-color: #2196F3; /* xanh dương */ }
.delete-btn { background-color: #f44336; /* đỏ */ }
.edit-btn:hover { background-color: #0b7dda; }
.delete-btn:hover { background-color: #d32f2f; }
.edit-btn { margin-right: 5px; }  /* khoảng cách giữa 2 nút */

/* Form thêm/sửa user */
#userForm {
  border: 1px solid #ccc;
  background-color: #fafafa;
  padding: 10px;
  margin-top: 20px;
}
#userForm h3 {
  margin-top: 0;
}
#userForm label {
  display: block;
  margin: 8px 0;
}
#userForm input, #userForm select {
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
#saveUserBtn, #cancelBtn {
  border: none;
  padding: 8px 16px;
  font-size: 14px;
  border-radius: 4px;
  cursor: pointer;
}
#saveUserBtn {
  background-color: #008CBA; /* xanh dương */
  color: #fff;
}
#saveUserBtn:hover {
  background-color: #007bb5;
}
#cancelBtn {
  background-color: #6c757d; /* xám đậm */
  color: #fff;
  margin-left: 5px;
}
#cancelBtn:hover {
  background-color: #5a6268;
}
  </style>
</head>
<body>
  <div class="container">
    <h1>Quản lý Người dùng</h1>
    <!-- Thanh tìm kiếm và nút Thêm -->
    <div class="toolbar">
      <input type="text" id="searchInput" placeholder="Tìm kiếm người dùng...">
      <button id="addUserBtn" class="add-btn">Thêm Người dùng</button>
    </div>

    <!-- Bảng danh sách User -->
    <table id="userTable">
      <thead>
        <tr>
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

    <!-- Form thêm/sửa User (ẩn lúc đầu) -->
    <div id="userForm" class="form-container" style="display:none;">
      <h3 id="formTitle">Thêm Người Dùng</h3>
      <label>Tên: 
        <input type="text" id="nameField" required>
      </label>
      <label>Email: 
        <input type="email" id="emailField" required>
      </label>
      <label>Vai trò:
        <select id="roleField">
          <option>Người dùng</option>
          <option>Quản trị viên</option>
        </select>
      </label>
      <div class="form-buttons">
        <button id="saveUserBtn">Lưu</button>
        <button id="cancelBtn">Hủy</button>
      </div>
    </div>
  </div>

  <script src="script.js">
    // 1. Dữ liệu giả lập ban đầu
let users = [
  { name: "Nguyễn Văn A", email: "nva@example.com", role: "Quản trị viên" },
  { name: "Trần Thị B", email: "ttb@example.com", role: "Người dùng" },
  { name: "Lê Duy C", email: "ldc@example.com", role: "Người dùng" },
  { name: "Alice Nguyễn", email: "alice@example.com", role: "Quản trị viên" }
];

// Biến trạng thái để biết đang sửa user nào (index trong mảng). Null nghĩa là chế độ thêm mới.
let editingIndex = null;

// 2. Truy xuất các phần tử HTML cần thao tác
const tableBody = document.getElementById("userTableBody");
const searchInput = document.getElementById("searchInput");
const userFormDiv = document.getElementById("userForm");
const formTitle = document.getElementById("formTitle");
const nameField = document.getElementById("nameField");
const emailField = document.getElementById("emailField");
const roleField = document.getElementById("roleField");
const saveBtn = document.getElementById("saveUserBtn");
const cancelBtn = document.getElementById("cancelBtn");
const addBtn = document.getElementById("addUserBtn");

// 3. Hàm hiển thị lại bảng user từ dữ liệu
function renderTable() {
  // Xóa toàn bộ nội dung cũ
  tableBody.innerHTML = "";
  // Tạo hàng mới cho từng user trong mảng
  users.forEach((user, index) => {
    const row = document.createElement("tr");
    // Ô tên
    const nameCell = document.createElement("td");
    nameCell.textContent = user.name;
    row.appendChild(nameCell);
    // Ô email
    const emailCell = document.createElement("td");
    emailCell.textContent = user.email;
    row.appendChild(emailCell);
    // Ô vai trò
    const roleCell = document.createElement("td");
    roleCell.textContent = user.role;
    row.appendChild(roleCell);
    // Ô thao tác (chứa nút Sửa, Xóa)
    const actionCell = document.createElement("td");
    // Nút Sửa
    const editBtn = document.createElement("button");
    editBtn.textContent = "Sửa";
    editBtn.className = "edit-btn";
    // Nút Xóa
    const deleteBtn = document.createElement("button");
    deleteBtn.textContent = "Xóa";
    deleteBtn.className = "delete-btn";
    // Thêm sự kiện cho nút Sửa
    editBtn.onclick = () => {
      // Mở form ở chế độ chỉnh sửa
      editingIndex = index;
      formTitle.innerText = "Chỉnh sửa Người Dùng";
      nameField.value = user.name;
      emailField.value = user.email;
      roleField.value = user.role;
      userFormDiv.style.display = "block";
    };
    // Thêm sự kiện cho nút Xóa
    deleteBtn.onclick = () => {
      if (confirm("Bạn có chắc muốn xóa người dùng này?")) {
        users.splice(index, 1);          // Xóa khỏi mảng dữ liệu
        renderTable();                   // Cập nhật lại bảng trên giao diện
        filterUsers();                   // Áp dụng lại bộ lọc tìm kiếm (nếu có)
      }
    };
    // Chèn các nút vào ô thao tác
    actionCell.appendChild(editBtn);
    actionCell.appendChild(document.createTextNode(" ")); // khoảng trắng giữa nút
    actionCell.appendChild(deleteBtn);
    row.appendChild(actionCell);
    // Thêm hàng vào tbody
    tableBody.appendChild(row);
  });
}

// 4. Hàm lọc bảng theo từ khóa tìm kiếm
function filterUsers() {
  const filter = searchInput.value.toLowerCase();
  const rows = tableBody.getElementsByTagName("tr");
  for (let row of rows) {
    // Lấy nội dung tên và email của hàng hiện tại
    const nameText = row.cells[0].innerText.toLowerCase();
    const emailText = row.cells[1].innerText.toLowerCase();
    // Kiểm tra từ khóa có nằm trong tên hoặc email hay không
    if (nameText.includes(filter) || emailText.includes(filter)) {
      row.style.display = "";    // hiển thị hàng
    } else {
      row.style.display = "none"; // ẩn hàng không khớp
    }
  }
}

// 5. Gắn sự kiện cho thanh tìm kiếm
searchInput.addEventListener("keyup", filterUsers);

// 6. Gắn sự kiện cho nút Thêm Người dùng
addBtn.onclick = () => {
  editingIndex = null;                        // chế độ thêm mới
  formTitle.innerText = "Thêm Người Dùng Mới";
  nameField.value = "";
  emailField.value = "";
  roleField.value = "Người dùng";             // đặt giá trị mặc định
  userFormDiv.style.display = "block";        // hiển thị form
};

// 7. Sự kiện nút Hủy trong form (đóng form không lưu)
cancelBtn.onclick = () => {
  userFormDiv.style.display = "none";
  editingIndex = null;
};

// 8. Sự kiện nút Lưu (thêm hoặc cập nhật user)
saveBtn.onclick = () => {
  // Lấy giá trị từ các trường input
  const name = nameField.value.trim();
  const email = emailField.value.trim();
  const role = roleField.value;
  if (!name || !email) {
    alert("Vui lòng nhập đầy đủ Tên và Email.");
    return;
  }
  if (editingIndex === null) {
    // Thêm user mới
    users.push({ name, email, role });
  } else {
    // Cập nhật user hiện tại
    users[editingIndex].name = name;
    users[editingIndex].email = email;
    users[editingIndex].role = role;
  }
  // Cập nhật lại giao diện và reset form
  userFormDiv.style.display = "none";
  renderTable();
  filterUsers();  // giữ nguyên bộ lọc tìm kiếm hiện tại (nếu có)
};
 
// 9. Khi tải trang lần đầu, hiển thị bảng với dữ liệu ban đầu
renderTable();
  </script>
</body>
</html>