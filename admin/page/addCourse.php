<?php
require_once "../../database/db.php";

if ($_SESSION['role'] == 0) {
    header("location:../../index.php");
}

$query = $connect->prepare("SELECT id, CONCAT(firstname, ' ' ,lastname) AS teacher FROM teacher");
$query->execute();
$teachers = $query->fetchAll(PDO::FETCH_OBJ);

if (isset($_POST['submit'])) {

    $title = $_POST['title'];
    $content = $_POST['content'];

    if (isset($_FILES['file'])) {
        $name = $_FILES['file']['name'];
        $tmp = $_FILES['file']['tmp_name'];
        move_uploaded_file($tmp, "../../upload/course_image/$name");
    }

    $image = $_FILES['file']['name'];
    $teacher = $_POST['teacher'];
    $cost = $_POST['cost'];
    $level = $_POST['level'];
    $status = $_POST['status'];
    $date = time();

    $insert = $connect->prepare("INSERT INTO course SET title=?, content=?, `image`=?, teacher_id=?, cost=?, `level`=? ,`status`=?, `date`=?");
    $insert->bindValue(1, $title);
    $insert->bindValue(2, $content);
    $insert->bindValue(3, $image);
    $insert->bindValue(4, $teacher);
    $insert->bindValue(5, $cost);
    $insert->bindValue(6, $level);
    $insert->bindValue(7, $status);
    $insert->bindValue(8, $date);
    $insert->execute();
    echo "<script> alert('دوره جدید موفقانه اضافه شد') </script>";
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
    <title>اضافه نمودن دوره جدید</title>
</head>

<body dir="rtl">
    <div class="container">
        <h4 class="text-center mt-3">اضافه نمودن دوره جدید</h4>

        <form method="post" class="col-5 mx-auto p-2" enctype="multipart/form-data">
            <label class="form-label">دوره:</label>
            <input name="title" type="text" placeholder="دوره" class="form-control mb-2" autofocus required>
            <label class="form-label">توضیحات:</label>
            <textarea name="content" cols="30" rows="4" placeholder="توضیحات" class="form-control mb-2"></textarea>
            <label class="form-label">تصویر:</label>
            <input name="file" type="file" class="form-control mb-2">
            <label class="form-label">مدرس:</label>
            <select name="teacher" class="form-control mb-2">
                <?php
                foreach ($teachers as $teacher) : ?>
                    <option value="<?= $teacher->id ?>"> <?= $teacher->teacher ?> </option>
                <?php endforeach; ?>
                ?>
            </select>
            <label class="form-label">سطح دوره:</label>
            <select name="level" class="form-control">
                <option value="1">مقدماتی</option>
                <option value="2">متوسط</option>
                <option value="3">پیشرفته</option>
            </select>
            <label class="form-label">قیمت:</label>
            <input name="cost" type="number" class="form-control mb-2" required>
            <label class="form-check-label">فعال</label>
            <input name="status" value="1" type="radio" class="form-check-inline mb-3" checked>
            <label class="form-check-label">غیر فعال</label>
            <input name="status" value="0" type="radio" class="form-check-inline mb-3">
            <div class="d-grid">
                <input name="submit" type="submit" value="ثبت" class="btn btn-success mb-2">
                <a href="../index.php" class="btn btn-secondary">بازگشت</a>
            </div>
        </form>
    </div>
</body>

</html>