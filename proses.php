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
}elseif(isset($_POST['login'])){
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
}else{
    $_SESSION['message'] = "Gagal diproses";
    header("Location:index.php");
    return false;
}

?>