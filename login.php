<?php include "database.php";
if(isset($_POST['login'])){
  $username = trim(htmlspecialchars($_POST['username']));
  $password = trim(htmlspecialchars($_POST['password']));

  // cek ada akunnya atau tidak
  $cek = "select id from users where username='$username' and password=md5('$password')";
  $query_cek = mysqli_query($db, $cek);
  $jum = mysqli_num_rows($query_cek);
  if($jum == 1){
      $_SESSION['tw_login'] = $username;
      header("Location:dashboard.php");
      return true;
  }else{
      $_SESSION['message'] = "Error: Gagal login";
      header("Location:login.php");
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
    <title>Login</title>
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
<body class="text-center">
    
<main class="form-signin">
  <form action="proses.php" method="POST">
    <input type="hidden" name="login" value="1">
    <h1 class="h3 mb-3 fw-normal">Sign In</h1>

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

    <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
    <a class="w-100 btn btn-lg btn-success mt-1" href="index.php">Sign up</a>
    <p class="mt-5 mb-3 text-muted">&copy;jalanmuterbalik</p>
  </form>
</main>


    
  </body>
    <script src="js/bootstrap.min.js"></script>
</html>