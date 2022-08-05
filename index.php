<?php
require_once "database/db.php";

$select = $connect->prepare("SELECT course.id, title, content, `image`, CONCAT(firstname, ' ' ,lastname) AS teacher, cost, `date` FROM course INNER JOIN teacher ON course.teacher_id = teacher.id ORDER BY `date` DESC LIMIT 16");
$select->execute();
$courses = $select->fetchAll(PDO::FETCH_OBJ);


$Select = $connect->prepare("SELECT blog.id, title, content, `image`, `date`, CONCAT(firstname, ' ' , lastname) AS fullName FROM blog INNER JOIN teacher ON blog.teacher_id = teacher.id ORDER BY `date` DESC LIMIT 6");
$Select->execute();
$blogs = $Select->fetchAll(PDO::FETCH_OBJ);


$user = $connect->prepare("SELECT COUNT(id) AS users FROM user");
$user->execute();
$allUser = $user->fetch(PDO::FETCH_OBJ);


if (isset($_SESSION['login'])) {
    $gender = $connect->prepare("SELECT * FROM user WHERE id = ?");
    $gender->bindValue(1, $_SESSION['userId']);
    $gender->execute();
    $userGender = $gender->fetch(PDO::FETCH_OBJ);
}

$teacher = $connect->prepare("SELECT COUNT(id) AS teachers FROM teacher");
$teacher->execute();
$allTeacher = $teacher->fetch(PDO::FETCH_OBJ);


$video = $connect->prepare("SELECT SUM(`time`) AS `time` FROM video");
$video->execute();
$sumTime = $video->fetch(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="fa-IR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="font/css/font-awesome.css">
    <link rel="stylesheet" href="css/bootstrap.rtl.css">
    <link rel="stylesheet" href="css/style.css">
    <title>برنامه نویسان</title>
</head>

<body dir="rtl">
    <header>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand text-warning" href="./index.php">برنامه نویسان</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" href="page/showCourse.php">آخرین دوره ها</a></li>
                        <li class="nav-item"><a class="nav-link active" href="page/showTeachers.php">معرفی مدرسین</a></li>
                        <li class="nav-item"><a class="nav-link active" href="page/showBlog.php">بلاگ</a></li>
                        <li class="nav-item"><a class="nav-link active" href="./page/roles.php">قوانین سایت</a></li>
                        <li class="nav-item"><a class="nav-link active" href="./page/work-with-us.php">همکاری با برنامه نویسان </a></li>
                        <li class="nav-item"><a class="nav-link active" href="page/contact-us.php">تماس با ما</a></li>
                        <li class="nav-item"><a class="nav-link active" href="page/about-us.php">در باره ما</a></li>
                        <?php
                        if (isset($_SESSION['login'])) { ?>
                            <li class="nav-item nav-link active text-light" style="margin-right: 6rem;"><a href="#"> <?= $_SESSION['username'] ?> </a></li>
                            <li><a href="#" title="<?= $_SESSION['username'] ?>"><img src="<?php if ($userGender->gender == 1) {
                                                                                                echo "./upload/users/man-user.png";
                                                                                            } else if ($userGender->gender == 0) {
                                                                                                echo "./upload/users/woman.png";
                                                                                            } ?>" class="rounded rounded-circle" width="40px"></a></li>
                            <?php
                            if ($_SESSION['role'] != "0") { ?>
                                <li class="nav-item"><a class="nav-link active mx-5" href="admin/index.php">پنل ادمین</a></li>
                        <?php }
                        } ?>
                    </ul>
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <?php
                        if (isset($_SESSION['login'])) { ?>
                            <li class="nav-item"><a href="page/logout.php" class="nav-link active">خروج</a></li>
                        <?php
                        } else { ?>
                            <li class="nav-item"><a href="page/login.php" class="nav-link active">ورود</a></li>
                            <li class="nav-item"><a href="page/register.php" class="nav-link text-primary">ثبت نام</a></li>
                        <?php
                        }
                        ?>

                    </ul>
                </div>
            </div>
        </nav>


        <section class="label mt-5">
            <p class="h3 text-center text-white">خود آموزی، کسب تجربه، ورود به بازار کار با برنامه نویسان</p>
            <P class="h3 text-center mt-5 text-white">با کمترین هزینه خودت حرفه یی یاد بگیر</P>
        </section>

        <form action="./page/search.php" method="GET" class="mt-5 mx-auto d-flex input-group" style="width: 40%;">
            <input type="text" name="search" placeholder="چی میخوای یاد بگیری؟" class="form-control text-start input-group-text">
            <input type="submit" value="جستجو" class="input-group-text">
        </form>

        <section class="siteInfo">
            <div class="row col-6 mx-auto d-flex text-white text-center">
                <div class="col">
                    <img src="image/logo/stat-time.svg" class="img-fluid" alt="Time">
                    <span><?= $sumTime->time ?> دقیقه آموزش</span>
                </div>
                <div class="col">
                    <img src="image/logo/stat-teacher.svg" class="img-fluid" alt="Teachers">
                    <span><?= $allTeacher->teachers ?> مدرس مجرب</span>
                </div>
                <div class="col">
                    <img src="image/logo/stat-student.svg" class="img-fluid" alt="Students">
                    <span><?= $allUser->users ?> نفر دانشجو</span>
                </div>
            </div>
        </section>
    </header>

    <!-- Start Lessons -->

    <main class="container-fluid">
        <section class="d-flex justify-content-center my-5">
            <img src="image/logo/Consult.png" alt="Consult" class="img-fluid">
            <img src="image/logo/Discount.png" alt="Discount" class="img-fluid">
            <img src="image/logo/WorkWithUs.png" alt="WorkWithUs" class="img-fluid">
            <img src="image/logo/rent2.png" alt="rent" class="img-fluid">
        </section>

        <section class="d-flex justify-content-between">
            <span class="mx-5 newUpload">آخرین دوره های برنامه نویسان</span>
            <span><a href="page/showCourse.php" class="h6 mx-5 text-primary">مشاهده همه دوره ها <i class="fa fa-arrow-circle-left"></i> </a></span>
        </section>

        <section class="lessons mt-5">
            <div class="row d-flex justify-content-center">
                <?php
                foreach ($courses as $course) : ?>
                    <div class="card shadow m-3" onmouseover="mOver(this)" onmouseout="mOut(this)">
                        <a href="page/singleCourse.php?id=<?= $course->id ?>"><img id="courseImg" src="./upload/course_image/<?= $course->image ?>" class="card-img-top w-100" height="160px" alt="<?= $course->title ?>"></a>
                        <div class="card-body">
                            <h6 class="card-title"> <a href="page/singleCourse.php?id=<?= $course->id ?>" class="text-dark"><?= $course->title ?> </a></h6>
                            <section class="teacherAndCom d-flex justify-content-between mt-3">
                                <div class="teacher">
                                    <span class="fa fa-user text-muted"></span>
                                    <span><a href="#" class="text-success"><?= $course->teacher ?> </a></span>
                                </div>
                                <div class="comment">
                                    <?php

                                    $comment = $connect->prepare("SELECT COUNT(id) as comments FROM comment WHERE course_id=?");
                                    $comment->bindValue(1, $course->id);
                                    $comment->execute();
                                    $countComment = $comment->fetch(PDO::FETCH_OBJ);
                                    ?>
                                    <span class="fa fa-comment text-muted"></span>
                                    <span class="text-muted"><?= $countComment->comments ?></span>
                                </div>
                            </section>
                            <hr>
                            <section class="timeAndPrice d-flex justify-content-between">
                                <div class="time">
                                    <?php
                                    $fullTime = $connect->prepare("SELECT SUM(`time`) AS `time` FROM video WHERE course_id=?");
                                    $fullTime->bindValue(1, $course->id);
                                    $fullTime->execute();
                                    $sumTime = $fullTime->fetch(PDO::FETCH_OBJ);
                                    ?>
                                    <span class="fa fa-clock-o text-primary"></span>
                                    <span class="text-primary"><?php if ($sumTime->time == 0) {
                                                                    echo "۰۰:۰۰:۰۰";
                                                                } else {
                                                                    echo $sumTime->time . ' دقیقه';
                                                                } ?></span>
                                </div>
                                <div class="price">
                                    <span class="text-success fw-bold"><?php if ($course->cost == 0) {
                                                                            echo 'رایگان';
                                                                        } else {
                                                                            echo $course->cost . ' افغانی';
                                                                        } ?></span>
                                </div>
                            </section>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </section>
    </main>

    <!-- Start Topics -->

    <section class="d-flex justify-content-between mt-5">
        <span class="mx-5 newUpload">آخرین مقالات برنامه نویسان</span>
        <span><a href="page/showBlog.php" class="h6 mx-5 text-primary">مشاهده همه مقالات <i class="fa fa-arrow-circle-left"></i> </a></span>
    </section>

    <section class="topics mt-5">
        <div class="row mx-5 rounded">

            <?php
            foreach ($blogs as $blog) : ?>
                <div class="card m-3 shadow" style="width: 30.7%;" onmouseover="mOver(this)" onmouseout="mOut(this)">
                    <a href="./page/singleBlog.php?id=<?= $blog->id ?>"><img src="./upload/blog_image/<?= $blog->image ?>" class="card-img-top w-100" alt="<?= $blog->title ?>"></a>
                    <div class="card-body">
                        <h6 class="card-title"> <a href="./page/singleBlog.php?id=<?= $blog->id ?>" class="text-dark"><?= $blog->title ?></a> </h6>
                        <p class="card-text text-muted" style="text-align: justify;"> <?= substr($blog->content, 0, 130) ?> <a href="page/singleBlog.php?id=<?= $blog->id ?>">بیشتر...</a> </p>
                        <section class="teacherAndCom d-flex justify-content-between mt-3">

                            <?php

                            $view = $connect->prepare("SELECT COUNT(id) as views FROM view WHERE blog_id=?");
                            $view->bindValue(1, $blog->id);
                            $view->execute();
                            $countView = $view->fetch(PDO::FETCH_OBJ);
                            ?>
                            <div class="view text-muted">
                                <span class="fa fa fa-eye"></span>
                                <span><?= $countView->views ?></span>
                            </div>

                            <div class="teacher">
                                <span class="fa fa-user text-primary"></span>
                                <span><a href=""><?= $blog->fullName ?></a></span>
                            </div>

                        </section>
                    </div>
                </div>
            <?php endforeach ?>

        </div>
    </section>

    <?php include "./include/footer.php"; ?>
</body>
<script src="js/bootstrap.bundle.js"></script>
<script src="js/app.js"></script>

</html>