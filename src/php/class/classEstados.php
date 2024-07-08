<?php
include('index.php');

class ClassEstados extends ClassConect
{

    public function getEstados()
    {
        $estados = $this->conectaDB()->prepare('select * from estado');
        $estados->execute();
        return $fEstados = $estados->fetchAll(\PDO::FETCH_OBJ);
    }

    
}