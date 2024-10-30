<?php
require_once '../condb.php';
// ตรวจสอบวาได้รับค ่ ่า u_id จาก POST หรือไม่
if (isset($_POST['u_id'])) {
$user_id = $_POST['u_id'];
// สร้าง SQL เพื่อดึงข้อมูลจากสองตาราง
$sql = "SELECT persons.*, tb_users.* FROM persons
LEFT JOIN tb_users ON persons.id = tb_users.person_id WHERE
tb_users.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
// ส่งข้อมูลกลับในรูปแบบ JSON
if ($user) { // ถ้าพบข้อมูล
echo json_encode($user); // ส่งข้อมูลกลับในรูปแบบ JSON
} else {
echo json_encode(['error' => 'User not found']);
}
}
?>