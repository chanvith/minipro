<?php
require_once '../condb.php';
$sql = "SELECT persons.*, tb_users.* FROM persons
 LEFT JOIN tb_users ON persons.id = tb_users.person_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
$index = 1;
?>


<link rel="stylesheet"
    href="https://cdn.datatables.net/2.1.2/css/dataTables.dataTables.min.css">


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>จัดการข้อมูล Admin
                        <a href="" class="btn btn-primary">+ข้อมูล</a>
                    </h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            <table id="myTable" class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $us) : ?>

                        <tr>
                        <td><?php echo $index; ?></td>
                            <!-- <td><?php echo $us['id']; ?></td> -->
                            <td><?php echo $us['fname']; ?></td>
                            <td><?php echo $us['lname']; ?></td>
                            <td><?php echo $us['email']; ?></td>
                            <td><?php echo $us['password']; ?></td>
                            <td>

                                <?php
                                if ($us['role'] == 1) {
                                    echo "Admin";
                                } else {
                                    echo "User";
                                }

                                ?>
                            </td>

                            <td>

                                <button type="button" class="btn btn-success btn-sm view-member-button" data-user-id="<?php echo $us['id']; ?>">View</button>

                                <form action="update_member.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="user_id" value="<?php echo $us['id']; ?>">
                                    <input type="submit" name="edit" value="Edit" class="btn btn-warning btn-sm">
                                </form>

                                <form action="del_member.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="user_id" value="<?php echo $us['id']; ?>">
                                    <!-- <input type="submit" name="delete" value="Delete" class="btn btn-danger btn-sm"> -->
                                    <button type="button" class="delete-button btn btn-danger btn btn-sm " data-user-id="<?php echo $us['id']; ?>">Delete</button>
                                </form>
                            </td>

                        </tr>
                        <?php $index++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->
</div>
<!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
<script>
    let table = new DataTable('#myTable');
</script>
<script>
    // ฟังก์ชันส าหรับแสดงกล่องยืนยัน SweetAlert2
    function showDeleteConfirmation(userId) {
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: 'คุณจะไม่สามารถเรียกคืนข้อมูลกลับได้!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ลบ',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                // หากผู้ใช้ยืนยัน ให้ส่งค่าฟอร์มไปยัง delete.php เพื่อลบข้อมูล
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'del_member.php';
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'user_id';
                input.value = userId;
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    // แนบตวัตรวจจบัเหตุการณ์คลิกกบัองค์ปุ่่มลบทั่้งหมดที่มีคลาส delete-button
    const deleteButtons = document.querySelectorAll('.delete-button');
    deleteButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const userId = button.getAttribute('data-user-id');
            showDeleteConfirmation(userId);
        });
    });
</script>

<!-- Modal สําหรับแสดงข้อมูลสมาชิก -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js
            "></script>
<div class="modal fade" id="memberModal" tabindex="-1" arialabelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="memberModalLabel">รายละเอียดสมาชิก</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- แสดงรายละเอียดข้อมูลใน Modal -->
                <p><strong>ชื่อ-สกุล:</strong> <span id="modal-firstname"></span>
                    <span id="modal-lastname"></span>
                </p>
                <p><strong>Email:</strong> <span id="modal-email"></span></p>
                <p><strong>วันเกิด:</strong> <span id="modal-dob"></span></p>
                <p><strong>เพศ:</strong> <span id="modal-gender"></span></p>
                <p><strong>สโมสร:</strong> <span id="modal-club"></span></p>
                <p><strong>บทบาท:</strong> <span id="modal-role"></span></p>
                <p><strong>รูปถ่าย:</strong></p>
                <!-- รูปถ่าย -->
                <img id="modal-avatar" src="" alt="รูปภาพสมาชิก" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>
<!-- สคริปท์สําหรับแสดงข้อมูลสมาชิกใน Modal -->
<script>
    $(document).ready(function() {
        // เมื่อคลิกปุ่ ม View
        $('.view-member-button').on('click', function() {
            const userId = $(this).data('user-id'); // ดึงค่า data-user-id จากปุ่ มที่คลิก
            // ส่ง AJAX ไปที่ view_get_member_dt.php เพื่อดึงข้อมูลสมาชิก
            $.ajax({ // ส่ง AJAX
                url: 'view_get_member_dt.php', // ไฟล์ที่จะส่งไป
                type: 'POST', // ใช้เมธอด POST
                data: { // ส่งข้อมูลไปด้วย
                    u_id: userId
                },
                success: function(response) { // ถ้าสําเร็จ
                    // นําข้อมูลที่ได้มาแสดงใน Modal
                    const member = JSON.parse(response); // แปลงข้อความ JSON ให้กลายเป็ น
                    Object
                    $('#modal-firstname').text(member.fname); // แสดงข้อมูลในModal โดยใช้ ID ของแต่ละข้อมูล
                    $('#modal-lastname').text(member.lname);
                    $('#modal-email').text(member.email);
                    $('#modal-role').text(member.role == 1 ? 'admin' : 'user');
                    $('#modal-dob').text(member.dob);
                    $('#modal-club').text(member.club_title);
                    $('#modal-gender').text(member.gender);
                    // แสดงรูปถ่าย หากไม่มีรูปให้ใช้รูปภาพเริ่มต้น
                    const avatarPath = member.avatar ?
                    '../assets/dist/avatar/' + member.avatar : '../assets/dist/avatar/user.png';
                    $('#modal-avatar').attr('src', avatarPath); // แสดงรูปภาพ
                    $('#memberModal').modal('show'); // แสดง Modal
                },
                error: function() {
                    alert('ไม่สามารถดึงข้อมูลได้');
                }
            });
        });
    });
</script>