<?php
	require_once("controleur_itineraire.php");
		
	class ModItineraire extends ModuleGenerique{ 
			
		public function __construct(){
			$this->controleur=new ControleurItineraire();
			$this->controleur->main();	
		}
	}
?>
