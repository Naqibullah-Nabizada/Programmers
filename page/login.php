<?php
include "../include/header.php";

require_once "../database/db.php";

if (isset($_POST['login'])) {
    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = $connect->prepare("SELECT * FROM user WHERE username=? AND email=? AND `password`=?");
    $query->bindValue(1, $name);
    $query->bindValue(2, $email);
    $query->bindValue(3, $password);
    $query->execute();
    $users = $query->fetch(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['photo'] = $users->photo;
        $_SESSION['role'] = $users->role;
        $_SESSION['userId'] = $users->id;
        $_SESSION['gender'] = $users->gender;
        header("location:../index.php");
    } else {
        echo "<script> alert('نام کاربری، ایمیل یا رمز عبور نادرست است') </script>";
    }
}

?>
<!DOCTYPE html>
<html lang="fa-IR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.rtl.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>ورود</title>
</head>

<body dir="rtl">
    <div class="container">
        <h3 class="text-center my-5">برای ورود به سایت ایمیل و رمز عبور را وارد نماید</h3>
        <form method="post" class="col-4 mx-auto p-3 d-grid">
            <label class="form-label">نام کاربری:</label>
            <input name="username" type="text" placeholder="نام کاربری" class="form-control mb-3" autofocus required>
            <label class="form-label">ایمیل:</label>
            <input name="email" type="email" placeholder="ایمیل" class="form-control mb-3 text-start" required>
            <label class="form-label">رمز عبور:</label>
            <input name="password" type="password" placeholder="رمز عبور" class="form-control mb-3" required>

            <input name="login" type="submit" value="ورود" class="btn btn-primary mb-3">

            <a href="./register.php" class="btn btn-secondary">ثبت نام</a>

        </form>
    </div>

    <?php include "../include/footer.php"; ?>