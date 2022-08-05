<?php
include "../include/header.php";
require_once "../database/db.php";

$select = $connect->prepare("SELECT blog.id, title, content, `image`, CONCAT(firstname, ' ' ,lastname) AS writer, `date` FROM blog INNER JOIN teacher ON blog.teacher_id = teacher.id");
$select->execute();
$blogs = $select->fetchAll(PDO::FETCH_OBJ);

?>


<h5 class="text-center alert alert-primary m-5 p-3">بلاگ های انتشار یافته سایت برنامه نویسان</h5>

<main style="overflow-x: hidden;">

    <section class="topics mt-5">
        <div class="row d-flex justify-content-center">

            <?php
            foreach ($blogs as $blog) : ?>
                <div class="card m-3" style="width: 30%;" onmouseover="mOver(this)" onmouseout="mOut(this)">
                    <a href="../page/singleBlog.php?id=<?= $blog->id ?>"><img src="../upload/blog_image/<?= $blog->image ?>" class="card-img-top w-100" alt="<?= $blog->title ?>"></a>
                    <div class="card-body">
                        <h6 class="card-title"> <?= $blog->title ?> </h6>
                        <p class="card-text text-muted" style="text-align: justify;"> <?= substr($blog->content, 0, 130) ?> <a href="../page/singleBlog.php?id=<?= $blog->id ?>">بیشتر...</a> </p>
                        <section class="teacherAndCom d-flex justify-content-between mt-3">

                            <?php
                            $view = $connect->prepare("SELECT COUNT(id) AS views FROM view WHERE blog_id = ?");
                            $view->bindValue(1, $blog->id);
                            $view->execute();
                            $countView = $view->fetch(PDO::FETCH_OBJ);
                            ?>
                            <div class="view text-muted">
                                <span class="fa fa-eye"></span>
                                <span><?= $countView->views?></span>
                            </div>

                            <div class="teacher">
                                <span class="fa fa-user text-muted"></span>
                                <span><a href=""><?= $blog->writer ?></a></span>
                            </div>

                        </section>
                    </div>
                </div>
            <?php endforeach ?>

        </div>
    </section>

</main>

<?php
include "../include/footer.php";
?>