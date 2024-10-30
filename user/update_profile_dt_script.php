<?php
include('../condb.php');
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $dob = $_POST['dob'];

    // ดึงข้อมูลผู้ใช้จากฐานข้อมูลเพื่อตรวจสอบรูปภาพเดิม
    $sql = "SELECT avatar FROM persons WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $person = $stmt->fetch(PDO::FETCH_ASSOC);
    $oldAvatar = $person['avatar'];

    // ตรวจสอบว่ามีการอัปโหลดรูปภาพใหม่หรือไม่
    if (!empty($_FILES['avatar']['name'])) {
        $targetDir = realpath(__DIR__ . "/../assets/dist/avatar/") . "/";
        $fileName = basename($_FILES['avatar']['name']);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = uniqid() . '_' . time() . '.' . $fileType;
        $targetFilePath = $targetDir . $newFileName;

        // ตรวจสอบประเภทไฟล์
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            if ($_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFilePath)) {
                    if (!empty($oldAvatar) && file_exists($targetDir . $oldAvatar)) {
                        unlink($targetDir . $oldAvatar); // ลบไฟล์เดิม (รูปภาพเก่า)ออก
                    }
                    $avatar = $newFileName; // เก็บชื่อไฟล์รูปภาพใหม่
                } else {
                    echo '<script>
                            setTimeout(function() {
                            Swal.fire({
                            position: "center",
                            icon: "error",
                            title: "เกิดข้อผิดพลาดในการย้ายไฟล์ไปยังโฟลเดอร์เป้าหมาย",
                            showConfirmButton: false,
                            timer: 1500
                            }).then(function() {
                            window.location = "update_profile.php"; //หน้าที่ต้องการให้กระโดดไป
                            });
                            }, 1000);
                            </script>';
                    exit();
                }
            } else {
                echo '<script>
                        setTimeout(function() {
                        Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "เกิดข้อผิดพลาดในการอัปโหลดไฟล์",
                        showConfirmButton: false,
                        timer: 1500
                        }).then(function() {
                        window.location = "update_profile.php"; //หน้าที่ต้องการให้กระโดดไป
                        });
                        }, 1000);
                        </script>';
                exit();
            }
        } else {
            echo '<script>
            setTimeout(function() {
            Swal.fire({
            position: "center",
            icon: "error",
            title: "ประเภทไฟล์ไม่รองรับ",
            showConfirmButton: false,
            timer: 1500
            }).then(function() {
            window.location = "update_profile.php"; //หน้าที่ต้องการให้กระโดดไป
            });
            }, 1000);
            </script>';
            exit();
        }
    } else {
        $avatar = $oldAvatar; // ใช้รูปภาพเดิมถ้าไม่มีการอัปโหลดใหม่
    }

    try {
        // คำสั่ง SQL สำหรับบันทึก fname, lname, dob, avatar ลงตาราง persons
        $sql1 ="UPDATE persons SET fname = ?, lname = ?, dob = ?, avatar = ? WHERE id = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bindParam(1, $fname);
        $stmt1->bindParam(2, $lname);
        $stmt1->bindParam(3, $dob);
        $stmt1->bindParam(4, $avatar);
        $stmt1->bindParam(5, $id);
        $stmt1->execute();

        // ถ้าอัปเดตสำเร็จ
        echo '<script>
        setTimeout(function() {
        Swal.fire({
        position: "center",
        icon: "success",
        title: "อัปเดตข้อมูลสำเร็จ!",
        showConfirmButton: false,
        timer: 1500
        }).then(function() {
        window.location = "update_profile.php"; //หน้าที่ต้องการให้กระโดดไป
        });
        }, 1000);
        </script>';
        exit();
    } catch (Exception $e) {
        echo "เกิดข้อผิดพลาด: " . $e->getMessage();
    }
}
?>
