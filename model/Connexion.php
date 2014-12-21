<?php 
//On peut garder le même fichier de connexion si votre base de données s'appelle Feedback
//Connexion à la bdd via un singleton pour éviter les global $bd (maintenance plus facile)
class ConnectionFactory
{
    private static $factory;
    private $db;

    public static function getFactory()
    {
        if (!self::$factory)
            self::$factory = new ConnectionFactory();
        return self::$factory;
    }

    public function getConnection() {
        if (!$this->db)
            $this->db =new PDO('mysql:host=localhost;dbname=feedback','root','');
         $this->db->query('SET NAMES utf8');
          $this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $this->db;
    }
}

?>