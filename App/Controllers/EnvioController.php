<? 
namespace App\Controllers;

// Recursos do Framework
use DHF\Controller\Action;
use DHF\Model\Container;

class EnvioController extends Action {
    public function abrirMenuEnvio(){
        $envio = Container::getModel('Envio');
        $envios = $envio->getAll();
        include("../public/components/menu_envios.phtml");
    }
    public function atualizarValores(){
        $envio = Container::getModel('Envio');
       
        
        extract($_POST);
        foreach($lista_envios as $envioUni){
            echo '<pre>';
            print_r($envioUni);
            echo '</pre>';
            
            $envio->__set('id', $envioUni['id']);
            $envio->__set('valor', $envioUni['valor']);
            $envio->updated();
        }
    }
}
?>