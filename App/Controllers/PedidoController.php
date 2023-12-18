<?php 

    namespace App\Controllers;
    // Recursos do Framework
    use DHF\Controller\Action;
    use DHF\Model\Container;

class PedidoController extends Action{
            public function exibirFormulario(){
                include("../public/components/realizar_pedido.phtml");
            }
        }
?>