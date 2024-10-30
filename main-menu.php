<head>
    <title>First Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .image-container {
            position: relative;
            display: inline-block;
            /* ให้รูปภาพและปุ่มอยู่ในกลุ่มเดียวกัน */
        }

        .custom-img {
            width: 100%;
            /* ให้รูปภาพเต็มความกว้างของคอนเทนเนอร์ */
            height: auto;
            /* รักษาสัดส่วนของรูปภาพ */
            object-fit: cover;
            /* ให้รูปภาพครอบคลุมพื้นที่อย่างพอดี */
            border-radius: 15px;
            /* มุมโค้งของรูปภาพ */
        }

        .text-overlay {
            position: absolute;
            top: 20%;
            /* ตำแหน่งข้อความให้อยู่ที่ 20% จากขอบบนของรูปภาพ */
            left: 50%;
            transform: translateX(-50%);
            color: white;
            /* สีของข้อความ */
            font-size: 42px;
            /* ขนาดตัวอักษร */
            background-color: rgba(0, 0, 0, 0.5);
            /* พื้นหลังโปร่งแสงของข้อความ */
            padding: 10px;
            border-radius: 10px;
            /* มุมโค้งของพื้นหลังข้อความ */
            font-family: "Copperplate", fantasy;
            /* กำหนดฟอนต์เป็น Copperplate หรือฟอนต์ fantasy */
        }

        .btn-next {
            position: absolute;
            /* จัดตำแหน่งแบบ absolute ให้ปุ่มอยู่บนรูปภาพ */
            top: 90%;
            /* ตำแหน่งปุ่มให้อยู่กึ่งกลางแนวตั้งของรูปภาพ */
            left: 50%;
            /* ตำแหน่งปุ่มให้อยู่กึ่งกลางแนวนอนของรูปภาพ */
            transform: translate(-50%, -50%);
            /* ปรับให้ปุ่มอยู่ตรงกลางจริง ๆ */
            padding: 10px 20px;
            /* ขนาดของปุ่ม */
            font-size: 16px;
            /* ขนาดตัวอักษรของปุ่ม */
            border-radius: 10px;
            /* มุมโค้งมนของปุ่ม */
        }
    </style>
</head>
<!-- Content -->
<div class="container mt-3 text-center position-relative m-border" style="border: 2px solid #ddd; padding: 20px;">
    <h2>Welcome to movie theaters</h2>
    <div class="d-grid gap-2">
        <!-- <a href="ex01_insertUser.php" class="btn btn-success">Insert DB with fix data</a>
        <a href="" class="btn btn-primary">Import Connect_DB & Insert Data with SQL</a>
        <a href="ex02_form_insertUser.php" class="btn btn-success">Insert Data with Form by exec</a>
        <a href="ex03_form_insertUser.php" class=" btn btn-warning">Insert Data with SQL by Prepared Statement=> :</a>
        <a href="ex04_form_insertUser.php" class="btn btn-warning">Insert Data with SQL by Prepared Statement=> ?</a>
        <a href="" class="btn btn-primary">Insert Data with Form by PDO</a> -->
        <!-- รูปที่มีข้อความและปุ่ม NEXT อยู่ข้างบน -->
        <div class="image-container">
            <img src="images/1678205109431.png" alt="Welcome Image" class="img-fluid custom-img">

            <!-- ข้อความที่แสดงบนรูปภาพ -->
            <div class="text-overlay">"Feel every beat, live every scene."</div>

    </div>
    <!-- End Content -->