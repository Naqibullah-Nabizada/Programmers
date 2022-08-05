<?php

include "../include/header.php";
require_once "../database/db.php";
require_once "../database/jdf.php";
$number = 1;

$select = $connect->prepare("SELECT title, content, `image`, CONCAT(firstname, ' ' ,lastname) AS teacher, `level`, `status`, cost, `date` FROM course c INNER JOIN teacher t ON c.teacher_id = t.id WHERE c.id = ?");
$select->bindValue(1, $_GET['id']);
$select->execute();
$courses = $select->fetchAll(PDO::FETCH_OBJ);

if (isset($_POST['submit'])) {
    if ($_SESSION['userId'] == null) {
        echo "<p class='alert alert-danger text-center'>برای ثبت دیدگاه ابتدا ثبت نام نماید</p>";
    } else {
        $comment = $_POST['comment'];
        $date = time();
        $userId = $_SESSION['userId'];
        $course_id = $_GET['id'];
        $insert = $connect->prepare("INSERT INTO comment SET comment=?, `date`=?, course_id=?, user_id=?");
        $insert->bindValue(1, $comment);
        $insert->bindValue(2, $date);
        $insert->bindValue(3, $course_id);
        $insert->bindValue(4, $userId);
        $insert->execute();
        $_SESSION['login'] = true;
    }
}

$query = $connect->prepare("SELECT comment, `date`, username, photo, gender FROM comment c JOIN user u ON c.user_id = u.id WHERE course_id = ?");
$query->bindValue(1, $_GET['id']);
$query->execute();
$comments = $query->fetchAll(PDO::FETCH_OBJ);


$query = $connect->prepare("SELECT * FROM video WHERE course_id=? LIMIT 1");
$query->bindValue(1, $_GET['id']);
$query->execute();
$video = $query->fetch(PDO::FETCH_OBJ);


$query = $connect->prepare("SELECT * FROM video WHERE course_id=?");
$query->bindValue(1, $_GET['id']);
$query->execute();
$videos = $query->fetchAll(PDO::FETCH_OBJ);

$query = $connect->prepare("SELECT COUNT(id) as allVideo FROM video WHERE course_id=?");
$query->bindValue(1, $_GET['id']);
$query->execute();
$countVideo = $query->fetch(PDO::FETCH_OBJ);

$query = $connect->prepare("SELECT SUM(`time`) AS `time` FROM video WHERE course_id=?");
$query->bindValue(1, $_GET['id']);
$query->execute();
$time = $query->fetch(PDO::FETCH_OBJ);

?>


<h5 class="text-center alert alert-primary p-3 m-5">خود آموزی، کسب تجربه، ورود به بازار کار با سایت آموزشی برنامه نویسان</h5>

<main class="mt-5 container">
    <div class="row d-flex justify-content-around">

        <!-- Start of letf site -->

        <section class="col-3 border h-100 rounded p-3 shadow">
            <?php
            foreach ($courses as $course) : ?>
                <span class="fa fa-dollar text-success mx-1"></span>
                <span>قیمت این دوره: </span><span class="text-success"><?php if ($course->cost == 0) {
                                                                            echo "رایگان";
                                                                        } else {
                                                                            echo $course->cost . " " . 'اففانی';
                                                                        } ?></span>
                <hr>
                <section class="courseInfo">
                    <div class="mb-2">
                        <span class="fa fa-user text-muted mx-1"></span>
                        <span>مدرس: <?= $course->teacher ?></span>
                    </div>


                    <div class="mb-2">
                        <span class="fa fa-video-camera text-muted mx-1"></span>
                        <span>تعداد ویدیو ها: <?= $countVideo->allVideo ?></span>
                    </div>
                    <div class="mb-2">
                        <span class="fa fa-clock-o text-muted mx-1"></span>
                        <span>مدت زمان دوره: <?php if ($countVideo->allVideo == 0) {
                                                    echo '۰۰:۰۰:۰۰';
                                                } else {
                                                    echo $time->time . " دقیقه";
                                                } ?></span>
                    </div>
                    <div class="mb-2">
                        <span class="fa fa-suitcase text-muted mx-1"></span>
                        <span>سطح دوره: <?php if ($course->level == '1') {
                                            echo "مقدماتی";
                                        } else if ($course->level == '2') {
                                            echo "متوسط";
                                        } else if ($course->level == '3') {
                                            echo "پیشرفته";
                                        } ?></span>
                    </div>
                    <div class="mb-2">
                        <span class="fa fa-podcast text-muted mx-1"></span>
                        <span>وضعیت دوره: </span><span class="text-primary"><?php
                                                                            if ($countVideo->allVideo == 0) {
                                                                                echo "بزودی ...";
                                                                            } elseif ($course->status == 0) {
                                                                                echo "به اتمام رسیده";
                                                                            } else {
                                                                                echo 'در حال برگزاری';
                                                                            } ?></span>
                    </div>
                    <?php
                    if ($countVideo->allVideo > 0) { ?>
                        <div class="mb-4">
                            <span class="fa fa-calendar text-muted mx-1"></span>
                            <span>تاریخ بروز رسانی: <?= jdate("Y/m/d", $course->date) ?></span>
                        </div>
                    <?php } ?>

                    <!-- Buy course link -->

                    <?php
                    if (isset($_SESSION['login']) && $course->cost > 0) { ?>
                        <div class="mb-2 d-grid">
                            <a href="#" class="btn btn-success">خرید دوره</a>
                        </div>
                    <?php } else if ($course->cost > 0 && !isset($_SESSION['login'])) { ?>
                        <p class="alert alert-primary text-center p-3 mb-2">برای خرید دوره ابتدا وارد سایت شوید.</p>
                    <?php } else if ($course->cost == 0 && !isset($_SESSION['login']) && $countVideo->allVideo > 0) { ?>
                        <p class="alert alert-primary text-center p-3 mb-2">برای دانلود ویدیو ها ابتدا وارد سایت شوید.</p>
                    <?php } ?>

                </section>

        </section>
    <?php endforeach;

            // End of right site

            // Start of left site

            foreach ($courses as $course) : ?>
        <section class="col-7 border rounded p-3 shadow">
            <img src="../upload/course_image/<?= $course->image ?>" alt="<?= $course->title ?>" class="img-fluid rounded w-100">
            <h6 class="my-4"><?= $course->title ?></h6>
            <p class="my-3" style="text-align: justify; line-height: 2rem;"><?= $course->content ?></p>
            <hr>
            <section class="border">

                <?php
                if ($countVideo->allVideo != 0) { ?>
                    <div class="d-flex justify-content-between p-3">
                        <div>
                            <span class="fa fa-file-video-o"></span>
                            <span>ویدیو های این دروه</span>
                        </div>
                        <div>
                            <span>مدت زمان این دوره: </span>
                            <span><?= $time->time . ' دقیقه' ?></span>
                        </div>
                    </div>
                    <hr>
                    <div class="video">
                        <video src="../upload/video/<?= $video->video_name ?>" controls width="100%" height="100%"></video>
                        <hr>
                        <?php
                        foreach ($videos as $video) : ?>
                            <div class="d-flex justify-content-between border p-3 m-2">
                                <div>
                                    <span class="border rounded-circle p-1 mx-2"><?= $number ?></span>
                                    <span><?= $video->title ?></span>
                                </div>
                                <div>
                                    <span><?= $video->time . ' دقیقه' ?></span>
                                    <a <?php if (isset($_SESSION['login'])) { ?> href="../upload/video/<?= $video->video_name ?>" class="fa fa-download text-success" download="<?= $video->video_name ?>" <?php } else { ?> class="fa fa-lock text-muted fs-4 mx-2" <?php } ?>> </a>
                                </div>
                            </div>
                        <?php $number++;
                        endforeach ?>
                    </div>
                <?php } ?>
            </section>

            <!-- Start of Comment -->

            <?php if ($countVideo->allVideo != 0) { ?>
                <section class="comment mt-5">

                    <div class="writeComment">
                        <?php
                        if (isset($_SESSION['login'])) { ?>
                            <label class="form-label">نظرات کاربران در رابطه به این دوره</label>

                            <form method="post">
                                <textarea name="comment" rows="10" placeholder="نظر خود را راجع به این دروه بنوسید" class="form-control mb-2" required></textarea>
                                <input name="submit" type="submit" value="ثبت دیدگاه" class="btn btn-success">
                            </form>
                        <?php } else { ?>
                            <p class="alert alert-warning text-center p-4">برای ثبت دیدگاه ابتدا وارد سایت شود.</p>
                        <?php  } ?>
                        <hr>
                    </div>

                    <h6 class="my-3 bg-primary p-2 text-white rounded">نظرات</h6>
                    <hr>
                    <?php
                    foreach ($comments as $comment) : ?>
                        <div class="my-5">
                            <span class="col-3">
                                <img src="<?php if ($comment->photo == "" && $comment->gender == 0) {?> ../upload/users/woman.png <?php }else if ($comment->photo == "" && $comment->gender == 1){?>../upload/users/man-user.png<?php } else if ($comment->photo != "") {?>../upload/users/<?=$comment->photo; } ?>" alt="<?= $comment->username ?>" class="img-fluid rounded-circle mx-3" style="width: 10% !important;">
                            </span>

                            <span class="col-9">
                                <span class="mx-3"><?= $comment->username ?></span>
                                <span class="text-muted">ارسال شده در تاریخ: <?= jdate("Y/m/d", $comment->date) ?></span>
                            </span>
                            <div class="showComment col-9 mt-4">
                                <p class="m-3"><?= $comment->comment ?></p>
                            </div>

                        </div>
                    <?php endforeach ?>
                </section>
            <?php } ?>
        </section>
    <?php endforeach ?>

    </div>
</main>

<?php include "../include/footer.php"; ?>