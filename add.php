<?php
include 'indexx.php';

if (isset($_POST['save'])) {
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $hometown = $_POST['hometown'];
    $level = $_POST['level'];
    $group_id = $_POST['group_id'];

    $sql = "INSERT INTO table_Students (fullname, dob, gender, hometown, level, group_id) 
            VALUES ('$fullname', '$dob', '$gender', '$hometown', '$level', '$group_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Thêm sinh viên thành công";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sinh Viên Mới</title>
    <link rel="stylesheet" type="text/css"href="them.css">
</head>
<body>
    <div class="form-container">
        <h1>Thêm sinh viên mới</h1>
        <form method="post" action="add.php">
            <div class="form-group">
                <label>Họ và tên:</label>
                <input type="text" name="fullname" required>
            </div>
            <div class="form-group">
                <label>Ngày sinh:</label>
                <input type="date" name="dob" required>
            </div>
            <div class="form-group">
                <label>Giới tính:</label>
                <div class="radio-group">
                    <label><input type="radio" name="gender" value="0" required> Nữ</label>
                    <label><input type="radio" name="gender" value="1"> Nam</label>
                </div>
            </div>
            <div class="form-group">
                <label>Quê quán:</label>
                <input type="text" name="hometown" required>
            </div>
            <div class="form-group">
                <label>Trình độ học vấn:</label>
                <select name="level" required>
                    <option value="0">Tiến sĩ</option>
                    <option value="1">Thạc sĩ</option>
                    <option value="2">Kỹ sư</option>
                    <option value="3">Khác</option>
                </select>
            </div>
            <div class="form-group">
                <label>Nhóm:</label>
                <input type="number" name="group_id" required>
            </div>
            <div class="form-group">
                <button type="submit" name="save">Lưu</button>
            </div>
        </form>
    </div>
</body>
</html>