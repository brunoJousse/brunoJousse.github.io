<?php
	class ModeleGenerique{
		private static $dns="mysql:host=localhost:3306; dbname=inf345_30;";
		private static $user="Enseignant";
		private static $password="mdpEnseignant";
		static protected $connexion;
		
		public static function init(){
			try{
				self::$connexion=new PDO(self::$dns, self::$user, self::$password);
				self::$connexion->exec("SET NAMES 'UTF8'");
			}catch(PDOException $e){
				echo $e->getMessage();
			}

		}
	}		
?>
