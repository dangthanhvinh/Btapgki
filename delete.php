<?php
include 'indexx.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Sử dụng câu lệnh chuẩn bị để tránh lỗi SQL injection và các lỗi cú pháp
    $stmt = $conn->prepare("DELETE FROM table_Students WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Xóa sinh viên thành công');</script>";
    } else {
        echo "Lỗi: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
    
    // Điều hướng trở lại trang danh sách sinh viên
    echo "<script>window.location.href='delete.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa sinh viên</title>
    <link rel="stylesheet" type="text/css" href="xoa.css">
    <script>
        function confirmDelete(event, url) {
            event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
            if (confirm('Bạn có chắc chắn muốn xóa sinh viên này không?')) {
                window.location.href = url; // Chuyển hướng tới URL nếu xác nhận
            }
        }
    </script>
</head>
<body>
<h1>Danh sách sinh viên</h1>
    <table>
        <thead>
            <tr>
                <th>Thứ tự</th>
                <th>Họ và tên</th>
                <th>Ngày sinh</th>
                <th>Giới tính</th>
                <th>Quê quán</th>
                <th>Trình độ học vấn</th>
                <th>Nhóm</th>
                <th>Sửa</th>
                <th>Xóa</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'indexx.php';
            $sql = "SELECT * FROM table_Students";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['fullname']}</td>
                            <td>{$row['dob']}</td>
                            <td>" . ($row['gender'] == 0 ? 'Nữ' : 'Nam') . "</td>
                            <td>{$row['hometown']}</td>
                            <td>" . ['Tiến sĩ', 'Thạc sĩ', 'Kỹ sư', 'Khác'][$row['level']] . "</td>
                            <td>Nhóm {$row['group_id']}</td>
                            <td><a href='suatt.php?id={$row['id']}' class='edit-btn'>Sửa</a></td>
                            <td><a href='#' onclick=\"confirmDelete(event, 'delete.php?id={$row['id']}')\" class='delete-btn'>Xóa</a></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='9'>Không có sinh viên nào</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
    <a href="add.php">Thêm sinh viên</a>
</body>
</html>