<?php

//*********Design Pattern Singleton********/
//*********Fichier à instance unique*******/

namespace App\Db;

// On importe PDO

use PDO;
use PDOException;

class Db extends PDO
{

    //Instance unique de la classe
    private static $instance;

    //Information de connexion à la base de données
    private const DBHOST = 'localhost';
    private const DBUSER = 'root';
    private const DBPASS = '';
    private const DBNAME = 'nom de la BDD';

    private function __construct()
    {
        //dsn de connexion à la base de données
        $_dsn = 'mysql:host=' . self::DBHOST . ';dbname=' . self::DBNAME;

        // on appelle le constructeur de la class PDO
        try {
            parent::__construct($_dsn, self::DBUSER, self::DBPASS);

            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
