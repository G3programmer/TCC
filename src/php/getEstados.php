<?php
include('classEstados.php');

$objEstados = new ClassEstados();
$estados = $objEstados->getEstados();

foreach($estados as $estado) {
    echo '<option value="' . $estado->id . '">' . $estado->nome . '</option>';
}
?>
