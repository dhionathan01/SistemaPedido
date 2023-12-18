<?php 

    namespace App\Controllers;
    // Recursos do Framework
    use DHF\Controller\Action;
    use DHF\Model\Container;

class PedidoController extends Action{

    public function exibirFormulario(){
        include("../public/components/realizar_pedido.phtml");
    }

    public function realizarPedido(){
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
        extract($_POST);
        $endereco = Container::getModel('Endereco');
        $endereco->__set('cep', $cep);
        $endereco->__set('uf',  $uf);
        $endereco->__set('cidade', $cidade);
        $endereco->__set('bairro', $bairro);
        $endereco->__set('rua', $rua);
        $endereco_object = $endereco->salvar();
        $endereco_id = $endereco_object->__get('id');

        $pedido = Container::getModel('Pedido');
        $pedido->__set('user_id', $user_id);
        $pedido->__set('endereco_id', $endereco_id);
        $pedido_object = $pedido->salvar();
        echo '<pre>';
        print_r($pedido_object);
        echo '</pre>';
        
    }
}
?>