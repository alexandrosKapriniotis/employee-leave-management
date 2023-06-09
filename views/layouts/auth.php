<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $this->title ?></title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="../../css/styles.min.css" />
    <link rel="stylesheet" href="../../css/main.css" />
</head>

<body>

<div class="page-wrapper radial-gradient d-flex min-vh-100 align-items-center auth" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed">
    <!--  Main wrapper -->
    <!--  Content Start -->
    {{content}}
    <!--  Content End -->
</div>
<script src="../../libs/jquery/dist/jquery.min.js"></script>
<script src="../../libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>