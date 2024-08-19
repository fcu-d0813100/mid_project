<!doctype html>
<html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>

    <body>
    <table class="table">
    <thead>
        <tr>
            <th><button onclick="sortTable(0)">編號</button></th>
            <th>品牌</th>
            <th>類型</th>
            <th>標題</th>
            <th>圖片</th>
            <th><button onclick="sortTable(5)">發布時間</button></th>
        </tr>
    </thead>
    <tbody id="table-body">
        <tr>
            <td>1</td>
            <td>Brand 1</td>
            <td>Type 1</td>
            <td>Title 1</td>
            <td><img src="image1.jpg" alt="image"></td>
            <td>2022-09-13</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Brand 2</td>
            <td>Type 2</td>
            <td>Title 2</td>
            <td><img src="image2.jpg" alt="image"></td>
            <td>2023-03-25</td>
        </tr>
    </tbody>
</table>


        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

       <script>
var currentSortColumn = -1;
var sortDirection = "desc"; // 默認排序方向為降序

function sortTable(columnIndex) {
    const table = document.getElementById("table-body");
    const rows = Array.from(table.rows); // 將 HTMLCollection 轉換為數組

    // 如果點擊了相同的列，切換排序方向
    if (currentSortColumn === columnIndex) {
        sortDirection = sortDirection === "asc" ? "desc" : "asc";
    } else {
        sortDirection = "desc"; // 如果點擊了另一列，重置為降序
        currentSortColumn = columnIndex; // 更新當前排序列
    }

    // 根據選擇的列對行進行排序
    rows.sort((rowA, rowB) => {
        const cellA = rowA.cells[columnIndex].innerHTML;
        const cellB = rowB.cells[columnIndex].innerHTML;

        // 根據列類型確定排序邏輯
        if (columnIndex === 5) { // 日期列
            return sortDirection === "asc"
                ? new Date(cellA) - new Date(cellB)
                : new Date(cellB) - new Date(cellA);
        } else if (!isNaN(cellA) && !isNaN(cellB)) { // 數字列
            return sortDirection === "asc"
                ? Number(cellA) - Number(cellB)
                : Number(cellB) - Number(cellA);
        } else { // 字符串列
            return sortDirection === "asc"
                ? cellA.localeCompare(cellB)
                : cellB.localeCompare(cellA);
        }
    });

    // 清除現有行並附加排序後的行
    while (table.firstChild) {
        table.removeChild(table.firstChild);
    }
    rows.forEach(row => table.appendChild(row));
}


       </script>
    </body>
</html>
