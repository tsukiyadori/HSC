<?php

class DatabaseRepository extends mysqli {

    // single instance of self shared among all instances
    private static $instance = null;
    
    // db connection config vars
    private $user = "hsc";
    private $pass = "hscpw";
    private $dbName = "hsc";
    private $dbHost = "localhost";
    private $con = null;

    //This method must be static, and must return an instance of the object if the object
    //does not already exist.
    public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // The clone and wakeup methods prevents external instantiation of copies of the Singleton class,
    // thus eliminating the possibility of duplicate objects.
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }

    // private constructor
    private function __construct() {
        parent::__construct($this->dbHost, $this->user, $this->pass, $this->dbName);
        if (mysqli_connect_error()) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
        parent::set_charset('utf-8');
    }

    public function get_user_id_by_name($pName) {
        $name = $this->real_escape_string($pName);
        $user = $this->query("SELECT id FROM user WHERE username='" . $name . "'");
        
        if ($user->num_rows > 0) {
            $row = $user->fetch_row();
            return $row[0];
        } else {
            return NULL;
        }
    }


    public function create_user($id, $pName) {
        $name = $this->real_escape_string($pName);        
        $this->query("INSERT INTO user (id, name) VALUES ('" . $id
                . "', '" . $name . "')");
    }

}

?>