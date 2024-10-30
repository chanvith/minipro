<?php


include('../condb.php');
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

?>


<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
</head>


<body>
    <div class="container">


        <?php
        $id = $_POST['id'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $dob = $_POST['dob'];
        // $avatar = $_POST['avatar'];

        // ดึงข้อมูลผู้ใช้จากฐานข้อมูลเพื่อตรวจสอบรูปภาพเดิม
            $sql = "SELECT avatar FROM persons WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $person = $stmt->fetch(PDO::FETCH_ASSOC);
            $oldAvatar = $person['avatar'];
            // ตรวจสอบวา่ ไดม้ีการอปัโหลดรูปภาพใหม่หรือไม่
            if (!empty($_FILES['avatar']['name'])) { // ถา้มีการอปัโหลดรูปภาพใหม่
            $targetDir = realpath(__DIR__ . "/../assets/dist/avatar/") . "/"; 
            $fileName = basename($_FILES['avatar']['name']); // เอาเฉพาะชื่อไฟลอ์อกมา (ไม่เอา path)
          
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); // เอาเฉพาะนามสกุลไฟล์
            $newFileName = uniqid() . '_' . time() . '.' . $fileType;
            $targetFilePath = $targetDir . $newFileName;
        
            // แสดงค่าจาก $_FILES เพื่อตรวจสอบการอัปโหลด
            // ตรวจสอบประเภทไฟล์(สามารถเพิ่มประเภทที่ตอ้งการได)้
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif'); // ประเภทไฟล์ที่อนุญาต
            if (in_array($fileType, $allowTypes)) { // ตรวจสอบวา่ อยใู่ นประเภทที่อนุญาตหรือไม่
            // ตรวจสอบวา่ มีขอ้ผดิพลาดในการอปัโหลดไฟลห์ รือไม่
            if ($_FILES['avatar']['error'] === UPLOAD_ERR_OK) { // ถา้ไม่มีขอ้ผดิพลาด
            // อัปโหลดไฟล์ไปยังโฟลเดอร์ที่ต้องการ
            if (move_uploaded_file($_FILES['avatar']['tmp_name'],
            $targetFilePath)) { // ถ้าอัปโหลดส าเร็จ
                            // ลบรูปภาพเก่า (ถา้มี) เพื่อประหยดัพ้ืนที่
                            if (!empty($oldAvatar) && file_exists($targetDir .
                                $oldAvatar)) { // ถา้มีรูปภาพเดิมและมีไฟลอ์ยจู่ ริง
                                unlink($targetDir . $oldAvatar); // ลบไฟลเ์ดิม (รูปภาพเก่า)ออก
                            }
                            // เกบ็ ชื่อไฟลร์ูปภาพใหม่
                            $avatar = $newFileName;

            } else {
                            echo '<script>
                    setTimeout(function() {
                    Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "เกิดข้อผิดพลาดในการย้ายไฟล์ไปยังไฟลเดอร์เป้าหมาย",
                    showConfirmButton: false,
                    timer: 1500
                    }).then(function() {
                    window.location = "update_profile.php";
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
                    window.location = "update_profile.php";
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
                    window.location = "update_profile.php";
                    });
                    }, 1000);
                    </script>';
            exit();
            }
            } else {
            // ถา้ไม่มีการอปัโหลดใหม่ใหใ้ชรู้ปภาพเดิม
            $avatar = $oldAvatar;
            }



        try {
            // เริ่มการท าธุรกรรม (Transaction) เพื่อให้แน่ใจว่าข้อมูลถูกบันทึกลงทั้งสองตาราง หรือไม่บันทึกเลย
            $conn->beginTransaction();


            // ค าสั่ง SQL ส าหรับบันทึก fname และ lname ลงตาราง persons
            $sql1 = "UPDATE persons SET fname = ?, lname = ?, dob = ?, avatar = ? WHERE id = ?";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->bindParam(1, $fname);
            $stmt1->bindParam(2, $lname);
            $stmt1->bindParam(3, $dob);
            $stmt1->bindParam(4, $avatar);
            $stmt1->bindParam(5, $id);
            $stmt1->execute();
            // รับค่า person_id ของแถวที่เพิ่งถูกเพิ่มใน persons


            // ค าสั่ง SQL ส าหรับบันทึก email, password และ role ลงตาราง tb_users
            $sql2 = "UPDATE tb_users SET email = ?, role=? WHERE id = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bindParam(1, $email);
            $stmt2->bindParam(2, $role);
            $stmt2->bindParam(3, $id);
            $stmt2->execute();
            // ถ้าทุกอย่างท างานเรียบร้อย ท าการ Commit เพื่อยืนยันการบันทึกข้อมูล
            $conn->commit();
            $result = "success"; // ก าหนดค่า result เป็น success เมื่อส าเร็จ
        } catch (Exception $e) {
            $conn->rollBack();
            $result = "error"; // ก าหนดค่า result เป็น error เมื่อเกิดข้อผิดพลาด
        }




        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> ';
        if ($result === "success") {
            echo '<script>
        setTimeout(function() {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "เเก้ไขข้อมูลสำเร็จ",
                showConfirmButton: false,
                timer: 1000
                }).then(function() {
                window.location = "show_member.php"; // Redirect to.. ปรับแก ้ชอไฟล์ตามที่ต้องการให ้ไป
                });
                }, 1000);
                </script>';
        } else {
            echo '<script>
            setTimeout(function() {
                Swal.fire({
                position: "center",
                icon: "error",
                title: "เกิดข้อผิดพลาด",
                showConfirmButton: false,
                timer: 1000
                }).then(function() {
                window.location = "update_member.php"; // Redirect to.. ปรับแก ้ชอไฟล์ตามที่ต้องการให ้ไป ื่
                });
                }, 1000);
                </script>';
        }
        ?>
    </div>
</body>


</html>