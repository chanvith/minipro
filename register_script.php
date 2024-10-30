<?php

include('condb.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>insert user</title>
</head>

<body>
    <div class="container">


        <?php


        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        try {

            // ตรวจสอบวา่ อีเมลซ้า หรือไม่
            $sqlCheck = "SELECT COUNT(*) FROM tb_users WHERE email = ?";
            $stmtCheck = $conn->prepare($sqlCheck);
            $stmtCheck->bindParam(1, $email);
            $stmtCheck->execute();
            $emailExists = $stmtCheck->fetchColumn(); // ดึงค่า count จากการตรวจสอบอีเมล
            if ($emailExists > 0) {
                // ถ้าอีเมลซ้า
                $result = "email_exists";
            } else {


                // เริ่มการท าธุรกรรม (Transaction) เพื่อให้แน่ใจว่าข้อมูลถูกบันทึกลงทั้งสองตาราง หรือไม่บันทึกเลย
                $conn->beginTransaction();

                // ค าสั่ง SQL ส าหรับบันทึก fname และ lname ลงตาราง persons
                $sql1 = "INSERT INTO persons (fname, lname) VALUES (?, ?)";
                $stmt1 = $conn->prepare($sql1);
                $stmt1->bindParam(1, $fname);
                $stmt1->bindParam(2, $lname);
                $stmt1->execute();

                // รับค่า person_id ของแถวที่เพิ่งถูกเพิ่มใน persons
                $person_id = $conn->lastInsertId();

                // ค าสั่ง SQL ส าหรับบันทึก email, password และ role ลงตาราง tb_users
                $sql2 = "INSERT INTO tb_users (person_id, email, password) VALUES (?, ?, ?)";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->bindParam(1, $person_id);
                $stmt2->bindParam(2, $email);
                $stmt2->bindParam(3, $passwordHash);
                $stmt2->execute();

                // ถ้าทุกอย่างท างานเรียบร้อย ท าการ Commit เพื่อยืนยันการบันทึกข้อมูล
                $conn->commit();
                $result = "success"; // ก าหนดค่า result เป็น success เมื่อส าเร็จ
            }
        } catch (Exception $e) {
            $conn->rollBack();
            $result = "error"; // ก าหนดค่า result เป็น error เมื่อเกิดข้อผิดพลาด
        }



        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        if ($result === "success") {


            echo '<script>
setTimeout(function() {
Swal.fire({
position: "center",
icon: "success",
title: "เพิ่มข้อมูลสําเร็จ",
showConfirmButton: false,
 timer: 1500
}).then(function() {
window.location = "login.php"; // Redirect to.. ปรับแก้ชื่อไฟล์ตามที่ต้องการให้ไป
});
}, 1000);
</script>';
        } elseif ($result === "email_exists") {
            echo '<script>
setTimeout(function() {
Swal.fire({
position: "center",
icon: "error",
title: "อีเมลนี้ถูกใช้งานแลว้",
showConfirmButton: false,
timer: 1500
}).then(function() {
window.location = "register.php"; // Redirect to.. ปรับแก้ชื่อ
ไฟล์ตามที่ต้องการให้ไป
});
}, 10);
</script>';
        } else {
            echo '<script>
setTimeout(function() {
Swal.fire({
position: "center",
icon: "error",
title: "เกิดข้อผิดพลาด",
showConfirmButton: false,
 timer: 1500
}).then(function() {
window.location = "register.php"; // Redirect to.. ปรับแก้ชื่อไฟล์ตามที่ต้องการให้ไป
});
}, 1000);
</script>';
        }


        ?>
        <!-- <hr>
        <a href="index.php" class="btn btn-primary">กลับหน้าหลัก</a>
 -->

    </div>
</body>

</html>