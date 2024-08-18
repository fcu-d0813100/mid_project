<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
    <style>
        body {
            background-color: #f8f9ff;
        }

        .pagination {
            height: 50px;
            margin: 30px;
            box-shadow: 0 16px 32px rgba(90, 100, 130, 0.1);
            border-radius: 8px;
            background-color: #fff;
        }

        .pagination li {
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.3s;
            /* background-color: skyblue; */
        }

        .pagination li .page-btn {
            /* 默認不可點擊 */
            color: #e0e0e0;
        }

        /* 可點擊 */
        .pagination li .page-btn.isClick {
            color: black;
            cursor: pointer;
        }

        .pagination li .page-btn.isClick:hover {
            color: #fff;
            background-color: lightpink;
        }
    </style>
</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main></main>

    <div>
        <ul class="pagination d-flex justify-content-center align-items-center">
            <li class="m-2 d-flex justify-content-center align-items-center page-btn page-btn-prev">
                <
                    <li class="m-2 d-flex justify-content-center align-items-center page-number">1
            </li>

            <li class="m-2 d-flex justify-content-center align-items-center page-dot-prev">...</li>
            <li class="m-2 page-number">2</li>
            <li class="m-2 page-number">3</li>
            <li class="m-2 page-number">4</li>

            <li class="m-2 page-dot-next">...</li>
            <li class="m-2 page-number">5</li>
            <li class="m-2 page-btn page-btn-next ">></li>

        </ul>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>

    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <script>

    </script>
</body>

</html>