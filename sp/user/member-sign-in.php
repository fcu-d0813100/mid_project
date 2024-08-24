<!doctype html>
<html lang="en">

<head>
    <title>LOGIN</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- 字體 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">

    <?php
    include("css.php");
    ?>
    <style>
        body {
            background: url(./login_bg/07.jpg) center center;
            background-size: cover;
        }


        nav {
            height: 100px;
            width: 100%;
            background-color: #111111;

        }

        footer {
            height: 100px;
            width: 100%;
            background-color: #111111;
        }

        .login-text {
            font-family: "DM Serif Display", serif;
            font-weight: 400;
            font-style: normal;
            font-size: 75px;
            margin-bottom: 30px;
            text-align: center;
        }

        .bg-light {
            --bs-bg-opacity: .9;
        }

        .sign-in-panel {
            width: 350px;
        }


        .input-area {


            .form-floating:first-child {
                .form-control {
                    border-bottom-left-radius: 0;
                    border-bottom-right-radius: 0;
                }
            }

            .form-floating:last-child {
                .form-control {
                    border-top-left-radius: 0;
                    border-top-right-radius: 0;
                    position: relative;
                    top: -1px;
                }
            }

            .form-control:focus {
                position: relative;
                z-index: 1;
            }
        }
    </style>
</head>

<body>


    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="bg-light p-5 rounded-4 shadow">

            <div class="sign-in-panel mt-3 mb-5">

                <?php if (isset($_SESSION["error"]["times"]) && $_SESSION["error"]["times"] > 5) : ?>
                    輸入錯誤次數多次，請稍後再嘗試登入
                <?php else : ?>
                    <h1 class="login-text">LOGIN</h1>
                    <form action="doLogin-member.php" method="post">
                        <div class="input-area">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="account">
                                <label for="floatingInput">帳號</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                                <label for="floatingPassword">密碼</label>
                            </div>
                        </div>
                        <?php if (isset($_SESSION["error"]["message"])) : ?>
                            <div class="text-danger">
                                <?= $_SESSION["error"]["message"] ?>
                            </div>
                        <?php
                            unset($_SESSION["error"]["message"]);
                        endif; ?>
                        <div class="form-check my-3">
                            <input class="form-check-input" type="checkbox" value="" id="remember">
                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-dark py-2">登入</button>
                        </div>

                    <?php

                    unset($_SESSION["error"]["message"]);
                endif; ?>


                    </form>
                    <hr>
                    <h6>還沒有帳號?</h6>

                    <div class="d-grid">
                        <a class="btn btn-dark" href="create-user.php">立即註冊</a>
                    </div>
            </div>





            <div class="mt-3 text-muted">
                © 2010-2024 Makeup

            </div>
        </div>
    </div>




    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>