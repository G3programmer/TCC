
    function scrollToSection(sectionId) {
        var section = document.getElementById(sectionId);
        if (section) {
            section.scrollIntoView({ behavior: 'smooth' });
        }
    }

    
    function toggleLista() {
        var lista = document.getElementById('vejaTambemLista');
        lista.classList.toggle('ativo');
    }



    