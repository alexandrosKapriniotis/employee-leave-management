<?php
use app\core\Application;
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $this->title ?></title>
    <link rel="stylesheet" href="../../css/styles.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../../css/main.css" />
</head>

<body>
<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div>
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                <ul id="sidebarnav">
                    <li>
                        <h4>
                            <?php echo Application::$app->user->getDisplayName() ?>
                        </h4>
                    </li>
                    <?php if (Application::$app->user->getUserType() === 'admin') { ?>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/users" aria-expanded="false">
                            <span>
                              <i class="ti ti-layout-dashboard"></i>
                            </span>
                                <span class="hide-menu">Users</span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (Application::$app->user->getUserType() === 'employee') { ?>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/applications" aria-expanded="false">
                            <span>
                              <i class="ti ti-layout-dashboard"></i>
                            </span>
                                <span class="hide-menu">Applications</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper mt-5">
        <!--  Content Start -->
        <div class="container">
            <?php if (Application::$app->session->getFlash('success')): ?>
                <div class="alert alert-success">
                    <?php echo Application::$app->session->getFlash('success'); ?>
                </div>
            <?php endif; ?>
            {{content}}
        </div>
        <!--  Content End -->
    </div>
</div>
<script src="../../libs/jquery/dist/jquery.min.js"></script>
<script src="../../libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>