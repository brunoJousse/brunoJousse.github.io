<?php
	require_once("modele_mauvaisModule.php");
	require_once("vue_mauvaisModule.php");
	
	class ControleurMauvaisModule extends ControleurGenerique{
			
		public function messageMauvaisModule(){
			$this->vue=new VueMauvaisModule();
			$this->vue->vue_erreur("Ce module n'existe pas !");		
		}
	}
	?>