<?php
session_start();
include '../condb.php'; // เชื่อมต่อฐานข้อมูล

// ค้นหาการจองทั้งหมด โดยแสดงชื่อภาพยนตร์
$sql = "SELECT r.id AS reservation_id, m.movie_name, r.seat_id 
        FROM reservations r 
        JOIN movies m ON r.movie_id = m.id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// รหัสการแสดงผล
include 'header.php';
include 'navbar.php';
include 'sidebar.php';
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>การจองทั้งหมด</h1>
        </div>
    </section>
    <section class="content">
        <div class="card card-outline card-info">
            <div class="card-body">
                <!-- แสดงข้อความถ้ามี -->
                <?php
                if (isset($_SESSION['success'])) {
                    echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
                    unset($_SESSION['success']);
                } elseif (isset($_SESSION['error'])) {
                    echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
                    unset($_SESSION['error']);
                }
                ?>

                <!-- แสดงการจอง -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>หมายเลขการจอง</th>
                            <th>ชื่อภาพยนตร์</th>
                            <th>Seat ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($reservations) > 0): ?>
                            <?php foreach ($reservations as $reservation): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($reservation['reservation_id']); ?></td>
                                    <td><?php echo htmlspecialchars($reservation['movie_name']); ?></td>
                                    <td><?php echo htmlspecialchars($reservation['seat_id']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">ไม่มีการจองในระบบ</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php
include 'footer.php';
?>
