// Elementos del DOM
const dropdownToggle = document.querySelector('.nav__list');
const dropdownMenu = document.querySelector('.nav__dropdown');
const arrowIcon = document.querySelector('.arrow');
const sidebar = document.getElementById('sidebar');
const nav_links = document.querySelectorAll('.nav__link__sidebar');
const header_icon = document.getElementById('header_icon');
const main = document.getElementById('main');
const header_title = document.getElementById('header_title');
// Funcionalidad del submenu
const submenuToggle = document.querySelector('.nav__link__submenu');
const submenu = document.querySelector('.submenu');

if (submenuToggle && submenu) {
    submenuToggle.addEventListener('click', () => {
        // Mostrar/ocultar el submenu
        submenu.classList.toggle('hidden');
        // Cambiar la dirección de la flecha
        const arrow = submenuToggle.querySelector('.arrow');
        arrow.textContent = arrow.textContent === 'keyboard_arrow_down' ? 'keyboard_arrow_up' : 'keyboard_arrow_down';
    });
}

// Funcionamiento del perfil
dropdownToggle.addEventListener('click', () => {
  if (dropdownMenu.classList.contains('open')) {
    // Cierra el menú
    dropdownMenu.style.height = '0';
    dropdownMenu.classList.remove('open');
    arrowIcon.classList.remove('rotate');
  } else {
    // Abre el menú
    dropdownMenu.style.height = `${dropdownMenu.scrollHeight}px`;
    dropdownMenu.classList.add('open');
    arrowIcon.classList.add('rotate');
  }
});

// Funcionamiento del sidebar
header_icon.addEventListener('click', () => {
  sidebar.classList.toggle('menu__toggle');
  main.classList.toggle('main__toggle');
});

// Restaurar el estado seleccionado al cargar la página
  const savedLink = localStorage.getItem('selectedLink');
  const savedTitle = localStorage.getItem('headerTitle');

  if (savedLink) {
    const activeLink = document.querySelector(`.nav__link__sidebar[href="${savedLink}"]`);
    if (activeLink) {
      activeLink.classList.add('selected');
    }
  }

  if (savedTitle) {
    header_title.textContent = savedTitle;
  }
  
// Añadir clase `selected` al enlace clickeado y actualizar el título
nav_links.forEach((nav_link) => {
  nav_link.addEventListener('click', (event) => {
    // Prevenir el comportamiento predeterminado
    event.preventDefault();

    // Remover `selected` de todos los enlaces
    nav_links.forEach((link) => link.classList.remove('selected'));

    // Añadir `selected` al enlace clickeado
    nav_link.classList.add('selected');

    // Actualizar el título en el header
    const title = nav_link.getAttribute('data-title');
    header_title.textContent = title;

    // Guardar el estado en localStorage
    localStorage.setItem('selectedLink', nav_link.getAttribute('href'));
    localStorage.setItem('headerTitle', title);

    window.location.href = nav_link.getAttribute('href');
  });
});