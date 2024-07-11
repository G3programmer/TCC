<?php
include('ClassConect.php');

class ClassCidades extends ClassConect
{

    public function getCidades($estado_id)
    {
        $cidades = $this->conectaDB()->prepare('select * from cidades where estado_id = ?');
        $cidades->bindValue(1,$estado_id);
        $cidades->execute();
        return $fCidades = $cidades->fetchAll(\PDO::FETCH_OBJ);
    }

}