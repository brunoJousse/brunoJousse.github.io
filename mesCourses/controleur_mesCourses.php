<?php
	require_once("modele_mesCourses.php");
	require_once("vue_mesCourses.php");
	
	class ControleurMesCourses extends ControleurGenerique{
			
		public function main(){
			$this->vue=new VueMesCourses();
			if(!isset($_SESSION['identifiant']) || !isset($_SESSION['mdp'])) {
				$this->vue->vue_erreur("Vous devez être connecté");
			}
			else{
				if(isset($_GET['action']) && $_GET['action']=='course' /*TODO*/){
					$this->listeCourses();
				}
				else{
					$this->listeTrajets();
				}
			}
		}

		public function listeCourses(){
			/*TODO*/
			try{
				$titre="courses";
				$this->model=new ModeleMesCourses();
				if(($liste=$this->model->getMesCourses($_SESSION["identifiant"]))==null){
					$this->vue->vue_erreur("Vous n'avez pas créé de course");
					return;
				}
				$this->vue->affiche($liste, $titre);
			} catch(ModeleMesCoursesException $e){
				$this->vue->vue_erreur("Un problème au niveau de la base de données est survenu");			
			}	
		}

		public function listeTrajets(){
			/*TODO*/
			$titre="trajets";
			$this->model=new ModeleMesCourses();
			if(($liste=$this->model->getMesTrajets($_SESSION["identifiant"]))==null){
				$this->vue->vue_erreur("Vous n'êtes inscrit à aucun trajet");			
				return;			
			}
			$this->vue->affiche($liste, $titre);	
		}
	}
?>
