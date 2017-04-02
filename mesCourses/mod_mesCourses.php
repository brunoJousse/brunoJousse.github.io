<?php
	require_once("controleur_mesCourses.php");
		
	class ModMesCourses extends ModuleGenerique{ 
			
		public function __construct(){
			$this->controleur=new ControleurMesCourses();
			$this->controleur->main();	
		}
	}
?>
