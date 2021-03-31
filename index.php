<?php

use PHPMailer\PHPMailer\PHPMailer;

include "database.php";
if(isset($_POST['register'])){
  $username = trim(htmlspecialchars($_POST['username']));
  $password = trim(htmlspecialchars($_POST['password']));

  // cek ada username yang sama atau tidak
  $cek = "select id from users where username='$username'";
  $query_cek = mysqli_query($db, $cek);
  $jum = mysqli_num_rows($query_cek);
  if($jum >= 1){
      $_SESSION['message'] = "Username sudah terdaftar";
      header("Location:index.php");
      return false;
  }

  // cek kekuatan password
  if( !preg_match("#[A-Z]+#", $password) ) {
      $_SESSION['message'] = "Password harus mengandung 1 huruf kapital!";
      header("Location:index.php");
      return false;
  }

  // daftarkan
  $daftar = "insert into users (username, password) values('$username', md5('$password'))";
  $query_daftar = mysqli_query($db, $daftar);
  if($query_daftar){
      // kirim email
      $name = explode('@', $username);
      $name = $name[0];
      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->SMTPSecure = 'tls';
      $mail->SMTPAuth = true;
      $mail->Host = 'smtp.gmail.com';
      $mail->Port = 587;
      $mail->Username = 'rezanurfachmi@gmail.com';
      $mail->Password = 'rjbzmlfidztdqinp';
      $mail->setFrom('noreply@sweng-academy.com');
      $mail->addAddress($username);
      $mail->Subject = 'Your account has been created';
      $mail->Body = "Hi, $name\n\n";
      $mail->Body .= "Your account s successfully created\n\n";
      $mail->Body .= "Please enjoy\nSweng-Academy Team";
      //send the message, check for errors
      if (!$mail->send()) {
          $_SESSION['message'] = $mail->ErrorInfo;
          header("Location:index.php");
          return false;
      }

      // ke halaman dashboard
      $_SESSION['tw_login'] = $username;
      header("Location:dashboard.php");
      return true;
  }else{
      $_SESSION['message'] = "Error: Gagal register";
      header("Location:index.php");
      return false;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/signin.css">
    <title>Register</title>
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
</head>
<body>
    
<main class="form-signin">
  <form action="proses.php" method="POST">
  <input type="hidden" name="register" value="1">
    <h1 class="h3 mb-3 fw-normal">Sign Up</h1>

    <?php if(isset($_SESSION['message'])) { ?>
    <p><?= $_SESSION['message']; ?></p>
    <?php unset($_SESSION['message']); ?>
    <?php } ?>

    <div class="form-floating">
      <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="username" required>
      <label for="floatingInput">User Name</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Password"  name="password" minlength="6" required>
      <label for="floatingPassword">Password</label>
    </div>

    <button class="w-100 btn btn-lg btn-primary" type="submit">Sign up</button>
    <div class="text-right">
      <a class="mt-1" href="login.php">Sign in</a>
    </div>
    <p class="mt-5 mb-3 text-muted">&copy;jalanmuterbalik</p>
  </form>
</main>


    
  </body>
    <script src="js/bootstrap.min.js"></script>
</html>