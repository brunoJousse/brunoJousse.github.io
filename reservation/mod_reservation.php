<?php
	require_once("controleur_reservation.php");
		
	class ModReservation extends ModuleGenerique{ 
			
		public function __construct(){
			$this->controleur=new ControleurReservation();
			$this->controleur->main();	
		}
	}
?>
