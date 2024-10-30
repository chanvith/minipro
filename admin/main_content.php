<?php
require_once '../condb.php';

// SQL สำหรับการนับจำนวนโรงภาพยนตร์
$sql_cinemas = "SELECT COUNT(*) AS total_cinemas FROM cinemas";
$stmt = $conn->prepare($sql_cinemas);
$stmt->execute();
$result_cinemas = $stmt->fetch(PDO::FETCH_ASSOC);
$total_cinemas = $result_cinemas['total_cinemas'];

// SQL สำหรับการนับจำนวนภาพยนตร์
$sql_movies = "SELECT COUNT(*) AS total_movies FROM movies";
$stmt = $conn->prepare($sql_movies);
$stmt->execute();
$result_movies = $stmt->fetch(PDO::FETCH_ASSOC);
$total_movies = $result_movies['total_movies'];

// SQL สำหรับการนับจำนวนการแสดงภาพยนตร์
$sql_showtimes = "SELECT COUNT(*) AS total_showtimes FROM showtimes";
$stmt = $conn->prepare($sql_showtimes);
$stmt->execute();
$result_showtimes = $stmt->fetch(PDO::FETCH_ASSOC);
$total_showtimes = $result_showtimes['total_showtimes'];

// SQL สำหรับการนับจำนวนการจอง
$sql_reservations = "SELECT COUNT(*) AS total_reservations FROM reservations";
$stmt = $conn->prepare($sql_reservations);
$stmt->execute();
$result_reservations = $stmt->fetch(PDO::FETCH_ASSOC);
$total_reservations = $result_reservations['total_reservations'];
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo $total_cinemas ?></h3>
                            <p>Cinemas</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-home"></i> <!-- Change icon to something cinema-related -->
                        </div>
                        <a href="add_cinema.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php echo $total_movies ?></h3>
                            <p>Movies</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-film-marker"></i> <!-- Change icon to something movie-related -->
                        </div>
                        <a href="add_movies.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
