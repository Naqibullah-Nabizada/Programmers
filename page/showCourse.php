<?php

include "../include/header.php";

require_once "../database/db.php";

$select = $connect->prepare("SELECT course.id, title, content, `image`, CONCAT(firstname, ' ' ,lastname) AS teacher, cost, `date` FROM course INNER JOIN teacher ON course.teacher_id = teacher.id ORDER BY `date` DESC");
$select->execute();
$courses = $select->fetchAll(PDO::FETCH_OBJ);


?>
    <main class="container-fluid">

    <h5 class="m-5 p-3 text-center alert alert-primary">لیست دوره های سایت آموزشی برنامه نویسان</h5>

    <section class="lessons mt-5">
            <div class="row d-flex justify-content-center">
                <?php
                foreach ($courses as $course) : ?>
                    <div class="card col-3 m-3" style="width: 30%;" onmouseover="mOver(this)" onmouseout="mOut(this)">
                        <a href="../page/singleCourse.php?id=<?= $course->id ?>"><img src="../upload/course_image/<?= $course->image ?>" class="card-img-top w-100" height="160px" alt="<?= $course->title ?>"></a>
                        <div class="card-body">
                            <h6 class="card-title"> <a href="page/singleCourse.php" class="text-dark"><?= $course->title ?> </a></h6>
                            <section class="teacherAndCom d-flex justify-content-between mt-3">
                                <div class="teacher">
                                    <span class="fa fa-user"></span>
                                    <span><a href="#" class="text-success"><?= $course->teacher ?> </a></span>
                                </div>
                                <div class="comment">
                                    <?php

                                    $comment = $connect->prepare("SELECT COUNT(id) as comments FROM comment WHERE course_id=?");
                                    $comment->bindValue(1, $course->id);
                                    $comment->execute();
                                    $countComment = $comment->fetch(PDO::FETCH_OBJ);
                                    ?>
                                    <span class="fa fa-comment"></span>
                                    <span><?= $countComment->comments ?></span>
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
                                    <span class="fa fa-clock-o"></span>
                                    <span><?php if($sumTime->time == 0){ echo "۰۰:۰۰:۰۰"; }else { echo $sumTime->time . ' دقیقه';} ?></span>
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

    <?php include "../include/footer.php"; ?>