<?php
require_once "../../database/db.php";

if ($_SESSION['role'] == 0){
    header("location:../../index.php");
}

if (isset($_POST['submit'])){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    if (isset($_FILES['photo'])){
        $name = $_FILES['photo']['name'];
        $tmp = $_FILES['photo']['tmp_name'];
        move_uploaded_file($tmp, "../../upload/users/$name");
    }
    $photo = $_FILES['photo']['name'];
    $bio = $_POST['bio'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $query = $connect->prepare("INSERT INTO teacher SET firstname=?, lastname=?, photo=?, bio=?, phone=?, email=?");
    $query->bindValue(1, $firstname);
    $query->bindValue(2, $lastname);
    $query->bindValue(3, $photo);
    $query->bindValue(4, $bio);
    $query->bindValue(5, $phone);
    $query->bindValue(6, $email);
    $query->execute();
    echo "<script> alert('مدرس موفقانه اضافه شد') </script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.rtl.css">
    <link rel="stylesheet" href="../../css/style.css">
    <title>اضافه نمودن مدرس</title>
</head>
<body dir="rtl">

<div class="container">
    <h4 class="text-center mt-3">اضافه نمودن مدرس</h4>
    <form method="post" class="col-5 mx-auto p-3 d-grid" enctype="multipart/form-data">
        <label class="form-label">نام:</label>
        <input name="firstname" type="text" placeholder="نام" class="form-control mb-2" autofocus required>
        <label class="form-label">نام خانوادگی:</label>
        <input name="lastname" type="text" placeholder="نام خانوادگی" class="form-control mb-2" required>
        <label class="form-label">عکس:</label>
        <input name="photo" type="file" class="form-control mb-2">
        <label class="form-label">روزمه:</label>
        <textarea name="bio" cols="30" rows="4" placeholder="روزمه" class="form-control mb-2" required></textarea>
        <label class="form-label">موبایل:</label>
        <input name="phone" type="tel" placeholder="موبایل" class="form-control text-start mb-2" required>
        <label class="form-label">ایمیل:</label>
        <input name="email" type="email" placeholder="ایمیل" class="form-control text-start mb-2" required>
        <input name="submit" type="submit" value="ثبت" class="btn btn-success">
        <a href="../index.php" class="btn btn-secondary mt-2">بازگشت</a>
    </form>
</div>

</body>
</html>