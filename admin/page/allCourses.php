<?php
require_once "../../database/db.php";
require_once "../../database/jdf.php";

if ($_SESSION['role'] == 0) {
    header("location:../../index.php");
}

if (isset($_REQUEST['del'])) {
    try {
        $query = $connect->prepare("DELETE FROM course WHERE id = ?");
        $query->bindValue(1, $_GET['del']);
        $query->execute();
        echo "<script> alert('دوره با موفقیت حذف شد') </script>";

    } catch (PDOException $e) {
        echo "<script> alert('حذف دوره انجام نشد') </script>";
    }
}

$select = $connect->prepare("SELECT course.id, title, content, `image`, `status`, `date`, CONCAT(firstname, ' ' ,lastname) AS teacher FROM course INNER JOIN teacher ON course.teacher_id = teacher.id ORDER BY id ASC");
$select->execute();
$courses = $select->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.rtl.css">
    <link rel="stylesheet" href="../../css/style.css">
    <title>دوره ها</title>
</head>

<body dir="rtl">
    <div class="container">
        <h2 class="text-center my-3">لیست دوره های برنامه نویسان</h2>
        <a href="../index.php" class="btn btn-secondary col-4 offset-4 my-2">بازگشت</a>
        <div class="row text-center">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>شناسه</th>
                        <th>عنوان</th>
                        <th>توضیحات</th>
                        <th>تصویر</th>
                        <th>مدرس</th>
                        <th>حالت</th>
                        <th>تاریخ</th>
                        <th>ویرایش</th>
                        <th>حذف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($courses as $course) : ?>
                        <tr>
                            <td> <?= $course->id ?> </td>
                            <td> <?= $course->title ?> </td>
                            <td> <?= substr($course->content, 0, 30) ?> </td>
                            <td> <?= $course->image ?> </td>
                            <td> <?= $course->teacher ?> </td>
                            <td> <?= $course->status ?> </td>
                            <td> <?= jdate("Y/m/d", $course->date) ?></td>
                            <td><a href="./updateCourse.php?id=<?= $course->id ?>" class="btn-sm btn-warning"> ویرایش </a></td>
                            <td><a href="./allCourses.php?del=<?= $course->id ?>" class="btn-sm btn-danger" onclick="return confirm('آیا مطمئن هستید؟')"> حذف </a></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>