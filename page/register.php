<?php
include "../include/header.php";
require_once "../database/db.php";

$select = $connect->prepare("SELECT * FROM user");
$select->execute();
$user = $select->fetch(PDO::FETCH_OBJ);


if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $query = $connect->prepare("INSERT INTO user SET firstname=?, lastname=?, username=?, phone=?, email=?, `password`=?");
        $query->bindValue(1, $firstname);
        $query->bindValue(2, $lastname);
        $query->bindValue(3, $username);
        $query->bindValue(4, $phone);
        $query->bindValue(5, $email);
        $query->bindValue(6, $password);
        $query->execute();
        $_SESSION['login'] = true;
        $_SESSION['username'] = $user->$username;
        $_SESSION['photo'] = $user->photo;
        $_SESSION['role'] = $user->role;
        header("location:../index.php");
    } catch (PDOException $e) {
        echo "<script> alert('ثبت نام انجام نشد دوباره کوشش کنید.') </script>";
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
    <title>ثبت نام</title>
</head>

<body dir="rtl">
    <div class="container">
        <h3 class="text-center my-3">برای استفاده از محتویات سایت ابتدا خود را ثبت نام کنید</h3>
        <form method="post" class="col-4 mx-auto d-grid">
            <label class="form-label">نام:</label>
            <input name="firstname" type="text" placeholder="نام" class="form-control mb-3" autofocus required>
            <label class="form-label">نام خانوادگی:</label>
            <input name="lastname" type="text" placeholder="نام خانوادگی" class="form-control mb-3" required>
            <label class="form-label">نام کاربری:</label>
            <input name="username" type="text" placeholder="نام کاربری" class="form-control mb-3" required>
            <div class="d-flex mb-2">
                <label class="form-check-label">آقا:</label>
                <input type="radio" name="gender" value="1" class="form-check-inline" checked>
                <label class="form-check-label">خانم:</label>
                <input type="radio" name="gender" value="0" class="form-check-inline">
            </div>
            <label class="form-label">موبایل:</label>
            <input name="phone" type="tel" placeholder="موبایل" class="form-control mb-3 text-start" required>
            <label class="form-label">ایمیل:</label>
            <input name="email" type="email" placeholder="ایمیل" class="form-control mb-3 text-start" required>
            <label class="form-label">رمز عبور:</label>
            <input name="password" type="password" placeholder="رمز عبور" class="form-control mb-3" required>
            <input name="submit" type="submit" value="ثبت نام" class="btn btn-success">

        </form>
    </div>

    <?php include "../include/footer.php"; ?>