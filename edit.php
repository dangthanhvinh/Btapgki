<?php
include 'indexx.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Sử dụng câu lệnh chuẩn bị để tránh lỗi SQL injection và các lỗi cú pháp
    $stmt = $conn->prepare("SELECT * FROM table_Students WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "<script>alert('Không tìm thấy sinh viên với ID này.'); window.location.href='delete.php';</script>";
        exit();
    }
    $stmt->close();
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $hometown = $_POST['hometown'];
    $level = $_POST['level'];
    $group_id = $_POST['group_id'];

    // Sử dụng câu lệnh chuẩn bị để tránh lỗi SQL injection và các lỗi cú pháp
    $stmt = $conn->prepare("UPDATE table_Students SET fullname=?, dob=?, gender=?, hometown=?, level=?, group_id=? WHERE id=?");
    $stmt->bind_param("ssisiii", $fullname, $dob, $gender, $hometown, $level, $group_id, $id);

    if ($stmt->execute()) {
        // Hiển thị thông báo thành công và điều hướng trở lại trang danh sách sinh viên
        echo "<script>
                alert('Cập nhật sinh viên thành công');
                window.location.href='delete.php';
              </script>";
    } else {
        // Hiển thị thông báo lỗi
        echo "<script>
                alert('Lỗi khi cập nhật: " . addslashes($stmt->error) . "');
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin sinh viên</title>
    <link rel="stylesheet" type="text/css" href="sua.css">
    <script>
        // Tùy chọn: Bạn có thể thêm xác thực phía khách hàng tại đây nếu cần
    </script>
</head>
<body>
    <div class="form-container">
        <h1>Sửa thông tin sinh viên</h1>
        <div class="box">
            <form method="post" action="edit.php">
                <input type="hidden" name="id" value="<?php echo isset($student['id']) ? htmlspecialchars($student['id']) : ''; ?>">
                <div class="form-group">
                    <label>Họ và tên:</label>
                    <input type="text" name="fullname" value="<?php echo isset($student['fullname']) ? htmlspecialchars($student['fullname']) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label>Ngày sinh:</label>
                    <input type="date" name="dob" value="<?php echo isset($student['dob']) ? htmlspecialchars($student['dob']) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label>Giới tính:</label>
                    <div class="radio-group">
                        <label><input type="radio" name="gender" value="0" <?php echo isset($student['gender']) && $student['gender'] == 0 ? 'checked' : ''; ?> required> Nữ</label>
                        <label><input type="radio" name="gender" value="1" <?php echo isset($student['gender']) && $student['gender'] == 1 ? 'checked' : ''; ?>> Nam</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Quê quán:</label>
                    <input type="text" name="hometown" value="<?php echo isset($student['hometown']) ? htmlspecialchars($student['hometown']) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label>Trình độ học vấn:</label>
                    <select name="level" required>
                        <option value="0" <?php echo isset($student['level']) && $student['level'] == 0 ? 'selected' : ''; ?>>Tiến sĩ</option>
                        <option value="1" <?php echo isset($student['level']) && $student['level'] == 1 ? 'selected' : ''; ?>>Thạc sĩ</option>
                        <option value="2" <?php echo isset($student['level']) && $student['level'] == 2 ? 'selected' : ''; ?>>Kỹ sư</option>
                        <option value="3" <?php echo isset($student['level']) && $student['level'] == 3 ? 'selected' : ''; ?>>Khác</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Nhóm:</label>
                    <input type="number" name="group_id" value="<?php echo isset($student['group_id']) ? htmlspecialchars($student['group_id']) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="update">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
