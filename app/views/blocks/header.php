<!-- Navbar -->

<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo WEB_ROOT; ?>/trang-chu">Trang chủ</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="javascript:void(0)">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="javascript:void(0)">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="javascript:void(0)">Link</a>
        </li>
      </ul>
      <form method="post" action="<?php echo WEB_ROOT; ?>/product/list_product" class="d-flex">
        <input class="form-control me-2" type="text" placeholder="Search" name="search_value">
        <button class="btn btn-primary" type="submit">Search</button>
      </form>
      <?php
      if (!empty($username_user)) {
        echo "
        <a class='btn btn-secondary' href='" . WEB_ROOT . "/authentication/logout'>Đăng xuất</a>;
        <span style='color:white'>Xin chào " . (!empty($username_user) ? $username_user : '') . "</span>
        ";
      } else {
        echo "<a class='btn btn-secondary' href='" . WEB_ROOT . "/authentication/login'>Đăng nhập</a>";
        echo "<a class='btn btn-secondary' href='" . WEB_ROOT . "/authentication/register'>Đăng ký</a>";
      }
      ?>
      <a class="btn btn-danger" href="<?php echo WEB_ROOT; ?>/cart/index">Giỏ hàng[{{isset($quantity) ? $quantity : 0}}]</a>


    </div>
  </div>
</nav>

<!-- End Navbar -->