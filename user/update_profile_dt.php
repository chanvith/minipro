<?php
require_once '../condb.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_login'])) {
    $id = $_SESSION['user_login'];

    $sql = "SELECT persons.*, tb_users.* FROM persons
            LEFT JOIN tb_users ON persons.id = tb_users.person_id 
            WHERE tb_users.id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    extract($user);
    $imageURL = '../assets/dist/avatar/' . $avatar;

    // ตรวจสอบว่ามี avatar หรือไม่ ถ้าไม่มีให้ใช้รูปภาพเริ่มต้น
    $imageURL = !empty($avatar) ? $imageURL : '../assets/dist/avatar/1.png';
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>แก้ไขข้อมูลสมาชิก</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-info">
                    <div class="card-body">
                        <form action="update_profile_dt_script.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $id;  ?>">

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" name="email" id="email" value="<?php echo $email;  ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="firstname" class="form-label">First name</label>
                                <input type="text" class="form-control" name="fname" id="firstname" value="<?php echo $fname;  ?>">
                            </div>

                            <div class="mb-3">
                                <label for="lastname" class="form-label">Last name</label>
                                <input type="text" class="form-control" name="lname" id="lastname" value="<?php echo $lname;  ?>">
                            </div>

                            <div class="mb-3">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" name="dob" id="dob" value="<?php echo $dob;  ?>">
                            </div>

                            <div class="mb-3">
                                <label for="avatar" class="form-label">Photo</label><br>
                                <img src="<?php echo $imageURL ?>" height="100" width="100" class="mb-2">
                                <input type="file" class="form-control" name="avatar" id="avatar">
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
