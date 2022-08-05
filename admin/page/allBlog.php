<?php
require_once "../../database/db.php";
require_once "../../database/jdf.php";

if ($_SESSION['role'] == 0) {
    header("location:../../index.php");
}

if (isset($_REQUEST['del'])) {
    try {
        $query = $connect->prepare("DELETE FROM blog WHERE id = ?");
        $query->bindValue(1, $_GET['del']);
        $query->execute();
        echo "<script> alert('دوره با موفقیت حذف شد') </script>";
    } catch (PDOException $e) {
        echo "<script> alert('دوره حذف نشد') </script>";
    }
}

$select = $connect->prepare("SELECT blog.id, title, content, `image`, `date`, CONCAT(firstname, ' ' ,lastname) AS teacher FROM blog INNER JOIN teacher ON blog.teacher_id = teacher.id ORDER BY id ASC");
$select->execute();
$blogs = $select->fetchAll(PDO::FETCH_OBJ);
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
                        <th>نویسنده</th>
                        <th>تاریخ</th>
                        <th>ویرایش</th>
                        <th>حذف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($blogs as $blog) : ?>
                        <tr>
                            <td> <?= $blog->id ?> </td>
                            <td> <?= $blog->title ?> </td>
                            <td> <?= substr($blog->content, 0, 30) ?> </td>
                            <td> <?= $blog->image ?> </td>
                            <td> <?= $blog->teacher ?> </td>
                            <td> <?= jdate("Y/m/d", $blog->date) ?></td>
                            <td><a href="./updateBlog.php?id=<?= $blog->id ?>" class="btn-sm btn-warning"> ویرایش </a></td>
                            <td><a href="./allBlog.php?del=<?= $blog->id ?>" class="btn-sm btn-danger" onclick="return confirm('آیا مطمئن هستید؟')"> حذف </a></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>