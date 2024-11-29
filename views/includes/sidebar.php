<aside class="sidebar" id="sidebar">
    <nav class="nav__sidebar">
        <ul class="mav__list">
            <li class="list__item">
                <a href="/dashboard" title="Inicio" class="nav__link nav__link__sidebar" data-title="Manage System">
                    <span class="material-symbols-outlined">home</span>
                    <span class="name__link title">manage system</span>
                </a>
            </li>

            <!--submenu-->
            <li class="list__item nav__link">
                <span class="material-symbols-outlined">group</span>
                <span class="name__link">usuarios</span>
                <span class="material-symbols-outlined arrow right">keyboard_arrow_down</span>
                <ul class="submenu hidden">
                    <li><a href="/users/admins" class="submenu__link">Administradores</a></li>
                    <li><a href="/users/editors" class="submenu__link">Editores</a></li>
                    <li><a href="/users/viewers" class="submenu__link">Espectadores</a></li>
                </ul>
            </li>
            <!--submenu-->


            <li class="list__item">
                <a href="/dashboard" title="Buscar" class="nav__link nav__link__sidebar" data-title="Buscar">
                    <span class="material-symbols-outlined">home</span>
                    <span class="name__link">usuarios</span>
                </a>
            </li>

            <li class="list__item">
                <a href="/settings" title="Configuración" class="nav__link nav__link__sidebar" data-title="Configuración">
                    <span class="material-symbols-outlined">settings</span>
                    <span class="name__link">configuracion</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>