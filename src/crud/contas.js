document.addEventListener("DOMContentLoaded", function () {
    getUser();
});

function getUser() {
    fetch('read.php')
        .then(response => response.json())
        .then(data => {
            const userList = document.getElementById('lista-usuario');
            userList.innerHTML = '';
            data.forEach(usuario => {
                const userItem = document.createElement('div');
                userItem.classList.add('user-item');
                userItem.innerHTML = `
                <p><strong>ID:</strong> ${user.id}</p>
                <p><strong>Nome:</strong> ${user.nome}</p>
                <p><strong>Email:</strong> ${user.email}</p>
                <p><strong>Senha:</strong> ${user.senha}</p>
                <p><strong>CPF:</strong> R$${user.cpf}</p>
                <p><strong>Foto:</strong> R$${user.foto}</p>
                <button class="btn delete-btn" onclick="deleteUser(${user.id})">Excluir</button>
                <button class="btn edit-btn" onclick="editUser(${user.id})">Editar</button>
            `;
                userList.appendChild(userItem);
            });
        });
}

function createOrUpdate() {
    const nomeInput = document.getElementById('nome');
    const emailInput = document.getElementById('email');
    const senhaInput = document.getElementById('senha');
    const cpfInput = document.getElementById('cpf');
    const fotoInput = document.getElementById('foto');
    const userIdInput = document.getElementById('user-id'); // Campo oculto para ID do carro

    if (nomeInput && emailInput && senhaInput && cpfInput) {
        const nome = nomeInput.value;
        const email = emailInput.value;
        const senha = senhaInput.value;
        const cpf = cpfInput.value;
        const foto = fotoInput.value;
        const userId = userIdInput.value; // Obter o valor do ID do carro

        const formData = new FormData();
        if (userId) {
            formData.append('id', userId);
        }
        formData.append('nome', nome);
        formData.append('email', email);
        formData.append('senha', senha);
        formData.append('cpf', cpf);
        formData.append('foto', foto);

        fetch(userId ? 'atualiza.php' : 'registro.php', { // Alterar URL com base no ID do carro
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    getUser();
                    document.getElementById('crud-form').reset();
                    userIdInput.value = ''; // Limpar o campo de ID após atualização
                } else {
                    alert('Ocorreu um erro ao salvar os dados.');
                }
            });
    } else {
        console.error("Um ou mais campos não foram encontrados.");
    }
}

function deleteUser(id) {
    fetch('delete.php', {
        method: 'POST',
        body: JSON.stringify({ id: id })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                getUser();
            } else {
                alert('Ocorreu um erro ao excluir o usuário.');
            }
        });
}

function editUser(id) {
    fetch('get_user.php?id=' + id)
        .then(response => response.json())
        .then(user => {
            const nomeInput = document.getElementById('nome');
            const emailInput = document.getElementById('email');
            const senhaInput = document.getElementById('senha');
            const cpfInput = document.getElementById('cpf');
            const fotoInput = document.getElementById('foto');
            const userIdInput = document.getElementById('user-id'); // Campo oculto para ID do carro

            nomeInput.value = user.nome;
            emailInput.value = user.email;
            senhaInput.value = user.senha;
            cpfInput.value = user.cpf;
            fotoInput.value = user.foto;
            userIdInput.value = user.id; // Definir o ID do usuário no campo oculto
        });
}
