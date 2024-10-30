<?php
require_once '../condb.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_login'])) {
    $user_id = $_SESSION['user_login'];
    $sql = "SELECT persons.*, tb_users.* FROM persons
            LEFT JOIN tb_users ON persons.id = tb_users.person_id
            WHERE persons.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $user_id);
    $stmt->execute();
    $us = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($us);
    
    // Set image URL
    $imageURL = !empty($avatar) ? '../assets/dist/avatar/' . $avatar : '../assets/dist/avatar/1.png';
}
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <div style="display: flex; flex-direction: column; align-items: center;">
            <img src="<?php echo $imageURL; ?>" style="width: 50%; max-width: 150px; height: auto;" class="img-circle">
            <span class="brand-text font-weight-light"><?php echo htmlspecialchars($us['fname'] . ' ' . $us['lname']); ?></span>
        </div>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="index.php" class="nav-link">
                        <i class="nav-icon fas fa-home" style="color: gold;"></i>
                        <p>หน้าหลัก</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="change_password.php" class="nav-link">
                        <i class="nav-icon fas fa-lock" style="color: gold;"></i>
                        <p>เปลี่ยนรหัสผ่าน</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="update_profile.php" class="nav-link">
                        <i class="nav-icon fas fa-user-edit" style="color: gold;"></i>
                        <p>แก้ไขข้อมูลส่วนตัว</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="show_movies.php" class="nav-link">
                        <i class="nav-icon fas fa-ticket-alt" style="color: gold;"></i>
                        <p>แสดงข้อมูลภาพยนตร์</p>
                    </a>
                </li>
            
                <li class="nav-item">
                    <a href="reserve_ticket.php" class="nav-link">
                        <i class="nav-icon fas fa-calendar-check" style="color: gold;"></i>
                        <p>การจองตั๋วหนัง
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="view_reservations.php" class="nav-link">
                        <i class="nav-icon fas fa-calendar-check" style="color: gold;"></i>
                        <p>ดูการจองของฉัน</p>
                    </a>
                </li>
                            
                <li class="nav-item">
                    <a href="../logout.php" class="nav-link">
                        <i class="nav-icon fas fa-door-open" style="color: gold;"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
