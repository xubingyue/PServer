<?php
	require_once SCRIPTS_DIR . '/config.php';

	final class DB_CONN
	{
		public $conn;
		public $db;

		public function __construct()
		{
			$this->conn = new Mongo("mongodb://" . CONFIG::DB_HOST 
					. ":" . CONFIG::DB_PORT, 
					array("persist" => "x"));
			$this->db = $this->conn->selectDB(CONFIG::DB_NAME);                        
		}
        }
?>
