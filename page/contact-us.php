<?php
include "../include/header.php";
require_once "../database/db.php";
?>


<h5 class="p-3 m-5 text-center alert alert-primary">برای سفارش پروژه و مشاوره در مورد برنامه نویسی با ما به تماس شوید.</h5>


<main class="mt-5 d-flex justify-content-around">

    <section class="col-3 border rounded shadow p-3">
        <span class="fa fa-volume-control-phone text-primary"></span>
        <span class="text-primary">شماره تماس و ایمیل</span>
        <hr>

        <div>
            <span class="fa fa-mobile"></span>
            <span>0093765066001</span>
        </div>

        <div>
            <span class="fa fa-inbox"></span>
            <span>Programmers@gmail.com</span>
        </div>
        <hr>
        <p class="text-center p-2">ما را در شبکه های اجتماعی دنبال کنید.</p>
        <div class="social-media text-center">
            <a href="#" class="fa fa-facebook-square"></a>
            <a href="#" class="fa fa-instagram"></a>
            <a href="#" class="fa fa-telegram"></a>
            <a href="#" class="fa fa-twitter"></a>
        </div>


    </section>

    <section class="col-7 border rounded shadow">
        <h5 class="text-center p-3">فورم تماس با ما</h5>
        <p class="alert alert-primary mx-5">در صورتیکه مشکل شما نیاز به پیگیری و پاسخ دارد لطفا از طریق این فورم با ما شریک سازید.</p>

        <form action="#" method="post" class="p-3">
            <div class="d-flex justify-content-around mb-3">
                <div class="col-5">
                    <label class="form-label">نام و نام خانوادگی</label>
                    <input type="text" name="fullname" class="form-control" placeholder="نام و نام خانوادگی">
                </div>
                <div class="col-5">
                    <label class="form-label">شماره تماس</label>
                    <input type="tel" name="phone" class="form-control text-start" placeholder="شماره تماس">
                </div>
            </div>
            <div class="col-11 mx-auto mb-3">
                <label class="form-label">ایمیل</label>
                <input type="email" name="email" class="form-control text-start" placeholder="ایمیل">
            </div>
            <div class="col-11 mx-auto mb-3">
                <label class="form-label">عنوان</label>
                <input type="text" name="title" class="form-control" placeholder="عنوان">
            </div>
            <div class="col-11 mx-auto mb-3">
                <label class="forml">توضیحات</label>
                <textarea name="description" rows="7" class="form-control" placeholder="توضیحات"></textarea>
            </div>

            <input type="submit" name="submit" value="ارسال" class="btn btn-primary col-4 offset-4">
        </form>
    </section>

</main>

<?php
include "../include/footer.php";
?>