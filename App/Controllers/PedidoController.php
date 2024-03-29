<?php 

    namespace App\Controllers;
    // Recursos do Framework
    use DHF\Controller\Action;
    use DHF\Model\Container;
use App\Models\Pedido;

class PedidoController extends Action{

    public function exibirFormulario(){
        session_start();
        if(empty($_SESSION['id']) OR !isset($_SESSION['id']) OR  empty($_SESSION['nome']) OR !isset($_SESSION['nome'])){
            header('Location: /?login=erro');
        }
        $envios = Container::getModel('Envio');
        $envios = $envios->getAll();
        include("../public/components/realizar_pedido.phtml");
    }

    public function realizarPedido(){
        session_start();
        if(empty($_SESSION['id']) OR !isset($_SESSION['id']) OR  empty($_SESSION['nome']) OR !isset($_SESSION['nome'])){
            header('Location: /?login=erro');
        }        
        extract($_POST);
        $endereco = Container::getModel('Endereco');
        $endereco->__set('cep', $cep);
        $endereco->__set('uf',  $uf);
        $endereco->__set('cidade', $cidade);
        $endereco->__set('bairro', $bairro);
        $endereco->__set('rua', $rua);
        $endereco->__set('numero', $numero);
        $endereco_object = $endereco->salvar();
        $endereco_id = $endereco_object->__get('id');

        $pedido = Container::getModel('Pedido');
        $pedido->__set('user_id', $user_id);
        $pedido->__set('endereco_id', $endereco_id);
        $pedido->__set('envio_id', $envio_id);
        $pedido->__set('valor', $valor);
        $pedido_object = $pedido->salvar();
        
        $data = array(
            'endereco' =>[
                'id'=>$endereco_id,
                'cep'=>$endereco_object->__get('cep'),
                'uf'=>$endereco_object->__get('uf'),
                'cidade'=>$endereco_object->__get('cidade'),
                'bairro'=>$endereco_object->__get('bairro'),
                'rua'=>$endereco_object->__get('rua'),
                'numero'=>$endereco_object->__get('numero'),
            ],
            'pedido'=>[
                'id'=>$pedido_object->__get('id'),
                'user_id'=> $pedido_object->__get('user_id'),
                'endereco_id'=> $pedido_object->__get('endereco_id'),
                'created_at'=> $pedido_object->__get('created_at'),
            ]
        );
        echo json_encode($data);
    }
    public function listarPedidos()
    { session_start();
        if(empty($_SESSION['id']) OR !isset($_SESSION['id']) OR  empty($_SESSION['nome']) OR !isset($_SESSION['nome'])){
            header('Location: /?login=erro');
        }
        $pedido = Container::getModel('Pedido');
        $pedidos = $pedido->getAllView();
        // Renderiza a visualização
        $this->pedidos = $pedidos;
        include("../public/components/listar_pedidos.phtml");
    }
    public function visualizarPedido()
    { session_start();
        if(empty($_SESSION['id']) OR !isset($_SESSION['id']) OR  empty($_SESSION['nome']) OR !isset($_SESSION['nome'])){
            header('Location: /?login=erro');
        }
        $pedido = Container::getModel('Pedido');
        $pedido = $pedido->getPedidoViewById($_GET['id']);
        // Renderiza a visualização
        include("../public/components/pedido_detalhes.phtml");
    }
    public function updatePedido()
    { 
        session_start();
        if(empty($_SESSION['id']) OR !isset($_SESSION['id']) OR  empty($_SESSION['nome']) OR !isset($_SESSION['nome'])){
            header('Location: /?login=erro');
        }
        $pedido = Container::getModel('Pedido');
        $endereco = Container::getModel('Endereco');
        extract($_POST);
        $pedido->__set('id', $id_pedido);
        $pedido->__set('envio_id', $envio_id);
        $pedido->__set('valor', $valor);
        $pedido = $pedido->updatePedidoById();
        $endereco->__set('id', $endereco_id);
        $endereco->__set('cep', $cep);
        $endereco->__set('uf', $uf);
        $endereco->__set('cidade', $cidade);
        $endereco->__set('bairro', $bairro);
        $endereco->__set('rua', $rua);
        $endereco->__set('numero', $numero);
        $endereco = $endereco->updateEnderecoById();
       
    }
    public function excluirPedido()
    { 
        session_start();
        if(empty($_SESSION['id']) OR !isset($_SESSION['id']) OR  empty($_SESSION['nome']) OR !isset($_SESSION['nome'])){
            header('Location: /?login=erro');
        }
        $pedido = Container::getModel('Pedido');
        $endereco = Container::getModel('Endereco');
        extract($_POST);
        $pedido->__set('id', $id_pedido);
        $pedido->getPedidoById();
        $endereco->__set('id',$pedido->__get('endereco_id'));
        $endereco->deleteEnderecoById();
        $pedido->deletePedidoById();
    }
}
?>