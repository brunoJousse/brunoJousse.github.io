<?php
	class VueGenerique{
		public $contenu;
		public $titre;
		
		public function __construct(){
			$this->contenu="";
			$this->titre="";
			ob_start();
		}
		
		public function tamponVersContenu(){	
			$this->contenu=$this->contenu . ob_get_clean();
		}

		public function vue_erreur($message){						
			$this->contenu='<div id = errMessage > 
						<h1><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Une erreur est survenue : <br/> </h1>
							<br/><br/><p> <font size = 5px color="red">' . $message . '</font> </p>
							</br> 
							<a href="index.php?module='. $GLOBALS ["nom_module"] .'"> 
								<input type="button" value="Retour"> 
							</a>
							<a href="index.php?module=accueil"> 
								<input type="button" value="Accueil"> 
							</a>
					</div>';
			$this->titre="Erreur";
		}
		
		public function vue_confirm($message){

			$this->contenu.='<div id = confirmMessage > 
						<h1><i class="fa fa-check" aria-hidden="true"></i> Operation réussie ! <br/> </h1>
							<br/><br/><p> <font size = 5px color="green">' . $message . '</font> </p>
							</br> 
					<a href="index.php?module='. $GLOBALS ["nom_module"] .'"> 
								<input type="button" value="Retour"> 
							</a>
							<a href="index.php?module=accueil"> 
								<input type="button" value="Accueil"> 
							</a>
					</div>';
			$this->titre="Confirmation";
		}
		
		public function getContenu(){
			return $this->contenu;
		} 

		public function getTitre(){
			return $this->titre;
		} 
	}
?>
