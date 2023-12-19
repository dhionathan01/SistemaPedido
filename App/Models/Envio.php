<?php

namespace App\Models;

use DHF\Model\Model;

class Envio extends Model
{
    private $id;
    private $tipo;
    private $valor;

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function getAll()
    {
        $sql = "SELECT  
                    id,
                    tipo,
                    valor
                FROM  
                    envios";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function updated()
    {
        $sql = "UPDATE
                    envios
                SET 
                    valor = :valor 
                WHERE id =:id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $this->id);
        $stmt->bindValue(':valor', $this->valor);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getById()
    {
        $sql = "SELECT  
                    id,
                    tipo,
                    valor
                FROM  
                    envios
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $this->id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
