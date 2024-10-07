<?php
include_once('conexao.php');
$query = "SELECT data_final FROM planos WHERE plano_id = ?";
$result = mysqli_query($conn, $query);

if ($result && $row = mysqli_fetch_assoc($result)) {
    $data_final = new DateTime($row['data_final']);
    $data_atual = new DateTime();  // Data atual

    // Calcula a diferença entre a data final e a atual
    $interval = $data_atual->diff($data_final);

    echo 'Faltam ' . $interval->days . ' dias, ' . $interval->h . ' horas, ' . $interval->i . ' minutos, e ' . $interval->s . ' segundos.';
}
?>