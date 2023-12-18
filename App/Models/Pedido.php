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

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
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

    public function getAll()
    {
        $sql = "SELECT  
                    id,
                    user_id,
                    endereco_id,
                    created_at,
                    updated_at

                FROM  pedidos";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getAllView()
    {
        $sql = "SELECT  
                    pedidos.id,
                    pedidos.user_id,
                    pedidos.endereco_id,
                    pedidos.created_at,
                    pedidos.updated_at,
                    usuarios.nome

                FROM
                    pedidos
                LEFT JOIN usuarios ON usuarios.id = pedidos.user_id
                ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getPedidoViewById($id)
    {
        $sql = "SELECT  
                    pedidos.id,
                    pedidos.user_id,
                    pedidos.endereco_id,
                    pedidos.created_at,
                    pedidos.updated_at,
                    usuarios.nome,
                    enderecos.cep,
                    enderecos.uf,
                    enderecos.cidade,
                    enderecos.bairro,
                    enderecos.rua
                FROM
                    pedidos
                LEFT JOIN 
                    usuarios ON usuarios.id = pedidos.user_id
                LEFT JOIN
                    enderecos ON enderecos.id = pedidos.endereco_id
                WHERE pedidos.id=:id
                ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function updatePedidoById($id)
    {
        $sql = "UPDATE
                    pedidos
                SET
                    id = id
                WHERE pedidos.id=:id
                ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }
}
