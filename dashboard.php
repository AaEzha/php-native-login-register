<?php include "database.php"; ?>
<?php
if(!isset($_SESSION['tw_login'])){
    $_SESSION['message'] = "Error: Harus sign in terlebih dahulu!";
    header("Location:index.php");
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
    <title>Document</title>
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
    <?php
    $name = $_SESSION['tw_login'];
    $name = explode('@', $name);
    $name = $name[0];
    ?>
    <h1 class="h3 mb-3 fw-normal">Welcome, <?=$name;?>!</h1>
    <a class="w-100 btn btn-lg btn-success mt-1" href="logout.php">Sign out</a>
    <p class="mt-5 mb-3 text-muted">&copy;jalanmuterbalik</p>
</main>
    
  </body>
    <script src="js/bootstrap.min.js"></script>
</html>