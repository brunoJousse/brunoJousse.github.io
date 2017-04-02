<?php
	require_once("modele_course.php");
	require_once("vue_course.php");
	
	class ControleurCourse extends ControleurGenerique{
			
		public function main(){
			$this->vue=new VueCourse();
			if(!isset($_SESSION['identifiant']) || !isset($_SESSION['mdp'])) {
				$this->vue->vue_erreur("Vous devez être connecté");
			}
			/*
			if(!isset($_SESSION['identifiant'])||!isset($_SESSION['mdp'])) {
				$this->vue->vue_erreur("Vous devez être connecté");
			}*/
			else{

				
				if(isset($_GET['action'])){
					$this->model=new ModeleCourse();
					if($_GET['action']=='creation' && isset($_POST['lieuDepart']) && isset($_POST['dateDepart']) && isset($_POST['heureDepart']) && isset($_POST['lieuArrivee']) && isset($_POST['prix']) && isset($_POST['nbPassagersMax'])){
					
						$this->ajoutCourse(); 
					}
					
					else if($_GET['action']=='consultation' && isset($_GET['idCourse'])){	
						$this->voirCourse();
					}
					else if($_GET['action']=="annulerTrajet" && isset($_POST['idCourse']) && isset($_POST["newNbPassager"])){
						$this->annulationTrajet();
					}
					else if($_GET['action']=="annulerCourse" && isset($_POST['idCourse'])){
						$this->annulationCourse();
					}
					else{
						$this->afficheForm();
					}
				}
				else{
					$this->afficheForm();
				}
			}
		}
		

		private function afficheForm(){

			$this->vue->afficheForm();	
		}

		private function ajoutCourse(){
			
			try{

				$lieuDepart=htmlspecialchars($_POST['lieuDepart']);
				$dateDepart=htmlspecialchars($_POST['dateDepart']);
				$heureDepart=htmlspecialchars($_POST['heureDepart']);
				$lieuArrivee=htmlspecialchars($_POST['lieuArrivee']);
				if(!isset($_POST['smoke'])){
					$smoke=false;
				} 
				else{
					$smoke=true;
				}
				if(!isset($_POST['pet'])){
					$pet=false;
				} 
				else{
					$pet=true;
				}
				if(!isset($_POST['bagage'])){
					$bagage=false;
				} 
				else{
					$bagage=true;
				}
				$nbPassagersMax=htmlspecialchars($_POST['nbPassagersMax']);
				$prix=htmlspecialchars($_POST['prix']);	
						
				
				$explodedLieuD=explode("/", trim($lieuDepart, " "));
				$explodedLieuA=explode("/", trim($lieuArrivee," "));

				if(sizeof($explodedLieuD)!=3 || sizeof($explodedLieuA)!=3){
					$this->vue->vue_erreur("Vous avez mal renseigné l'adresse, elle doit respectée la forme: Pays / Ville / Nom rue");			
					return;
				}
				$paysD=$explodedLieuD[0];
				$rueD=$explodedLieuD[2];
				$villeD=$explodedLieuD[1];
			
				$paysA=$explodedLieuA[0];
				$rueA=$explodedLieuA[2];
				$villeA=$explodedLieuA[1];
				
				$explodedDateDepart=explode("-", trim($dateDepart, " "));

				if(sizeof($explodedDateDepart)!=3){
					$this->vue->vue_erreur("Vous avez mal renseigné la date, elle doit respectée la forme: dd-mm-yyyy ");			
					return;
				}
			
				$day=$explodedDateDepart[0];
				$month=$explodedDateDepart[1];
				$year=$explodedDateDepart[2];

				if(strlen($day)>2 || strlen($month)>2 || strlen($year)>4 || !is_numeric($day)|| !is_numeric($month)|| !is_numeric($year) || $day<0 || $month<0 || $month>12 || $year<2000
				|| !($day!=30 && $day!=31 && $day!=28 && $day!=29 || $day==31 && ($month==1 || $month==3 || $month==5 || $month==7 || $month==8 || $month==10 || $month==12) || $day==30 && ($month==4 || $month==6 || $month==9 || $month==11) || $day==28 && $day==29 && $month==2) ){
						$this->vue->vue_erreur("Vous avez mal renseigné la date, elle doit respectée la forme: dd-mm-yyyy ");		
						return;	
				}
			
				$explodedHeureDepart=explode(":", trim($heureDepart, " "));
				if(sizeof($explodedHeureDepart)!=2){
					$this->vue->vue_erreur("Vous avez mal renseigné l'heure, elle doit respectée la forme: hh:mm ");			
					return;
				}
			
				$heure=$explodedDateDepart[0];
				$minute=$explodedDateDepart[1];
			
				if(strlen($heure)>2 || strlen($minute)>2 || !is_numeric($heure) || !is_numeric($minute) || $heure>23 || $heure<0 || $minute<0 || $minute>59){
						$this->vue->vue_erreur("Vous avez mal renseigné l'heure, elle doit respectée la forme: hh:mm ");
						return;			
				}
			
				if(!is_numeric($nbPassagersMax) || !is_numeric($prix)){
						$this->vue->vue_erreur("Vous avez mal renseigné le prix ou le nombre de passagers, ils ne doivent contenir que des chiffres ");
						return;	
				}
			
				$dateDepartBD=$year."-".$month."-".$day;
				if(strtotime($dateDepartBD) < strtotime('now')){
					$this->vue->vue_erreur("La date doit être après la date actuel");
					return;
				}
				$dateDepartBD.=" ".$heure.":".$minute.":00";
				
				if(!$this->model->creationCourse($_SESSION['identifiant'], $paysD, $villeD, $rueD, $paysA, $villeA, $rueA, $dateDepartBD, $nbPassagersMax, $prix, $smoke, $pet, $bagage)){
					$this->vue->vue_erreur("Un problème au niveau de la base de données est survenue :/");
					return;	
				}
				$this->vue->vue_confirm("Trajet crée !");
			}
			catch(ModeleCourseException $e){
				$this->vue->vue_erreur("Un problème au niveau de la base de données est survenue :/");
			}			
			
		}

		private function voirCourse(){
			
			try{			
				$idCourse=htmlspecialchars($_GET['idCourse']);
				if(!is_numeric($idCourse)){
					$this->vue->vue_erreur("404 PAGE NOT FOUND");
					return;
				}
				
				if(($informations=$this->model->getInformationsCourse($idCourse))==null){
					$this->vue->vue_erreur("404 PAGE NOT FOUND");
					return;				
				}

				$this->vue->afficheCourse($informations);	
			}
			catch(ModeleCourseException $e){
				$this->vue->vue_erreur("Un problème au niveau de la base de données est survenue :/");
			}		
		}
		
		private function annulationTrajet(){
			$idCourse=htmlspecialchars($_POST["idCourse"]);
			$newNbPassager=htmlspecialchars($_POST["newNbPassager"]);
						
			try{
				if(!$this->model->estPassager($idCourse, $_SESSION["identifiant"])){
					$this->vue->vue_erreur("Vous ne pouvez pas vous désinscrire si vous n'êtes pas passager");
					return;				
				}
				if(!$this->model->supprimerTrajet($idCourse, $_SESSION["identifiant"],$newNbPassager)){
					$this->vue->vue_erreur("La suppresion n'a pas pu aboutir");
					return;				
				}
			$this->vue->vue_confirm("La suppression a été réalisée avec succès");
			} catch(ModeleCourseException $e){
				$this->vue->vue_erreur("Un problème au niveau de la base de données est survenu");
			}		
		}
		
		private function annulationCourse(){
			$idCourse=htmlspecialchars($_POST["idCourse"]);
			
			try{
				if(!$this->model->estConducteur($idCourse, $_SESSION["identifiant"])){
					$this->vue->vue_erreur("Vous ne pouvez pas annuler le trajet si vous n'êtes pas conducteur");
					return;
				}
				if(!$this->model->supprimerCourse($idCourse, $_SESSION["identifiant"])){
					$this->vue->vue_erreur("La suppresion n'a pas pu aboutir");
					return;				
				}
				$this->vue->vue_confirm("La suppression a été réalisée avec succès");
			} catch(ModeleCourseException $e){
				$this->vue->vue_erreur("Un problème au niveau de la base de données est survenu");
			}		
		}
	}
?>
