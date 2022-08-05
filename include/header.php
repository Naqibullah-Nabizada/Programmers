<?php include "../database/db.php";

if (isset($_SESSION['login'])) {
    $gender = $connect->prepare("SELECT * FROM user WHERE id = ?");
    $gender->bindValue(1, $_SESSION['userId']);
    $gender->execute();
    $userGender = $gender->fetch(PDO::FETCH_OBJ);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../font/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap.rtl.css">
    <link rel="stylesheet" href="../css/style.css">
    <title></title>
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
                    <li class="nav-item"><a class="nav-link active" href="../page/showCourse.php">آخرین دوره ها</a></li>
                    <li class="nav-item"><a class="nav-link active" href="showTeachers.php">معرفی مدرسین</a></li>
                    <li class="nav-item"><a class="nav-link active" href="showBlog.php">بلاگ</a></li>
                    <li class="nav-item"><a class="nav-link active" href="../page/roles.php">قوانین سایت</a></li>
                    <li class="nav-item"><a class="nav-link active" href="../page/work-with-us.php">همکاری با برنامه نویسان </a></li>
                    <li class="nav-item"><a class="nav-link active" href="../page/contact-us.php">تماس با ما</a></li>
                    <li class="nav-item"><a class="nav-link active" href="../page/about-us.php">در باره ما</a></li>
                    <?php
                    if (isset($_SESSION['login'])) { ?>
                        <li class="nav-item nav-link active text-light" style="margin-right: 6rem;"><a href="#"> <?= $_SESSION['username'] ?> </a></li>
                        <li><a href="#" title="<?= $_SESSION['username'] ?>"><img src="<?php if ($userGender->gender == 1) {
                                                                                            echo "../upload/users/man-user.png";
                                                                                        } else {
                                                                                            echo "../upload/users/woman.png";
                                                                                        } ?>" class="rounded rounded-circle" width="40px"></a></li>
                        <?php
                        if ($_SESSION['role'] != 0) { ?>
                            <li class="nav-item"><a class="nav-link active mx-5" href="../admin/index.php">پنل ادمین</a></li>
                    <?php }
                    } ?>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <?php
                    if (isset($_SESSION['login'])) { ?>
                        <li class="nav-item"><a href="../page/logout.php" class="nav-link active">خروج</a></li>
                    <?php
                    } else { ?>
                        <li class="nav-item"><a href="../page/login.php" class="nav-link active">ورود</a></li>
                        <li class="nav-item"><a href="../page/register.php" class="nav-link text-primary">ثبت نام</a></li>
                    <?php
                    }
                    ?>

                </ul>
            </div>
        </div>
    </nav>