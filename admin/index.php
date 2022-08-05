<?php
require_once "../database/db.php";

if ($_SESSION['role'] == "user") {
    header("location:../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.rtl.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>پنل ادمین</title>
</head>

<body dir="rtl">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand text-warning" href="../index.php">برنامه نویسان</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="../index.php">صفحه اصلی</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">دوره ها</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="page/allCourses.php">تمام دوره ها</a></li>
                            <li><a class="dropdown-item" href="page/addCourse.php">اضافه نمودن دوره جدید</a></li>
                            <li><a class="dropdown-item" href="page/addVideo.php">اضافه نمودن ویدیو جدید</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">بلاگ ها</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="page/allBlog.php">تمام وبلاگ ها</a></li>
                            <li><a class="dropdown-item" href="page/addBlog.php">اضافه نمودن بلاگ جدید</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">مدرسین</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="page/allTeachers.php">تمام مدرسین</a></li>
                            <li><a class="dropdown-item" href="page/addTeacher.php">اضافه نمودن مدرس جدید</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container m-5">
        <div class="row">
            <main class="my-5">
                <h1 class="text-center mb-5">پنل ادمین برنامه نویسان</h1>
                <h2 class="text-center">آموزشگاه علوم کمپیوتری برنامه نویسان</h2>
                <h3 class="text-center mt-5">برنامه نویس شو کسب درآمد کن</h3>
            </main>
        </div>
    </div>

<script src="../js/bootstrap.bundle.js"></script>
<br>
<br>
<br>
<?php include "../include/footer.php"; ?>
