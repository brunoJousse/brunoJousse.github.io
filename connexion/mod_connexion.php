<?php
	require_once("controleur_connexion.php");

	class ModConnexion extends ModuleGenerique{
	
		public function __construct(){
			$this->controleur=new ControleurConnexion();
			$this->controleur->messageConnexion();		
		}	
	}
?>
