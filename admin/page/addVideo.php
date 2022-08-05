<?php
require_once "../../database/db.php";

if ($_SESSION['role'] == 0){
    header("location:../../index.php");
}

$select = $connect->prepare("SELECT id, CONCAT(firstname, ' ' ,lastname) AS teacher FROM teacher");
$select->execute();
$teachers = $select->fetchAll(PDO::FETCH_OBJ);

$select = $connect->prepare("SELECT id, title FROM course");
$select->execute();
$courses = $select->fetchAll(PDO::FETCH_OBJ);

if (isset($_POST['submit'])) {
    try {

        if(isset($_FILES['video'])){
            $name = $_FILES['video']['name'];
            $tmp = $_FILES['video']['tmp_name'];
            move_uploaded_file($tmp, "../../upload/video/$name");
        }
        $video = $_FILES['video']['name'];
        $title = $_POST['title'];
        $teacher = $_POST['teacher'];
        $course = $_POST['course'];
        $time = $_POST['time'];
        $status = $_POST['status'];
        $date = time();

        $insert = $connect->prepare("INSERT INTO video SET video_name=?, title=?, teacher_id=?, course_id=?, `time`=?, `status`=?, `date`=?");
        $insert->bindValue(1, $video);
        $insert->bindValue(2, $title);
        $insert->bindValue(3, $teacher);
        $insert->bindValue(4, $course);
        $insert->bindValue(5, $time);
        $insert->bindValue(6, $status);
        $insert->bindValue(7, $date);
        $insert->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
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
    <title>اضافه نمودن ویدیو جدید</title>
</head>

<body dir="rtl">
    <div class="container">
        <h3 class="text-center m-5">ویدیو جدید را اضافه نماید</h3>
        <form method="post" class="col-4 offset-4 d-grid" enctype="multipart/form-data">
            <label class="form-label">ویدیو:</label>
            <input name="video" type="file" class="form-control mb-3" required>
            <label class="form-label">موضوع درس:</label>
            <input name="title" type="text" placeholder="موضوع درس" class="form-control mb-3">
            <label class="form-label">مدرس:</label>
            <select name="teacher" class="form-control mb-3">
                <?php
                foreach ($teachers as $teacher) : ?>
                    <option value="<?= $teacher->id ?>"> <?= $teacher->teacher ?> </option>
                <?php endforeach ?>
            </select>
            <label class="form-label">دوره آموزشی:</label>
            <select name="course" class="form-control mb-3">
                <?php
                foreach ($courses as $course) : ?>
                    <option value="<?= $course->id ?>"> <?= $course->title ?> </option>
                <?php endforeach ?>
            </select>
            <label class="form-label">مدت زمان ویدیو:</label>
            <input name="time" type="number" placeholder="مدت زمان ویدیو" class="form-control mb-3 text-start" required>
            <div>
                <label class="form-check-label">درحال برگزاری</label>
                <input name="status" type="radio" value="1" class="form-check-inline mb-4" checked>
                <label class="form-check-label">به اتمام رسیده</label>
                <input name="status" type="radio" value="0" class="form-check-inline mb-4">
            </div>
            <input name="submit" type="submit" value="اضافه نمودن" class="btn btn-success mb-2">
            <a href="../index.php" class="btn btn-secondary">بازگشت</a>
        </form>
    </div>
</body>

</html>