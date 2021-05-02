<header class="app-header">
    <a class="app-header__logo" href="<?= base_url(); ?>">Project User</a>
    <!-- Sidebar toggle button-->
    <?php if (!empty($_SESSION)) { if ($_SESSION['login'] == "masuk") { ?>
    <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <?php }} ?>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">
    <!--Notification Menu-->
    
    <!-- User Menu-->
    <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
        <ul class="dropdown-menu settings-menu dropdown-menu-right">
        <?php if (!empty($_SESSION)) { if ($_SESSION['login'] == "masuk") { ?>
        <li><a class="dropdown-item" href="<?= base_url("logout.php"); ?>"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
        <?php  } }else{ ?>
            <li><a class="dropdown-item" href="<?= base_url("login.php"); ?>"><i class="fa fa-sign-out fa-lg"></i> Login</a></li>
        <?php } ?>
        </ul>
    </li>
    </ul>
</header>