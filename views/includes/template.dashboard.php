<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--GOOGLE FONTS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!--GOOGLE ICONS-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0"/>
    <!--FAVICON-->
    <link rel="shortcut icon" href="/public/assets/images/favicon.ico" type="image/x-icon">
    <!--STYLES-->
    <link rel="stylesheet" href="/public/assets/css/alerts.css">
    <link rel="stylesheet" href="/public/assets/css/dashboard.css">
    <title>Dashboard | Manage System</title>
</head>

<body>
    <?php include 'views/alerts/alerts.backend.php'?>
    <header> <?php require 'views/includes/header.php' ?> </header>
    <aside> <?php require 'views/includes/sidebar.php' ?> </aside>

    <main id="main" class="main">
        <?php if (isset($views)) {
            include $views;
        } else {
            echo "<p>Error: No se espefico una vista Válida</p>";
        }
        ?>
    </main>

    <footer> <?php require 'views/includes/footer.php' ?> </footer>


    <script src="/public/assets/js/dashboard.js"></script>
</body>

</html>