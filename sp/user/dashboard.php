<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("location: sign-in.php");
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php include("../css.php") ?>
    <style>
        :root {
            --aside-width: 240px;
            --top-width: 72px;
        }


        .brand {
            width: var(--aside-width);
        }

        .left-aside {
            width: var(--aside-width);
            padding-top: var(--top-width);
        }

        .main-content {
            margin: var(--top-width) 0 0 var(--aside-width);
        }
    </style>
</head>

<body>
    <header class="main-header d-flex justify-content-between bg-dark align-items-center fixed-top shadow">
        <a class="brand p-3 bg-black text-white text-decoration-none" href="">Trivago</a>
        <div class="d-flex align-items-center">
            <div class="text-white me-3">
                hi, <?= $_SESSION["user"]["name"] ?>
                <!-- 登入時畫面能顯示使用者名稱 -->
            </div>
            <a class="btn btn-dark me-3" href="doLogout.php"><i class="fa-solid fa-right-from-bracket me-2 fa-fw"></i>Sign Out</a>
            <!-- 補上登出的那頁超連結 -->

        </div>
    </header>
    <aside class="left-aside bg-light border-end vh-100 position-fixed top-0 start-0 overflow-auto">
        <ul class="list-unstyled">
            <li>
                <a class="d-block px-3 py-2 text-decoration-none" href=""><i class="fa-solid fa-gauge me-2 fa-fw"></i>Dashboard
                </a>
            </li>
            <li>
                <a class="d-block px-3 py-2 text-decoration-none" href=""><i class="fa-solid fa-clipboard-list me-2 fa-fw"></i>Orders</a>
            </li>
            <li>
                <a class="d-block px-3 py-2 text-decoration-none" href=""><i class="fa-solid fa-cart-shopping me-2 fa-fw"></i>Products</a>
            </li>
            <li>
                <a class="d-block px-3 py-2 text-decoration-none" href=""><i class="fa-solid fa-users me-2 fa-fw"></i>Customers</a>
            </li>
            <li>
                <a class="d-block px-3 py-2 text-decoration-none" href=""><i class="fa-solid fa-chart-line me-2 fa-fw"></i>Reports</a>
            </li>
            <li>
                <a class="d-block px-3 py-2 text-decoration-none" href=""><i class="fa-solid fa-puzzle-piece me-2 fa-fw"></i>Intergrations</a>
            </li>
        </ul>
        <div class="d-flex justify-content-between px-3 align-items-center">
            <small class="text-muted">SAVED REPORTS</small>
            <a role="button">
                <i class="fa-solid fa-circle-plus fa-fw"></i>
            </a>
        </div>
        <ul class="list-unstyled">
            <li>
                <a class="d-block px-3 py-2 text-decoration-none" href="">
                    <i class="fa-regular fa-file me-2 fa-fw"></i>Current Month
                </a>
            </li>
            <li>
                <a class="d-block px-3 py-2 text-decoration-none" href="">
                    <i class="fa-regular fa-file me-2 fa-fw"></i>Last Quater
                </a>
            </li>
            <li>
                <a class="d-block px-3 py-2 text-decoration-none" href="">
                    <i class="fa-regular fa-file me-2 fa-fw"></i>Social Engagement
                </a>
            </li>
            <li>
                <a class="d-block px-3 py-2 text-decoration-none" href="">
                    <i class="fa-regular fa-file me-2 fa-fw"></i>Year-end Sale
                </a>
            </li>
        </ul>
        <hr>
        <ul class="list-unstyled">
            <li>
                <a class="d-block px-3 py-2 text-decoration-none" href="">
                    <i class="fa-solid fa-gear me-2 fa-fw"></i>Settings
                </a>
            </li>
            <li>
                <a class="d-block px-3 py-2 text-decoration-none" href="doLogout.php">
                    <!-- 補上登出的那頁 -->
                    <i class="fa-solid fa-right-from-bracket me-2 fa-fw"></i>Sign Out
                </a>
            </li>
        </ul>
    </aside>
    <main class="main-content px-3 pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="m-0">Dashboard</h1>
            <div>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-secondary">Share</button><button class="btn btn-outline-secondary">Export</button>
                </div>
                <button class="btn btn-outline-secondary btn-sm">
                    <i class="fa-regular fa-calendar-days fa-fw me-2"></i>This Week
                </button>
            </div>
        </div>
        <hr>
        <h2>Section title</h2>
        <div class="table-responsive small">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Header</th>
                        <th scope="col">Header</th>
                        <th scope="col">Header</th>
                        <th scope="col">Header</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1,001</td>
                        <td>random</td>
                        <td>data</td>
                        <td>placeholder</td>
                        <td>text</td>
                    </tr>
                    <tr>
                        <td>1,002</td>
                        <td>placeholder</td>
                        <td>irrelevant</td>
                        <td>visual</td>
                        <td>layout</td>
                    </tr>
                    <tr>
                        <td>1,003</td>
                        <td>data</td>
                        <td>rich</td>
                        <td>dashboard</td>
                        <td>tabular</td>
                    </tr>
                    <tr>
                        <td>1,003</td>
                        <td>information</td>
                        <td>placeholder</td>
                        <td>illustrative</td>
                        <td>data</td>
                    </tr>
                    <tr>
                        <td>1,004</td>
                        <td>text</td>
                        <td>random</td>
                        <td>layout</td>
                        <td>dashboard</td>
                    </tr>
                    <tr>
                        <td>1,005</td>
                        <td>dashboard</td>
                        <td>irrelevant</td>
                        <td>text</td>
                        <td>placeholder</td>
                    </tr>
                    <tr>
                        <td>1,006</td>
                        <td>dashboard</td>
                        <td>illustrative</td>
                        <td>rich</td>
                        <td>data</td>
                    </tr>
                    <tr>
                        <td>1,007</td>
                        <td>placeholder</td>
                        <td>tabular</td>
                        <td>information</td>
                        <td>irrelevant</td>
                    </tr>
                    <tr>
                        <td>1,008</td>
                        <td>random</td>
                        <td>data</td>
                        <td>placeholder</td>
                        <td>text</td>
                    </tr>
                    <tr>
                        <td>1,009</td>
                        <td>placeholder</td>
                        <td>irrelevant</td>
                        <td>visual</td>
                        <td>layout</td>
                    </tr>
                    <tr>
                        <td>1,010</td>
                        <td>data</td>
                        <td>rich</td>
                        <td>dashboard</td>
                        <td>tabular</td>
                    </tr>
                    <tr>
                        <td>1,011</td>
                        <td>information</td>
                        <td>placeholder</td>
                        <td>illustrative</td>
                        <td>data</td>
                    </tr>
                    <tr>
                        <td>1,012</td>
                        <td>text</td>
                        <td>placeholder</td>
                        <td>layout</td>
                        <td>dashboard</td>
                    </tr>
                    <tr>
                        <td>1,013</td>
                        <td>dashboard</td>
                        <td>irrelevant</td>
                        <td>text</td>
                        <td>visual</td>
                    </tr>
                    <tr>
                        <td>1,014</td>
                        <td>dashboard</td>
                        <td>illustrative</td>
                        <td>rich</td>
                        <td>data</td>
                    </tr>
                    <tr>
                        <td>1,015</td>
                        <td>random</td>
                        <td>tabular</td>
                        <td>information</td>
                        <td>text</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>