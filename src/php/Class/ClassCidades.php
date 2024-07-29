<?php
class ClassCidade {
    public function getCidades($estadoId) {
        include('ClassConect.php');
        $db = new ClassConect();
        $conn = $db->conectaDB();

        $query = "SELECT cidade_id, nome_cidade FROM cidades WHERE estado_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$estadoId]);
        
        $cidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $cidades;
    }
}
?>
