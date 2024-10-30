 <?php
  require_once '../condb.php';

  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }


  if (isset($_SESSION['user_login'])) {
    $user_id = $_SESSION['user_login'];

    $sql = "SELECT persons.*, tb_users.* FROM persons
LEFT JOIN tb_users ON persons.id = tb_users.person_id
WHERE persons.id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $user_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  }

  ?>


 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-white">
   <!-- Left navbar links -->
   <ul class="navbar-nav">
     <li class="nav-item">
       <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
     </li>
     <li class="nav-item d-none d-sm-inline-block">
       <span class="nav-link">ยินดีต้อนรับ: <?php echo $row['fname'] . ' ' . $row['lname'] ?> </span>
     </li>

   </ul>
 </nav>
 <!-- /.navbar -->