<?php
require_once "../../database/db.php";

if ($_SESSION['role'] == 0) {
    header("location:../../index.php");
}

$query = $connect->prepare("SELECT id, CONCAT(firstname, ' ' ,lastname) AS teacher FROM teacher");
$query->execute();
$teachers = $query->fetchAll(PDO::FETCH_OBJ);

$select = $connect->prepare("SELECT * FROM blog WHERE id = ?");
$select->bindValue(1, $_GET['id']);
$select->execute();
$blog = $select->fetch(PDO::FETCH_OBJ);


if (isset($_POST['update'])) {

    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = '';

    if (isset($_FILES['file'])) {
        $name = $_FILES['file']['name'];
        $tmp = $_FILES['file']['tmp_name'];
        unlink("../../upload/blog_image/$blog->image");
        move_uploaded_file($tmp, "../../upload/blog_image/$name");
        $image = $_FILES['file']['name'];
    }

    $teacher = $_POST['teacher'];
    $date = time();

    $insert = $connect->prepare("UPDATE blog SET title=?, content=?, `image`=?, teacher_id=?, `date`=? WHERE id = ?");
    $insert->bindValue(1, $title);
    $insert->bindValue(2, $content);
    $insert->bindValue(3, $image);
    $insert->bindValue(4, $teacher);
    $insert->bindValue(5, $date);
    $insert->bindValue(6, $_GET['id']);
    $insert->execute();
    header("location:allBlog.php");
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
            <input name="title" type="text" value="<?= $blog->title ?>" placeholder="دوره" class="form-control mb-2" autofocus required>
            <label class="form-label">توضیحات:</label>
            <textarea name="content" cols="30" rows="4" placeholder="توضیحات" class="form-control mb-2"><?= $blog->content ?></textarea>
            <label class="form-label">تصویر:</label>
            <input name="file" type="file" class="form-control mb-2">
            <img src="../../upload/course_image/<?= $blog->image ?>" class="img-fluid w-25 d-block">
            <label class="form-label">نویسنده:</label>
            <select name="teacher" class="form-control mb-2">
                <?php
                foreach ($teachers as $teacher) : ?>
                    <option value="<?= $teacher->id ?>" <?php if ($blog->teacher_id == $teacher->id) { ?> selected <?php } ?>> <?= $teacher->teacher ?> </option>
                <?php endforeach; ?>
                ?>
            </select>

            <div class="d-grid">
                <input name="update" type="submit" value="ویرایش" class="btn btn-warning mb-2">
                <a href="../index.php" class="btn btn-secondary">بازگشت</a>
            </div>
        </form>
    </div>
</body>

</html>