<?php

include "../include/header.php";
require_once "../database/db.php";
require_once "../database/jdf.php";

$blog_id = $_GET['id'];

$query = $connect->prepare("SELECT title, content, `image`, `date`, CONCAT(firstname, ' ' , lastname) AS fullName, photo FROM blog INNER JOIN teacher ON blog.teacher_id = teacher.id WHERE blog.id=?");
$query->bindValue(1, $blog_id);
$query->execute();
$blogs = $query->fetch(PDO::FETCH_OBJ);


$view = $connect->prepare("INSERT INTO view SET blog_id=?");
$view->bindValue(1, $blog_id);
$view->execute();

?>



<!-- Start main -->

<h4 class="text-center mt-5 p-3 alert alert-primary"><?= $blogs->title ?></h4>

<main class="container mt-5">
    <section class="row d-flex justify-content-around">

        <section class="col-3">
            <div class="card shadow">
                <img src="../upload/users/<?= $blogs->photo ?>" alt="<?= $blogs->fullName ?>" class="img-fluid w-75 mx-auto rounded-circle border shadow mt-3">
                <div class="card-body mx-auto">
                    <div>
                        <span class="text-muted">نویسنده: </span>
                        <span class="text-primary"><?= $blogs->fullName ?></span>
                    </div>
                    <div class="mt-2">
                        <span class="text-muted">تاریخ انتشار: </span>
                        <span class="text-success"><?= jdate('Y/m/d', $blogs->date) ?></span>
                    </div>
                </div>
            </div>
        </section>

        <section class="col-7 border rounded shadow">
            <div class="card">
                <img src="../upload/blog_image/<?= $blogs->image ?>" alt="<?= $blogs->title ?>" class="img-fluid w-100">
                <div class="card-body">
                    <h5 class="card-title"><?= $blogs->title ?></h5>
                    <p class="card-text text-muted" style="text-align: justify;"><?= $blogs->content ?></p>
                </div>
            </div>
        </section>

    </section>
</main>

<?php include "../include/footer.php"; ?> 