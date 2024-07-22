<?php
include('ClassConect.php');

class ClassCidades extends ClassConect
{

    public function getCidades($estado_id)
    {
        $cidade = $this->conectaDB()->prepare('select * from cidades where estado_id = ?');
        $cidade->bindValue(1,$estado_id);
        $cidade->execute();
        return $fCidades = $cidade->fetchAll(\PDO::FETCH_OBJ);
    }

}