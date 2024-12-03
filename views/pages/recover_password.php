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
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0" />
    <!--FAVICON-->
    <link rel="shortcut icon" href="/public/assets/images/favicon.ico" type="image/x-icon">
    <!--STYLES-->
    <link rel="stylesheet" href="/public/assets/css/recover_password.css">
    <link rel="stylesheet" href="/public/assets/css/alerts.css">
    <title>Recuperar Contraseña | Manage System</title>
</head>

<body>
    <?php include 'views/alerts/alerts.backend.php' ?>
    <div class="container">
        <form class="container__form" action="/recover-password" method="post">
            <h1 class="form__title">Recuperar contraseña</h1>
            <p class="form__description">
                Introduzca la dirección de correo electrónico asociada a su cuenta. Le enviaremos un enlace para
                restablecer su contraseña.
            </p>
            <div class="container__input">
                <label for="email" class="form__label">Dirección de correo electrónico</label>
                <input type="email" id="email" name="email" class="input__full"
                    placeholder="Ingresa tú correo electrónico">
                <span class="material-symbols-outlined input__icon">mail</span>
            </div>
            <div class="container__input">
                <input type="submit" class="input__full input__full--submit" value="Enviar enlace de reestablecimiento"
                    name="submit">
                <span class="material-symbols-outlined input__icon input__icon--submit">send</span>
            </div>
            <a href="/" class="form__link">Volver al inicio</a>
        </form>
    </div>
</body>

</html>