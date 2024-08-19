function search() {
  const input = document.querySelector(".searchInput");
  const filter = input.value.toLowerCase();
  const filteredRows = rows.filter(row => row.title.toLowerCase().includes(filter));
  totalPages = Math.ceil(filteredRows.length / rowsPerPage);
  currentPage = 1;  // 搜尋後重置到第一頁
  displayPage(currentPage, filteredRows);
}

function displayPage(page, filteredRows = rows) {
  const start = (page - 1) * rowsPerPage;
  const end = start + rowsPerPage;
  const paginatedItems = filteredRows.slice(start, end);

  const tbody = document.querySelector("tbody");
  tbody.innerHTML = ""; // 清空现有行

  paginatedItems.forEach(row => {
      const tr = document.createElement("tr");
      tr.classList.add("align-middle", "dataList");
      tr.innerHTML = `
      <td>${row.id}</td>
      <td>${row.brand_name}</td>
      <td>${row.type_name}</td>
      <td class="article-title">${row.title}</td>
      <td class="ratio ratio-4x3"><img class="object-fit-cover img-fluid" src="/images/batman.webp" alt=""></td>
      <td>${row.launched_date}</td>
      <td class="gap-3">
        <a href="article-review.php?id=${row.id}" class="btn btn-outline-secondary btn-md"><i class="fa-regular fa-eye"></i></a>
        <a href="article-edit.php?id=${row.id}" class="btn btn-outline-secondary btn-md"><i class="fa-regular fa-pen-to-square"></i></a>
        <a href="doDeleteArticle.php?id=${row.id}" class="btn btn-outline-secondary btn-md"><i class="fa-regular fa-trash-can"></i></a>
      </td>
    `;
      tbody.appendChild(tr);
  });

  renderPagination(filteredRows);
}

function renderPagination(filteredRows = rows) {
  const pagination = document.getElementById("pagination");
  pagination.innerHTML = ""; // 清空现有分页

  for (let i = 1; i <= totalPages; i++) {
      const li = document.createElement("li");
      li.classList.add("page-item");
      li.innerHTML = `<a class="page-link" href="#" onclick="changePage(${i}, ${JSON.stringify(filteredRows)})">${i}</a>`;
      pagination.appendChild(li);
  }
}

function changePage(page, filteredRows = rows) {
  currentPage = page;
  displayPage(currentPage, filteredRows);
}

// 初始化显示第一页
displayPage(currentPage);
