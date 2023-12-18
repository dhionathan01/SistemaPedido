<? 
namespace App;

class Connection{
    public static function getDb(){
        try{
            // Como estamos usando os namespace para transitar, e o PDO � um objeto padr�o do php, temos que referenciar ele no diret�rio raiz. Basta colocar  \  antes do seu nome
            $connection = new \PDO(
                "mysql:host=localhost;dbname=sistema_pedidos_swl;charset=utf8",
                "root",
                ""
                
        );
        return $connection;
        }catch(\PDOException $erroBd){

        }
    }
}
?>