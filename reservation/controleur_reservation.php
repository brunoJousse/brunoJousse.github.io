<?php
	require_once("modele_reservation.php");
	require_once("vue_reservation.php");
	
	class ControleurReservation extends ControleurGenerique{
			
		public function main(){
			$this->vue=new VueReservation();
			if(!isset($_SESSION['identifiant']) || !isset($_SESSION['mdp'])) {
				$this->vue->vue_erreur("Vous devez être connecté");
			}
			else{
				if(isset($_GET['action']) && $_GET['action']=='paiement' && isset($_POST["prix"]) && isset($_POST["nbPassagers"]) && isset($_GET["idCourse"]) && is_numeric($_POST["prix"]) && is_numeric($_POST["nbPassagers"])){
					$this->PaiementEtValidation();
				}
				else if(isset($_POST['adresseDepart']) && isset($_POST['adresseArrivee']) && isset($_POST['dateD']) && isset($_POST['idCourse']) && isset($_POST['prix']) && isset($_POST['nbPassagersDispo']) && is_numeric($_POST["prix"])){
					$this->afficheDemandePaiment();
				}
				else {
					$this->vue->vue_erreur("404 PAGE NOT FOUND");
				}
			}
		}

		public function afficheDemandePaiment(){
			
			$idCourse=htmlspecialchars($_POST["idCourse"]);
			$prix=htmlspecialchars($_POST["prix"]);
			$nbPassagersDispo=htmlspecialchars($_POST["nbPassagersDispo"]);		
			$adresseDepart=htmlspecialchars($_POST["adresseDepart"]);	
			$date=htmlspecialchars($_POST["dateD"]);	
			$adresseArrivee=htmlspecialchars($_POST["adresseArrivee"]);		
			$this->vue->affiche($idCourse, $prix, $nbPassagersDispo, $adresseDepart, $date, $adresseArrivee);	
		}

		public function PaiementEtValidation(){
			try{
				$this->model=new ModeleReservation();
				
				$idCourse=htmlspecialchars($_GET["idCourse"]);
				$nbPassagers=htmlspecialchars($_POST["nbPassagers"]);
				$conducteur=$this->model->getConducteur($idCourse);
				
				if($conducteur==$_SESSION["identifiant"] || $conducteur==null){
					$this->vue->vue_erreur("Vous ne pouvez pas réserver pour un trajet dont vous êtes le conducteur.");
					return;
				}	
				
				if(($infos=$this->model->getPlacesDispo($idCourse))==null){
					$this->vue->vue_erreur("Cet trajet n'existe plus.");
					return;
				}
				
				if(($infos["nbPassagersMax"]-$infos["nbPassager"])<$nbPassagers){
					$this->vue->vue_erreur("Il ne reste plus assez de places disponibles.");
					return;
				}	
				
				if(!$this->model->creerReservation($idCourse, $_SESSION["identifiant"], $nbPassagers, $infos)){
					$this->vue->vue_erreur("Il ne reste plus assez de places disponibles.");
					return;
				}				
				
				$this->vue->vue_confirm("Le paiement de ".$_POST['prix']."$ a bien été effectué");
			} catch(ModeleReservationException $e){
				$this->vue->vue_erreur("Il y a eu un problème au niveau de la base de données, réessayez plus tard.");			
			}
		}
	}
	?>
