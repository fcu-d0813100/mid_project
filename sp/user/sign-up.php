<!-- sign-up -->
<!doctype html>
<html lang="en">

<head>
    <title>Create User</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../../css.php") ?>
</head>

<body>
    <div class="container">
        <h1>註冊帳號</h1>
        <div class="mb-2">
            <label class="form-label" for="name"><span class="text-danger">*</span>Account</label>
            <input type="text" class="form-control" id="account" required>
        </div>
        <div class="mb-2">
            <label class="form-label" for="name"><span class="text-danger">*</span>Password</label>
            <input type="password" class="form-control" id="password" required>
        </div>
        <div class="mb-2">
            <label class="form-label" for="name"><span class="text-danger">*</span>Re-type Password</label>
            <input type="password" class="form-control" id="repassword" required>
        </div>
        <div class="mb-2">
            <label class="form-label" for="name">Name</label>
            <input type="text" class="form-control" id="name">
        </div>
        <div class="mb-2">
            <label class="form-label" for="phone">Phone</label>
            <input type="tel" class="form-control" id="phone">
        </div>
        <div class="mb-2">
            <label class="form-label" for="email">Email</label>
            <input type="email" class="form-control" id="email">
        </div>
        <button class="btn btn-primary" type="button" id="send">送出</button>
    </div>
    <?php include("../js.php") ?>
    <script>
        const account = document.querySelector("#account");
        const password = document.querySelector("#password");
        const repassword = document.querySelector("#repassword");
        const name = document.querySelector("#name");
        const phone = document.querySelector("#phone");
        const email = document.querySelector("#email");
        const send = document.querySelector("#send");

        send.addEventListener("click", function() {
            let accountVal = account.value;
            let passwordVal = password.value;
            let repasswordVal = repassword.value;
            let nameVal = name.value;
            let phoneVal = phone.value;
            let emailVal = email.value;

            $.ajax({
                    method: "POST",
                    url: "/api/doCreateUser.php",
                    dataType: "json",
                    data: {
                        account: accountVal,
                        password: passwordVal,
                        repassword: repasswordVal,
                        name: nameVal,
                        phone: phoneVal,
                        email: emailVal,
                    } //如果需要
                })
                .done(function(response) {
                    // console.log(response);
                    let status = response.status;
                    if (status == 0) {
                        alert(response.message);
                        return;
                    }
                    // account.textContent = response.user.account;
                    // name.textContent = response.user.name;
                    // email.textContent = response.user.email;
                    // phone.textContent = response.user.phone;
                    if (status == 1) {
                        alert(response.message);
                        return;
                    }

                }).fail(function(jqXHR, textStatus) {
                    console.log("Request failed: " + textStatus);
                });
        })
    </script>
</body>


</html>