<?php 

    namespace App\Controllers;

    // Recursos do Framework
    use DHF\Controller\Action;
    use DHF\Model\Container;

class IndexController extends Action{

            public function index() {
                $this->render('index');
            }
            public function cadastrar(){
                $this->render('cadastrar');
            }
            public function registrar(){
                extract($_POST);
                $usuario = Container::getModel('Usuario');
                $usuario->__set('nome', $nome);
                $usuario->__set('email', $email);
                $usuario->__set('senha', md5($senha));
                if($usuario->validarCadastro() AND count($usuario->getUsuarioPorEmail()) == 0){
                    $usuario->salvar();
                    $this->render('cadastro_realizado');
                }else{
                    $this->view->usuario = array(
                        'nome' => $_POST['nome'],
                        'email' => $_POST['email'],
                        'senha' => $_POST['senha']

                    );

                    $this->render('cadastro_erro');
                }
            }

        }
?>