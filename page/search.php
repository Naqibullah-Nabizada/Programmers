<?php
include "../include/header.php";
require_once "../database/db.php";

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

$search = $_GET['search'];

$query = $connect->prepare("SELECT course.id,title, content, `image`, cost, CONCAT(firstname, ' ', lastname) AS teacher FROM course JOIN teacher WHERE course.teacher_id = teacher.id AND title LIKE'%$search%' ");
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if ($search == "") { ?>

    <h5 class="alert alert-danger text-center p-3 m-5">لطفا عنوان دوره مورد نظر را وارید نماید.</h5>
    <img src="../image/gif/no-found.gif" class="img-fluid w-25 mx-auto d-block">

<?php } else if ($query->rowCount() > 0) { ?>

    <h5 class="alert alert-primary text-center p-3 m-5">دوره های مرتبط با "<span class="fw-bold text-danger"><?= $search ?></span>" </h5>

    <section class="container-fluid row d-flex justify-content-center mt-5">
        <?php
        foreach ($results as $result) { ?>

            <div class="card shadow m-3" style="width: 22%;" onmouseover="mOver(this)" onmouseout="mOut(this)">
                <a href="singleCourse.php?id=<?= $result->id ?>"><img src="../upload/course_image/<?= $result->image ?>" class="card-img-top w-100" height="160px" alt="<?= $result->title ?>"></a>
                <div class="card-body">
                    <h6 class="card-title"> <a href="page/singleCourse.php" class="text-dark"><?= $result->title ?> </a></h6>
                    <section class="teacherAndCom d-flex justify-content-between mt-3">
                        <div class="teacher">
                            <span class="fa fa-user text-muted"></span>
                            <span><a href="#" class="text-success"><?= $result->teacher ?> </a></span>
                        </div>
                        <div class="comment">
                            <?php

                            $comment = $connect->prepare("SELECT COUNT(id) as comments FROM comment WHERE course_id=?");
                            $comment->bindValue(1, $result->id);
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
                            $fullTime->bindValue(1, $result->id);
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
                            <span class="text-success fw-bold"><?php if ($result->cost == 0) {
                                                                    echo 'رایگان';
                                                                } else {
                                                                    echo $result->cost . ' افغانی';
                                                                } ?></span>
                        </div>
                    </section>
                </div>
            </div>
        <?php  } ?>
    </section>

<?php } else { ?>

    <h5 class="alert alert-danger text-center p-3 m-5">دوره مرتبط با این "<span class="fw-bold text-primary"><?= $search ?></span>" عنوان یافت نشد...</h5>
    <img src="../image/gif/no-found.gif" class="img-fluid w-25 mx-auto d-block">

<?php } ?>




<?php include "../include/footer.php"; ?>