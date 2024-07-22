<?php
include('ClassConect.php');

class ClassEstados extends ClassConect
{

    public function getEstados()
    {
        $estado = $this->conectaDB()->prepare('select * from estado');
        $estado->execute();
        return $fEstados = $estado->fetchAll(\PDO::FETCH_OBJ);
    }

}
