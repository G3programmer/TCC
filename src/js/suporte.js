document.addEventListener("DOMContentLoaded", function() {
    getComent();
});

function getComent() {
    //rever aqui
    fetch('read.php')


    .then(response => response.json())
    
    //Aqui vai para a página de histórico
    .then(data => {
        const comentList = document.getElementById('carros-lista');


        carList.innerHTML = '';
        data.forEach(relatorio => {

            const comentItem = document.createElement('div');
            comentItem.classList.add('car-item');
            comentItem.innerHTML = `
                <p><strong>ID:</strong> ${relatorio.id}</p>
                <p><strong>Título</strong> ${relatorio.titulo}</p>
                <p><strong>Descrição:</strong> ${relatorio.descricao}</p>
                <button class="btn edit-btn" onclick="editCar(${relatorio.id})">Editar</button>
            `;
            comentList.appendChild(comentItem);
        });
    });
}

function createOrUpdate() {
    const tituloInput = document.getElementById('titulo');
    const descricaoInput = document.getElementById('descricao');
    const relatorioIdInput = document.getElementById('relatorio-id'); // Campo oculto para ID do relatorio

    if (tituloInput && descricaoInput) {
        const titulo = tituloInput.value;
        const descricao = descricaoInput.value;
        const relatorioId = relatorioIdInput.value; // Obter o valor do ID do relatório

        const formData = new FormData();
        if (relatorioId) {
            formData.append('id', relatorioId);
        }
        formData.append('titulo', titulo);
        formData.append('descricao', descricao);
        
        // Dar uma olhada nesses phps aqui!!!

        fetch(relatorioId ? 'update.php' : 'create.php', { // Alterar URL com base no ID do carro
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                getComent();
                document.getElementById('relatorio-form').reset();
                relatorioIdInput.value = ''; // Limpar o campo de ID após atualização
            } else {
                alert('Ocorreu um erro ao salvar os dados.');
            }
        });
    } else {
        console.error("Um ou mais campos não foram encontrados.");
    }
}

//Pemanecera assim por enquanto, sem editar...

/*
function deleteCar(id) {
    fetch('delete.php', {
        method: 'POST',
        body: JSON.stringify({ id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            getCarros();
        } else {
            alert('Ocorreu um erro ao excluir o carro.');
        }
    });
}
*/
/*
function editCar(id) {
    fetch('get_car.php?id=' + id)
    .then(response => response.json())
    .then(car => {
        const marcaInput = document.getElementById('marca');
        const modeloInput = document.getElementById('modelo');
        const anoInput = document.getElementById('ano');
        const precoInput = document.getElementById('preco');
        const carIdInput = document.getElementById('car-id'); // Campo oculto para ID do carro

        marcaInput.value = car.marca;
        modeloInput.value = car.modelo;
        anoInput.value = car.ano;
        precoInput.value = car.preco;
        carIdInput.value = car.id; // Definir o ID do carro no campo oculto
    });
}
*/