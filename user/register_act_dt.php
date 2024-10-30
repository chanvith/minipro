<?php
require_once '../condb.php';
// เริ่ม session เพื่อดึงข้อมูลการล็อกอิน
if (session_status() === PHP_SESSION_NONE) { //seccion มีไว้เก็บข้อมูลชั่วคราว
    session_start();
}
if (isset($_SESSION['user_login'])) { // ถา้มีการลอ็กอินอยู่
    // ดึง user_id ของผู้ใช้ที่ล็อกอิน
    $user_id = $_SESSION['user_login'];
    // ดึงขอ้ มูลกิจกรรมจากตาราง activities
    $sql_activities = "SELECT id, title FROM activities";
    $stmt_activities = $conn->prepare($sql_activities);
    $stmt_activities->execute();
    $activities = $stmt_activities->fetchAll(PDO::FETCH_ASSOC);
    // ตรวจสอบเมื่อผใู้ชส้่งฟอร์ม
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // รับค่าจากฟอร์ม
        $activity_id = $_POST['activity_id'];
        // SQL ส าหรับการบันทึกข้อมูลลงในตาราง registers
        $sql_register = "INSERT INTO registers (activity_id, person_id) VALUES
                (?, ?)";
        $stmt_register = $conn->prepare($sql_register);
        $stmt_register->execute([$activity_id, $user_id]);
        // แสดงข้อความยืนยันการลงทะเบียน
        echo "<div class='alert alert-success'>ลงทะเบียนสำเร็จ!</div>";
    }
    // ดึงข้อมูลการลงทะเบียนของผู้ใช้จากตาราง registers
    $sql_registered = "SELECT r.id, a.title, r.created_at
                FROM registers r
                JOIN activities a ON r.activity_id = a.id
                WHERE r.person_id = ?";
    $stmt_registered = $conn->prepare($sql_registered);
    $stmt_registered->execute([$user_id]);
    $registrations = $stmt_registered->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ลงทะเบียนกิจกรรม</h1>
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
                    <!-- form start -->
                    <!-- ฟอร์มสา หรับลงทะเบียนกิจกรรม -->
                    <form action="" method="POST">
                        <div class="card-body">
                            <label for="activity_id" class="form-label">เลือกกิจกรรม
                            </label>
                            <select name="activity_id" id="activity_id"
                                class="form-control" required>
                                <option value="">-- กรุณาเลือกกิจกรรม --</option>
                                <?php foreach ($activities as $activity): ?>
                                    <option value="<?php echo $activity['id'];
                                                    ?>">
                                        <?php echo $activity['title']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">ลงทะเบียน
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- ตารางแสดงขอ้มูลการลงทะเบียนกิจกรรม -->
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">กิจกรรมที่คุณไดล้งทะเบียนไว</h ้ 3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($registrations)): ?>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>ชื่อกิจกรรม</th>
                                        <th>วันที่ลงทะเบียน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (
                                        $registrations as $index =>
                                        $registration
                                    ): ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td><?php echo $registration['title'];
                                                ?></td>
                                            <td><?php echo $registration['created_at'];
                                                ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>ยังไม่มีการลงทะเบียนกิจกรรม</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->