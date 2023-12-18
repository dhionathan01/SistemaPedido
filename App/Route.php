<? 
    namespace App;

    use DHF\Init\Bootstrap; 
    class Route extends Bootstrap{

        protected function initRoutes(){
            $routes['home'] = array(
                'route' => '/',
                'controller' => 'IndexController',
                'action' =>  'index'
            );

            $routes['autenticar'] = array(
                'route' => '/autenticar',
                'controller' => 'AuthController',
                'action' => 'autenticar'
            );
            $routes['menu_principal'] = array(
                'route' => '/menu_principal',
                'controller' => 'AppController',
                'action' => 'menu_principal'
            );
            $routes['cadastrar'] = array(
                'route' => '/cadastrar',
                'controller' => 'IndexController',
                'action' => 'cadastrar'
            );
            $routes['registrar'] = array(
                'route' => '/registrar',
                'controller' => 'IndexController',
                'action' => 'registrar'
            );
            $routes['exibirFormulario'] = array(
                'route' => '/exibirFormulario',
                'controller' => 'PedidoController',
                'action' => 'exibirFormulario'
            );
            $routes['realizarPedido'] = array(
                'route' => '/realizarPedido',
                'controller' => 'PedidoController',
                'action' => 'realizarPedido'
            );
            $routes['listarPedidos'] = array(
                'route' => '/listarPedidos',
                'controller' => 'PedidoController',
                'action' => 'listarPedidos'
            );
            $routes['visualizarPedido'] = array(
                'route' => '/visualizarPedido',
                'controller' => 'PedidoController',
                'action' => 'visualizarPedido'
            );
            $routes['logout'] = array(
                'route' => '/logout',
                'controller' => 'AuthController',
                'action' => 'sair'
            );

            $this->setRoutes($routes);
        }
    }
?>