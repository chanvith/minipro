<?php
require_once '../condb.php';
 
if (session_status() === PHP_SESSION_NONE) {
    // ถ้ายังไม่มี session ที่ถูกเปิด
    session_start();
}
 
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $user_id          = $_SESSION['user_login']; // รหัสผู ้ใช้ที่เข้าสู ่ระบบ
    $current_password = $_POST['current_password'];
    $new_password     = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
 
    // ตรวจสอบว่ารหัสผ่านใหม่และการยืนยันรหัสผ่านตรงกันหรือไม่
    if ($new_password !== $confirm_password) {
        echo '<script>
            setTimeout(function() {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "รหัสผ่านใหม่ไม่ตรงกับการยืนยัน",
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location = "change_password.php";  
                });
            }, 1000);
        </script>';
        exit();
    }
 
    // ดึงข้อมูลรหัสผ่านเก่าของผู ้ใช้จากฐานข้อมูล
    $sql  = "SELECT password FROM tb_users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // ตรวจสอบว่ารหัสผ่านเก่าที่ผู ้ใช้กรอกตรงกับที่อยู ่ในฐานข้อมูลหรือไม่
    if (!password_verify($current_password, $user['password'])) {
        echo '<script>
            setTimeout(function() {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "รหัสผ่านเก่าไม่ถูกต้อง",
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location = "change_password.php";  
                });
            }, 1000);
        </script>';
        exit();
    }
    // หากผ่านการตรวจสอบทั ้งหมด ให้อัปเดตรหัสผ่านใหม่
    $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
    $sql  = "UPDATE tb_users SET password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $new_password_hashed);
    $stmt->bindParam(2, $user_id);
    $stmt->execute();
    // แจ้งผลลัพธ์สําเร็จ
    echo '<script>
        setTimeout(function() {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "เปลี่ยนรหัสผ่านสําเร็จ",
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location = "index.php";  
            });
        }, 1000);
    </script>';
    exit();
}
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>เปลี่ยนรหัสผ่าน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Text Editors</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-info">

                    <!-- /.card-header -->
                    <div class="card-body">


                        <div class="">

                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="change_password_dt.php" method="post" onsubmit="return validatePassword();">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="current_password">รหัสผ่านเก่า</label>
                                        <input type="password" class="form-control"
                                            name="current_password" id="current_password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password">รหัสผ่านใหม่</label>
                                        <input type="password" class="form-control" name="new_password"
                                            id="new_password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirm_password">ยืนยันรหัสผ่านใหม่</label>
                                        <input type="password" class="form-control"
                                            name="confirm_password" id="confirm_password" required>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                                    </div>
                                </div>
                            </form>
                    </div>

                </div>

            </div>
        </div>
        <!-- /.col-->
</div>
<!-- ./row -->

<!-- ./row -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<script>
    function validatePassword() {
        const password = document.getElementById('new_password').value;
        const confirmPassword =  
document.getElementById('confirm_password').value;
 
        // กําหนดเงื่อนไขที่ต้องการ เช่น ต้องมีตัวเลข ตัวอักษรพิมพ์ใหญ่ พิมพ์เล็ก สัญลักษณ์ และความยาว
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
 
 
        if (!password.match(passwordRegex)) {
            alert("รหัสผ่านต้องประกอบด้วยอย่างน้อย 8 ตัวอักษร, มีตัวอักษรพิมพ์ใหญ่, พิมพ์เล็ก, ตัวเลข และสัญลักษณ์พิเศษ");
            return false;
        }
 
        if (password !== confirmPassword) {
            alert("รหัสผ่านใหม่ไม่ตรงกับการยืนยัน");
            return false;
        }
        return true;
    }
</script>