<?php
	require_once("controleur_mauvaisModule.php");
		
	class ModMauvaisModule extends ModuleGenerique{ 
			
		public function __construct(){
			$this->controleur=new ControleurMauvaisModule();
			$this->controleur->messageMauvaisModule();	
		}
	}
?>
