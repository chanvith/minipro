<?php
require_once '../condb.php'; // เชื่อมต่อฐานข้อมูล

// สร้างคำสั่ง SQL เพื่อดึงข้อมูลภาพยนตร์พร้อมกับชื่อโรงภาพยนตร์
$sql = "SELECT
            m.id,
            m.movie_name,
            m.director,
            m.release_year,
            m.genre,
            COALESCE(c.cinema_name, 'ไม่มีข้อมูล') AS cinema_name,
            m.poster
        FROM
            movies m
        LEFT JOIN
            cinemas c ON m.cinema_id = c.id"; // เชื่อมโยงกับตาราง cinemas

$stmt = $conn->prepare($sql);
$stmt->execute();
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Debugging output (Commented out)
// echo '<pre>';
// print_r($movies);
// echo '</pre>';

if (empty($movies)) {
    echo '<div class="alert alert-danger" role="alert">ไม่พบข้อมูลภาพยนตร์ในระบบ</div>';
    exit; // ออกจากสคริปต์หากไม่มีข้อมูล
}
?>

<!-- เพิ่มลิงก์ CSS สำหรับ DataTable -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ตารางแสดงผลภาพยนตร์</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="card">
        <div class="card-body">
            <table id="movieTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อภาพยนตร์</th>
                        <th>ผู้กำกับ</th>
                        <th>ปีที่ออกฉาย</th>
                        <th>หมวดหมู่</th>
                        <th>ชื่อโรงภาพยนตร์</th>
                        <th>โปสเตอร์</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; ?>
                    <?php foreach ($movies as $movie) : ?>
                        <tr>
                            <td><?php echo $index; ?></td>
                            <td><?php echo htmlspecialchars($movie['movie_name']); ?></td>
                            <td><?php echo htmlspecialchars($movie['director']); ?></td>
                            <td><?php echo htmlspecialchars($movie['release_year']); ?></td>
                            <td><?php echo htmlspecialchars($movie['genre']); ?></td>
                            <td><?php echo htmlspecialchars($movie['cinema_name']); ?></td>
                            <td>
                                <?php if (!empty($movie['poster'])) : ?>
                                    <img src="../assets/dist/posters/<?php echo htmlspecialchars($movie['poster']); ?>" class="img-fluid" alt="โปสเตอร์" onerror="this.onerror=null; this.src='../assets/dist/posters/default.jpg';" style="max-width: 100px; max-height: 150px;">
                                <?php else : ?>
                                    <span>ไม่มีโปสเตอร์</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php $index++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Include jQuery and DataTables scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#movieTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>

<!-- Include Bootstrap CSS and JS for Modal -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
