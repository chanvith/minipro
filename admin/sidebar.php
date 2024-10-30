<?php
require_once '../condb.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['admin_login'])) {
    $user_id = $_SESSION['admin_login'];
    $sql = "SELECT persons.*, tb_users.* FROM persons
    LEFT JOIN tb_users ON persons.id = tb_users.person_id
    WHERE persons.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $user_id);
    $stmt->execute();
    $us = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($us); // ดึงข้อมูลผู้ใช้โดยตรง
    $imageURL = '../assets/dist/avatar/' . $avatar;
}

// ตรวจสอบว่ามี avatar หรือไม่ ถ้าไม่มีให้ใช้รูปภาพเริ่มต้น
$imageURL = !empty($avatar) ? $imageURL : '../assets/dist/avatar/1.png';
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <div style="display: flex; flex-direction: column; align-items: center;">
            <img src="<?php echo $imageURL ?>" style="width: 50%; max-width: 150px; height: auto;" class="img-circle ">
            <span class="brand-text font-weight-light"><?php echo $us['fname'] . ' ' . $us['lname']; ?></span>
        </div>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- หน้าหลัก -->
                <li class="nav-item">
                    <a href="index.php" class="nav-link">
                        <i class="nav-icon fas fa-home" style="color:gold;"></i>
                        <p>หน้าหลัก</p>
                    </a>
                </li>
                <!-- จัดการโรงหนัง -->
                <li class="nav-item">
                    <a href="add_cinema.php" class="nav-link">
                        <i class="nav-icon fas fa-theater-masks" style="color:gold;"></i>
                        <p>เพิ่มข้อมูลโรงหนัง</p>
                    </a>
                </li>
                <!-- จัดการหนัง -->
                <li class="nav-item">
                    <a href="add_movies.php" class="nav-link">
                        <i class="nav-icon fas fa-film" style="color:gold;"></i>
                        <p>เพิ่มข้อมูลหนัง</p>
                    </a>
                </li>
                <!-- แก้ไขข้อมูลหนัง -->
                <li class="nav-item">
                    <a href="movie_list.php" class="nav-link">
                        <i class="nav-icon fas fa-clock" style="color:gold;"></i>
                        <p>แก้ไขข้อมูลหนัง</p>
                    </a>
                </li>
              
                <!-- ออกจากระบบ -->
                <li class="nav-item">
                    <a href="../logout.php" class="nav-link">
                        <i class="nav-icon fas fa-door-open" style="color:gold;"></i>
                        <p>ออกจากระบบ</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
