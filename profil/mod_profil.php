<?php
	require_once("controleur_profil.php");
		
	class ModProfil extends ModuleGenerique{ 
			
		public function __construct(){
			$this->controleur=new ControleurProfil();
			$this->controleur->main();	
		}
	}
?>
