<!-- sign-in-ajax.php -->
<?php
session_start();

if (isset($_SESSION["user"])) {
    header("location: users.php");
    exit;
}

?>
<!doctype html>
<html lang="en">

<head>
    <title>Sign in</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php
    include("css.php");
    ?>
    <style>
        body {
            background: url("/images/bg.jpg") center center/cover;
        }

        .sign-in-panel {
            width: 280px;
        }

        .logo {
            height: 64px;
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
        <div class="sign-in-panel">
            <img class="logo mb-3" src="/assets/images/site-logo.png" alt="">
            <?php if (isset($_SESSION["error"]["times"]) && $_SESSION["error"]["times"] == 6) : ?>
                輸入錯誤次數太多, 請稍後再嘗試登入
            <?php else : ?>
                <h1 class="h2">Please sign in</h1>
                <div class="input-area">
                    <div class="form-floating">
                        <input type="text" class="form-control" placeholder="name@example.com" id="account">
                        <label for="floatingInput">帳號</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="password" placeholder="Password">
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
                    <button class="btn btn-primary" type="submit" id="signIn">登入</button>
                </div>
            <?php endif; ?>
            <div class="mt-4 text-muted">
                © 2017–2024
            </div>
        </div>
    </div>

    <?php include("../js.php"); ?>
    <script>
        const account = document.querySelector("#account")
        const password = document.querySelector("#password")
        const signIn = document.querySelector("#signIn")

        signIn.addEventListener("click", function() {
            let accountVal = account.value;
            let passwordVal = password.value;
            // console.log(accountVal, passwordVal);
            $.ajax({
                    method: "POST",
                    url: "/api/doLogin.php",
                    dataType: "json",
                    data: {
                        account: accountVal,
                        password: passwordVal,
                    } //如果需要
                })
                .done(function(response) {
                    console.log(response);
                    let status = response.status;
                    if (status == 0) {
                        alert(response.message)
                        return;
                    }
                    if (status == 2) {
                        alert(response.message);
                        if (response.remains <= 0) {
                            location.reload();
                        }

                        return;
                    }
                    if (status == 1) {
                        alert(response.message);
                        location.href = "users.php"
                        return;
                    }


                }).fail(function(jqXHR, textStatus) {
                    console.log("Request failed: " + textStatus);
                });
        })
    </script>

</body>

</html>