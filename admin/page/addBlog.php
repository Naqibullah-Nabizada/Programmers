<?php
require_once "../../database/db.php";

if ($_SESSION['role'] == 0){
    header("location:../../index.php");
}

$query = $connect->prepare("SELECT id, CONCAT(firstname, ' ' ,lastname) AS fullName FROM teacher");
$query->execute();
$writers = $query->fetchAll(PDO::FETCH_OBJ);

if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $content = $_POST['content'];

    if(isset($_FILES['file'])){
        $name = $_FILES['file']['name'];
        $tmp =$_FILES['file']['tmp_name'];
        move_uploaded_file($tmp, "../../upload/blog_image/$name");
    }
    $image = $_FILES['file']['name'];
    $writer = $_POST['writer'];
    $date = time();

    $insert = $connect->prepare("INSERT INTO blog SET title=?, content=?, `image`=?, teacher_id=?, date=?");
    $insert->bindValue(1, $title);
    $insert->bindValue(2, $content);
    $insert->bindValue(3, $image);
    $insert->bindValue(4, $writer);
    $insert->bindValue(5, $date);
    $insert->execute();
    echo "<script> alert('بلاگ جدید موفقانه ثبت گردید') </script>";
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
    <title>اضافه نمودن بلاگ</title>
</head>

<body dir="rtl">
    
    <div class="container">
        <h3 class="text-center p-3">بلاگ جدید را اضافه کنید</h3>
        <form method="post" class="col-5 mx-auto d-grid" enctype="multipart/form-data">
            <label class="form-label">عنوان:</label>
            <input name="title" type="text" placeholder="عنوان" class="form-control mb-3" required>
            <label class="form-label">توضیحات:</label>
            <textarea name="content" cols="30" rows="5" placeholder="توضیحات" class="form-control mb-3" required></textarea>
            <label class="form-label">تصویر:</label>
            <input name="file" type="file" class="form-control mb-3" required>
            <label class="form-label">نویسنده</label>
            <select name="writer" class="form-control mb-3" required>
                <?php
                foreach ($writers as $writer) : ?>
                    <option value="<?= $writer->id ?>"> <?= $writer->fullName ?> </option>
                <?php endforeach ?>
            </select>
            <input name="submit" type="submit" value="ثبت" class="btn btn-success mb-2">
            <a href="../index.php" class="btn btn-secondary">بازگشت</a>
        </form>
    </div>
</body>
</html>