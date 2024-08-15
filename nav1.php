<!-- Header    -->
<header class="main-header d-flex justify-content-between bg-dark align-items-center fixed-top shadow ">
  <a class="brand bg-black text-white text-decoration-none d-block" href="">後台管理系統</a>
  <div class="d-flex align-items-center text-white text-md">
    Hi, Admin!
    <a class="btn btn-dark me-3" href="doLogout.php"><i class="fa-solid fa-right-from-bracket me-2 fa-fw"></i>登出</a>
  </div>
</header>
<!-- Sidebar -->
<aside class="side-navbar mt-5 d-block">
  <div class="side-navbar-inner">
    <ul class="list-unstyled mt-4">
      <li class="sidebar-item d-block"><a class="sidebar-link" href="#memberDropdown" data-bs-toggle="collapse"
          aria-expanded="false">
          <svg class="svg-icon svg-icon-sm svg-icon-heavy me-2">
            <use xlink:href="#sales-up-1"> </use>
          </svg>
          會員管理</a>
        <ul class="collapse list-unstyled " id="memberDropdown">
          <li><a class="sidebar-link" href="member-listed.html">會員列表</a></li>
          <li><a class="sidebar-link" href="addMember.html">新增會員</a></li>
        </ul>
      </li>
      <li class="sidebar-item"><a class="sidebar-link" href="#teacherDropdown" data-bs-toggle="collapse"
          aria-expanded="false">
          <svg class="svg-icon svg-icon-sm svg-icon-heavy me-2">
            <use xlink:href="#sales-up-1"> </use>
          </svg>師資管理 </a>
        <ul class="collapse list-unstyled " id="teacherDropdown">
          <li><a class="sidebar-link" href="#">師資列表</a></li>
        </ul>
      </li>
      <li class="sidebar-item"><a class="sidebar-link" href="#productDropdown" data-bs-toggle="collapse"
          aria-expanded="false">
          <svg class="svg-icon svg-icon-sm svg-icon-heavy me-2">
            <use xlink:href="#portfolio-grid-1"> </use>
          </svg>商品管理 </a>
        <ul class="collapse list-unstyled " id="productDropdown">
          <li><a class="sidebar-link" href="#">Bootstrap tables</a></li>
        </ul>
      </li>
      <li class="sidebar-item"><a class="sidebar-link" href="#categoryDropdown" data-bs-toggle="collapse"
          data-bs-parent="#accordion">
          <svg class="svg-icon svg-icon-sm svg-icon-heavy me-2">
            <use xlink:href="#portfolio-grid-1"> </use>
          </svg>類別管理 </a>
        <ul class="collapse list-unstyled " id="categoryDropdown">
          <li><a class="sidebar-link" href="#">Bootstrap tables</a></li>
        </ul>
      </li>
      <li class="sidebar-item"><a class="sidebar-link" href="#orderDropdown" data-bs-toggle="collapse">
          <svg class="svg-icon svg-icon-sm svg-icon-heavy me-2">
            <use xlink:href="#portfolio-grid-1"> </use>
          </svg>訂單管理 </a>
        <ul class="collapse list-unstyled " id="orderDropdown">
          <li><a class="sidebar-link" href="#">Bootstrap tables</a></li>
        </ul>
      </li>
      <li class="sidebar-item"><a class="sidebar-link" href="#discountDropdown" data-bs-toggle="collapse"
          data-bs-parent="#accordion">
          <svg class="svg-icon svg-icon-sm svg-icon-heavy me-2">
            <use xlink:href="#portfolio-grid-1"> </use>
          </svg>優惠管理 </a>
        <ul class="collapse list-unstyled " id="discountDropdown">
          <li><a class="sidebar-link" href="#">Bootstrap tables</a></li>
        </ul>
      </li>

      <li class="sidebar-item"><a class="sidebar-link" href="#articleDropdown" data-bs-toggle="collapse">
          <svg class="svg-icon svg-icon-sm svg-icon-heavy me-2">
            <use xlink:href="#portfolio-grid-1"> </use>
          </svg>文章管理 </a>
        <ul class="collapse list-unstyled " id="articleDropdown">
          <li><a class="sidebar-link" href="../article/article-list.php">文章列表</a></li>
          <li><a class="sidebar-link" href="../article/article-list.php">文章類型</a></li>
        </ul>
      </li>

      <li class="sidebar-item"><a class="sidebar-link" href="#eventDropdown" data-bs-toggle="collapse"
          data-bs-parent="#accordion">
          <svg class="svg-icon svg-icon-sm svg-icon-heavy me-2">
            <use xlink:href="#portfolio-grid-1"> </use>
          </svg>活動管理 </a>
        <ul class="collapse list-unstyled " id="eventDropdown">
          <li><a class="sidebar-link" href="../active/active.php">活動管理</a></li>
        </ul>
      </li>
    </ul>
  </div>
</aside>
</div>