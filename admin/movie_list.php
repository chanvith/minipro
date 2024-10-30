<?php
session_start();
include '../condb.php'; // Connect to your database

// Fetch movie list with cinema names
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
            cinemas c ON m.cinema_id = c.id"; // Join with cinemas table

$stmt = $conn->prepare($sql);
$stmt->execute();
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Include header and navigation
include 'header.php';
include 'navbar.php';
include 'sidebar.php';
?>

<!-- Add DataTable CSS link -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>ตารางแสดงผลภาพยนตร์</h1>
            <a href="add_movies.php" class="btn btn-success">เพิ่มภาพยนตร์</a>
        </div>
    </section>
    <section class="content">
        <div class="card card-outline card-info">
            <div class="card-body">
                <!-- Display success or error messages -->
                <?php if (isset($_SESSION['success'])): ?>
                    <div class='alert alert-success'><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
                <?php elseif (isset($_SESSION['error'])): ?>
                    <div class='alert alert-danger'><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>

                <!-- Display movie table with DataTable -->
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
                            <th>การจัดการ</th>
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
                                        <span></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit_movie.php?movie_id=<?php echo $movie['id']; ?>" class="btn btn-warning btn-sm">แก้ไข</a>
                                    <form action="delete_movie.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="movie_id" value="<?php echo $movie['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบภาพยนตร์นี้?');">ลบ</button>
                                    </form>
                                </td>
                            </tr>
                            <?php $index++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
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

<?php
include 'footer.php';
?>
