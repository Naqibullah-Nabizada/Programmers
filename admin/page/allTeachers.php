<?php
require_once "../../database/db.php";

if ($_SESSION['role'] == 0) {
    header("location:../../index.php");
}

if (isset($_REQUEST['del'])) {
    try {
        $query = $connect->prepare("DELETE FROM teacher WHERE id = ?");
        $query->bindValue(1, $_GET['del']);
        $query->execute();
        echo "<script> alert('مدرس با موفقیت حذف شد') </script>";
    } catch (PDOException $e) {
        echo "<script> alert('حذف مدرس انجام نشد') </script>";
    }
}

$select = $connect->prepare("SELECT * FROM teacher");
$select->execute();
$teachers = $select->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.rtl.css">
    <link rel="stylesheet" href="../../css/style.css">
    <title>مدرسین</title>
</head>

<body dir="rtl">
    <div class="container">

        <h2 class="text-center my-3">لیست مدرسین سایت برنامه نویسان</h2>
        <a href="../index.php" class="btn btn-secondary col-4 offset-4 my-2">بازگشت</a>
        <div class="row col-8 mx-auto text-center">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>شناسه</th>
                        <th>نام</th>
                        <th>نام خانوادگی</th>
                        <th>موبایل</th>
                        <th>ایمیل</th>
                        <th>ویرایش</th>
                        <th>حذف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($teachers as $teacher) : ?>
                        <tr>
                            <td> <?= $teacher->id ?> </td>
                            <td> <?= $teacher->firstname ?> </td>
                            <td> <?= $teacher->lastname ?> </td>
                            <td> <?= $teacher->phone ?> </td>
                            <td> <?= $teacher->email ?> </td>
                            <td><a href="#" class="btn btn-warning btn-sm">ویرایش</a></td>
                            <td><a href="./allTeachers.php?del=<?= $teacher->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('آیا از حذف مدرس مطمئن هستی؟')">حذف</a></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>