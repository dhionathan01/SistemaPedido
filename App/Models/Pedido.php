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
    private $envio_id;
    private $valor;

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
        $sql = "INSERT INTO
                    pedidos(
                        user_id,
                        endereco_id,
                        envio_id,
                        valor
                        ) VALUES (
                            :user_id,
                            :endereco_id,
                            :envio_id,
                            :valor)";
        $stmt = $this->db->prepare($sql);  
        $stmt->bindValue(':user_id', $this->__get('user_id'));
        $stmt->bindValue(':endereco_id', $this->__get('endereco_id'));
        $stmt->bindValue(':envio_id', $this->__get('envio_id'));
        $stmt->bindValue(':valor', $this->__get('valor'));
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
                    updated_at,
                    envio_id,
                    valor

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
                    pedidos.envio_id,
                    pedidos.valor,
                    usuarios.nome

                FROM
                    pedidos
                LEFT JOIN usuarios ON usuarios.id = pedidos.user_id
                ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getPedidoById()
    {
        $sql = "SELECT  
                    pedidos.id,
                    pedidos.user_id,
                    pedidos.endereco_id,
                    pedidos.created_at,
                    pedidos.envio_id,
                    pedidos.valor,
                    pedidos.updated_at
                FROM
                    pedidos
                WHERE pedidos.id= :id
                ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $this->id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }
    public function getPedidoViewById($id)
    {
        $sql = "SELECT  
                    pedidos.id,
                    pedidos.user_id,
                    pedidos.endereco_id,
                    pedidos.created_at,
                    pedidos.updated_at,
                    pedidos.envio_id,
                    pedidos.valor,
                    usuarios.nome,
                    enderecos.cep,
                    enderecos.uf,
                    enderecos.cidade,
                    enderecos.bairro,
                    enderecos.rua,
                    enderecos.numero,
                    envios.id as envio_id,
                    envios.tipo as forma_envio
                FROM
                    pedidos
                LEFT JOIN 
                    usuarios ON usuarios.id = pedidos.user_id
                LEFT JOIN
                    enderecos ON enderecos.id = pedidos.endereco_id
                LEFT JOIN
                    envios ON envios.id = pedidos.envio_id
                WHERE pedidos.id=:id
                ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function updatePedidoById()
    {
        $sql = "UPDATE
                    pedidos
                SET
                    id = :id,
                    envio_id = :envio_id,
                    valor = :valor
                    updated_at = NOW(),
                WHERE id=:id
                ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $this->id);
        $stmt->bindValue(':envio_id',$this->envio_id);
        $stmt->bindValue(':valor', $this->valor);
        $stmt->execute();
    }
    public function deletePedidoById()
    {
        $sql = "DELETE 
                FROM
                    pedidos
                WHERE
                    id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $this->id);
        $stmt->execute();
    }
}
