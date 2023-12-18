<?php
namespace App\Models;

use DHF\Model\Model;

class Pedido extends Model
{
    private $id;
    private $user_id;
    private $endereco_id;
    private $created_at;
    private $updated_at;

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function salvar()
    {
        $sql = "INSERT INTO pedidos (user_id, endereco_id) VALUES (:user_id, :endereco_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $this->__get('user_id'));
        $stmt->bindValue(':endereco_id', $this->__get('endereco_id'));
        $stmt->execute();
        $this->id = $this->db->lastInsertId();
        // Obtém o valor do campo created_at
        $stmt = $this->db->prepare("SELECT created_at FROM pedidos WHERE id = :id");
        $stmt->bindValue(':id', $this->id);
        $stmt->execute();
        $created_at = $stmt->fetchColumn();

        // Adiciona os valores aos atributos do objeto
        $this->created_at = $created_at;
        return $this;
    }
}
?>
