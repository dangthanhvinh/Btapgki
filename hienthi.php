<?php
include 'indexx.php';

$sql = "SELECT * FROM table_students";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Sinh Viên</title>
    <link rel="stylesheet" type="text/css"href="screen.css">
</head>
<body>
    <h1>Danh sách sinh viên</h1>
    <div class="search-container">
        <form method="get" action="hienthi.php">
            <input type="text" name="search" placeholder="Tìm kiếm sinh viên...">
            <button type="submit">Tìm kiếm</button>
        </form>
    </div>
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
            $search = isset($_GET['search']) ? $_GET['search'] : '';

            if ($search) {
                $sql = "SELECT * FROM table_Students WHERE fullname LIKE '%$search%'";
            } else {
                $sql = "SELECT * FROM table_Students";
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['fullname']}</td>
                            <td>{$row['dob']}</td>
                            <td>" . ($row['gender'] == 0 ? "Nữ" : "Nam") . "</td>
                            <td>{$row['hometown']}</td>
                            <td>" . ["Tiến sĩ", "Thạc sĩ", "Kỹ sư", "Khác"][$row['level']] . "</td>
                            <td>Nhóm {$row['group_id']}</td>
                            <td><a href='suatt.php?id={$row['id']}' class = 'edit-btn'>Sửa</a></td>
                            <td><a href='xoa.php?id={$row['id']}' class = 'delete-btn'>Xóa</a></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='9'>Không có sinh viên nào</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="add.php" class = "siu">Thêm sinh viên</a>
</body>
</html>
