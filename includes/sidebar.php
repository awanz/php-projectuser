<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" width="50px" height="50px" src="https://adminlte.io/themes/dev/AdminLTE/dist/img/user2-160x160.jpg" alt="User Image">
    <div>
      <p class="app-sidebar__user-designation"><small>Selamat datang,</small></p>
      <p class="app-sidebar__user-name"><?= $_SESSION['username'] ?></p>
    </div>
  </div>
  <ul class="app-menu">
    <li><a class="app-menu__item" href="<?= base_url("dashboard.php") ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
    <li><a class="app-menu__item" href="<?= base_url("profile") ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Change Profile</span></a></li>
    <li><a class="app-menu__item" href="<?= base_url("data") ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Data</span></a></li>
    <?php if ($_SESSION['level'] == 2) { ?>
    <li><a class="app-menu__item" href="<?= base_url("users") ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Users</span></a></li>
    <?php } ?>
  </ul>
</aside>