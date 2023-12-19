<?php
namespace App\Models;

use DHF\Model\Model;

class Endereco extends Model
{
    private $id;
    private $cep;
    private $uf;
    private $cidade;
    private $bairro;
    private $rua;
    private $numero;

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function salvar()
    {
        $sql = "INSERT INTO enderecos (cep, uf, cidade, bairro, rua, numero) VALUES (:cep, :uf, :cidade, :bairro, :rua, :numero)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':cep', $this->__get('cep'));
        $stmt->bindValue(':uf', $this->__get('uf'));
        $stmt->bindValue(':cidade', $this->__get('cidade'));
        $stmt->bindValue(':bairro', $this->__get('bairro'));
        $stmt->bindValue(':rua', $this->__get('rua'));
        $stmt->bindValue(':numero', $this->__get('numero'));
        $stmt->execute();
        $this->id = $this->db->lastInsertId();
        return $this;
    }
    public function updateEnderecoById()
    {
        $sql = "UPDATE
                    enderecos
                SET
                    cep = :cep,
                    uf = :uf,
                    cidade = :cidade,
                    bairro = :bairro,
                    rua = :rua,
                    numero = :numero
                    WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->bindValue(':cep', $this->__get('cep'));
        $stmt->bindValue(':uf', $this->__get('uf'));
        $stmt->bindValue(':cidade', $this->__get('cidade'));
        $stmt->bindValue(':bairro', $this->__get('bairro'));
        $stmt->bindValue(':rua', $this->__get('rua'));
        $stmt->bindValue(':numero', $this->__get('numero'));
        $stmt->execute();
    }
    public function deleteEnderecoById()
    {
        $sql = "DELETE
                FROM
                    enderecos
                    WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();
    }
}
?>
