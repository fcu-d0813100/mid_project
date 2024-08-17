<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>搜尋範例</title>
</head>
<body>
    <h1>搜尋範例</h1>
    <input type="text" id="searchInput" placeholder="搜尋..." onkeyup="searchFunction()">
    <ul id="itemList">
        <li>Apple</li>
        <li>Banana</li>
        <li>Cherry</li>
        <li>Durian</li>
        <li>Elderberry</li>
    </ul>

    <script src="search.js"></script>
    <script>
        function searchFunction() {
    // 獲取輸入框和列表元素
    let input = document.getElementById('searchInput');
    let filter = input.value.toUpperCase();
    let ul = document.getElementById("itemList");
    let li = ul.getElementsByTagName('li');

    // 遍歷所有的列表項目，匹配搜尋關鍵字
    for (let i = 0; i < li.length; i++) {
        let txtValue = li[i].textContent || li[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

    </script>
</body>
</html>
