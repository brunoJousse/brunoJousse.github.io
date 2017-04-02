<?php
	require_once("controleur_course.php");
		
	class ModCourse extends ModuleGenerique{ 
			
		public function __construct(){
			$this->controleur=new ControleurCourse();
			$this->controleur->main();	
		}
	}
?>
