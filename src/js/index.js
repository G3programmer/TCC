
OpenMenu.addEventListener('click', () => {
    menu.style.display = 'flex'
    menu.style.right = (menu.offsetWidth * -1) + 'px'
    OpenMenu.style.display = 'none'

    document.body.style.overflow = 'hidden';

    setTimeout(() => {
        menu.style.opacity = '1';

        menu.style.right = '0';
    }, 10);
});

CloseMenu.addEventListener('click', () => {
    setTimeout(() => {
        menu.removeAttribute('style')
        OpenMenu.removeAttribute('style')
        document.body.style.overflow = 'auto';
    }, 200);
    menu.style.opacity = '0';
    menu.style.right = (menu.offsetWidth * -1) + 'px'
})