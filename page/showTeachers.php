<?php
include "../include/header.php";
require_once "../database/db.php";

$select = $connect->prepare("SELECT * FROM teacher");
$select->execute();
$teachers = $select->fetchAll(PDO::FETCH_OBJ);
?>

<h5 class="alert alert-primary p-3 text-center m-5">لیست مدرسین سایت برنامه نویسان</h5>

<main>
    <div class="row d-flex justify-content-between m-4">
        <?php
        foreach ($teachers as $teacher) : ?>
            <div class="card m-3" style="width: 22.5%;">
                <img src="../upload/users/<?= $teacher->photo ?>" alt="<?= $teacher->firstname . ' ' . $teacher->lastname ?>" class="card-img-top">
                <div class="card-body">
                    <span class="fa fa-user"></span>
                    <a href="#" class="card-text"> <?= $teacher->firstname . ' ' . $teacher->lastname ?> </a>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</main>

<?php include "../include/footer.php"; ?>