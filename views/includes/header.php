<?php
// Obtener la imagen del usuario o usar la predeterminada
$userImage = isset($_SESSION['image_user']) ? htmlspecialchars($_SESSION['image_user'], ENT_QUOTES, 'UTF-8') : '/public/assets/images/profile.png';
$userName = isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8') : 'Usuario';
?>


<header class="header">
    <div class="container__header">
        <span class="material-symbols-outlined header__icon" id="header_icon">menu</span>

        <h3 class="header__title" id="header_title"></h3>

        <nav class="header__nav">
            <ul class="nav_item">
                <li class="nav__list" id="nav__list">
                    <img src="<?php echo $userImage ?>" alt="imagen de usuario" class="header__profile">

                    <ul class="nav__dropdown" id="nav__dropdown">

                        <li class="list__dropdown list__dropdown--profile ">
                            <img src="<?php echo $userImage ?>" alt="imagen de usuario" class="header__profile">
                            <p class="header__name"><?php echo $userName ?></p>
                        </li>

                        <span class="line__dropdown"></span>

                        <li class="list__dropdown">
                            <a href="/profile" class="nav__link nav__link__dropdown nav__link__sidebar"
                                data-title="Mi perfil">
                                <span class="material-symbols-outlined dropdown__icon">person</span>
                                <span class="link__name">ver perfil</span>
                            </a>
                        </li>

                        <li class="list__dropdown list__dropdown--logout">
                            <a href="/logout" class="nav__link nav__link__dropdown logout">
                                <span class="material-symbols-outlined dropdown__icon">logout</span>
                                <span class="link__name">cerrar sesión</span>
                            </a>
                        </li>

                    </ul>
                </li>
            </ul>
        </nav>
</header>