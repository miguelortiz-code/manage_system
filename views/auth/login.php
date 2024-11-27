<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/public/assets/images/favicon.ico" type="image/x-icon">
    <title>Login | Manage System</title>
</head>
<body>

    <?php include 'views/alerts/alerts.backend.php' ?>

    <form action="/login" method="post">
        <h1>Login</h1>
        <input type="hidden" name="csfr_token" value="<?php echo  htmlspecialchars(trim($_SESSION['csfr_token']), ENT_QUOTES, 'UTF-8') ?>">
        <input type="email" id="email" name="email" placeholder="Correo Electrónico">
        <input type="password" id="password" name="password" placeholder="Contraseña">
        <input type="submit" name="submit" value="Iniciar sesion">
        <p>¿Olvidaste tu contraseña?</p><a href="/recover-password">Recuperala aquí</a>
    </form>
</body>
</html>