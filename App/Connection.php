<? 
namespace App;

class Connection{
    public static function getDb(){
        try{
            // Como estamos usando os namespace para transitar, e o PDO é um objeto padrão do php, temos que referenciar ele no diretório raiz. Basta colocar  \  antes do seu nome
            $connection = new \PDO(
                "mysql:host=localhost;dbname=mvc;charset=utf8",
                "root",
                ""
                
        );
        return $connection;
        }catch(\PDOException $erroBd){

        }
    }
}
?>