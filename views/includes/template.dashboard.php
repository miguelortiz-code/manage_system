<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Manage System </title>
    <link rel="stylesheet" href="/public/assets/css/login.css">
</head>

<body>
    <?php include 'views/alerts/alerts.backend.php'?>
    <header> <?php require 'views/includes/header.php' ?> </header>
    <aside> <?php require 'views/includes/sidebar.php' ?> </aside>

    <main>
        <?php if (isset($views)) {
            include $views;
        } else {
            echo "<p>Error: No se espefico una vista Válida</p>";
        }
        ?>
    </main>

    <footer> <?php require 'views/includes/footer.php' ?> </footer>

</body>

</html>