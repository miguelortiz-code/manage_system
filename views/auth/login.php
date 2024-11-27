<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--GOOGLE FONTS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!--FAVICON-->
    <link rel="shortcut icon" href="/public/assets/images/favicon.ico" type="image/x-icon">
    <!--STYLES-->
    <link rel="stylesheet" href="/public/assets/css/login.css">
    <title>Login | Manage System</title>
</head>

<body>

    <?php include 'views/alerts/alerts.backend.php' ?>

    <div class="container">
        <form action="/login" method="post" class="container__form">
            <input type="hidden" name="csfr_token" value="<?php echo  htmlspecialchars(trim($_SESSION['csfr_token']), ENT_QUOTES, 'UTF-8') ?>">
            
            <h1 class="form__title">Inicio de sesión</h1>
            <div class="container__input">
                <label for="email" class="form__label">Correo electrónico</label>
                <img src="/public/assets/images/icons/user.svg" alt="icono de usuario" class="input__image">
                <input type="email" id="email" name="email" placeholder="Correo Electrónico" class="input__full">
            </div>

            <div class="container__input">
                <label for="password" class="form__label">Contraseña</label>
                <img src="/public/assets/images/icons/lock.svg" alt="icono de usuario" class="input__image">
                <input type="password" id="password" name="password" placeholder="Contraseña" class="input__full">
            </div>

            <div class="container__input container__input--submit">
                <img src="/public/assets/images/icons/login.svg" alt="icono de usuario" class="input__image input__image--submit">
                <input type="submit" name="submit" value="Ingresar" class="input__full input__full--submit">
            </div>
        </form>
        <a href="/recover-password" class="form__link">¿Olvidaste tu contraseña?</a>
    </div>
</body>

</html>