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

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function salvar()
    {
        $sql = "INSERT INTO enderecos (cep, uf, cidade, bairro, rua) VALUES (:cep, :uf, :cidade, :bairro, :rua)";
        $stmt = $this->db->prepare($sql);
        echo $sql;
        $stmt->bindValue(':cep', $this->__get('cep'));
        $stmt->bindValue(':uf', $this->__get('uf'));
        $stmt->bindValue(':cidade', $this->__get('cidade'));
        $stmt->bindValue(':bairro', $this->__get('bairro'));
        $stmt->bindValue(':rua', $this->__get('rua'));
        $stmt->execute();

        return $this;
    }
}
?>
