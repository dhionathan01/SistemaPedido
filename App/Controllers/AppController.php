<? 
namespace App\Controllers;

// Recursos do Framework
use DHF\Controller\Action;
use DHF\Model\Container;

class AppController extends Action {
    public function menu_principal(){
        $this->validaAutenticacao();
        $this->render('menu_principal');
    }

    public function validaAutenticacao(){
        session_start();
        if(empty($_SESSION['nome']) OR !isset($_SESSION['nome'])){
            header('Location: /?login=erro');
        }
    }
}
?>