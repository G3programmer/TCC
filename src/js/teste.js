const menu = document.getElementById('menu');
const OpenMenu = document.getElementById('OpenMenu');
const CloseMenu = document.getElementById('CloseMenu');

OpenMenu.addEventListener('click', () => {
    menu.classList.add('active');

    menu.style.display = 'flex';
    OpenMenu.style.display = 'none';

    setTimeout(() => {
        menu.style.opacity = '1';
    }, 10);
});

CloseMenu.addEventListener('click', () => {
    menu.classList.remove('active');

    setTimeout(() => {
        menu.removeAttribute('style');
        OpenMenu.removeAttribute('style');
    }, 200);

    menu.style.opacity = '0';
});
