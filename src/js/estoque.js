let menu = document.querySelector('#menu-btn');
let navbar = document.querySelector('.header .navbar');

menu.onclick = () =>{
   menu.classList.toggle('fa-times');
   navbar.classList.toggle('active');
};

window.onscroll = () =>{
   menu.classList.remove('fa-times');
   navbar.classList.remove('active');
};


document.querySelector('#close-edit').onclick = () =>{
   document.querySelector('.edit-form-container').style.display = 'none';
   window.location.href = 'estoque.php','produto.php';
};


document.getElementById('add-plano').addEventListener('click', function() {
    const container = document.getElementById('planos-container');
    const newSelect = document.createElement('div');
    newSelect.classList.add('plano-select');
    newSelect.innerHTML = `
        <select name="plano[]">
            <option value="">Selecione um plano</option>
            <?php
            $result->data_seek(0); // Volta para o início do resultado
            while($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['id'] . '">' . $row['nome'] . '</option>';
            }
            ?>
        </select>
    `;
    container.appendChild(newSelect);
});
