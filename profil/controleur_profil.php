<?php
	require_once("modele_profil.php");
	require_once("vue_profil.php");
	
	class ControleurProfil extends ControleurGenerique{
			
		public function main(){
			$this->vue=new VueProfil();
			if(!isset($_SESSION['identifiant']) || !isset($_SESSION['mdp'])) {
				$this->vue->vue_erreur("Vous devez être connecté");
			}
			else{
				$this->model=new ModeleProfil();		
				if(isset($_GET['action'])){	

					if($_GET["action"]=="supprimer"){
						$this->suppProfil();
					}
				 	else if($_GET['action']=='modifier' && isset($_POST['nom']) && $_POST['nom']!="" && isset($_POST['prenom']) && $_POST['prenom']!="" && isset($_POST['mail']) && $_POST['mail']!="" && isset($_POST["tel"]) && $_POST["tel"]!=""){
						$this->modifProfil();
					}
					else {
						$this->vue->vue_erreur("404 PAGE NOT FOUND");	
					}
				}
				else{
					$this->afficheForm();
				}
			}
		}

		private function afficheForm(){
			//TODO
			try{
				if(($utilisateur=$this->model->getUtilisateur($_SESSION["identifiant"]))==null){
					$this->vue->vue_erreur("Aucun utilisateur possède ce pseudo.");		
					return;					
				}
			
				$this->vue->afficheFormulaire($utilisateur);	
			} catch(ModeleProfilException $e){
				$this->vue->vue_erreur("Un problème au niveau de la base de données est survenu.");
			}
		}

		private function modifProfil(){
			//TODO
			try{
				if(isset($_POST['pseudo']) && $_POST['pseudo']!="" && $_SESSION["admin"]==true){
					$pseudo=htmlspecialchars($_POST['pseudo']);
					
					if(isset($_POST['nbAnnulation']) && is_numeric($_POST['nbAnnulation'])){
						if(!$this->model->editerNbAnnulation($pseudo, $nbAnnulation)){
							$this->vue->vue_erreur("Erreur lors de la modification du nombre d'annulation");
							return;
						}
					}									
				}
				else {
					$pseudo=$_SESSION["identifiant"];
				}
				$nom=htmlspecialchars($_POST["nom"]);
				$prenom=htmlspecialchars($_POST["prenom"]);
				$newPseudo=htmlspecialchars($_POST["newPseudo"]);
				$mail=htmlspecialchars($_POST["mail"]);
				$tel=htmlspecialchars($_POST["tel"]);
				
				if($_SESSION["admin"]==false){
					$admin=false;					
				}
				else {
					$admin=htmlspecialchars($_POST["admin"]);
				}
				
				$phrase="";
				if((isset($_POST['mdp1']) && $_POST['mdp1']!='' && isset($_POST['mdp2']) && $_POST['mdp2']!='' && (isset($_POST['mdpAct'])) || $_SESSION['admin']==true)){
							if($_SESSION["admin"]==false){
								
								$mdpAct=htmlspecialchars($_POST["mdpAct"]);
								if(!$this->model->bonMdp($pseudo, $mdpAct)){
									$this->vue->vue_erreur("Mauvais mot de passe");
									return;
								}
							}							
							$mdp1=htmlspecialchars($_POST["mdp1"]);
							$mdp2=htmlspecialchars($_POST["mdp2"]);
							if(strcmp($mdp1, $mdp2) !=0){
								$this->vue->vue_erreur("Les deux mots de passe sont différents");
								return;
							}

							$this->model->editerMdp($pseudo, $mdp1);
							$phrase="Mot de passe modifier, mais ";
				}
							
				
				if(!$this->model->editerCompte($pseudo, $nom, $prenom, $newPseudo, $mail, $tel, $admin)){
					$this->vue->vue_erreur($phrase."Erreur lors de la modification du profil");
					return;
				}
				$this->vue->vue_confirm("Modification réussie.");						
			}
			catch(ModeleProfilException $e){
				$this->vue->vue_erreur("Un problème au niveau de la base de données est survenu.");
			}
		}
		
		private function suppProfil(){
			//TODO
			try{
				if(isset($_POST['pseudo']) && $_POST['pseudo']!=""  && $_SESSION["admin"]==true){
					$pseudo=htmlspecialchars($_POST['pseudo']);
				}
				else {
					$pseudo=$_SESSION["identifiant"];
				}
				
				if(!$this->model->supprimerCompte($pseudo)){
					$this->vue->vue_erreur("Erreur lors de la suppression");
					return ;
				}
				else {
					$this->vue->vue_confirm("Suppression réussie");	
					return;			
				}
			} catch(ModeleProfilException $e){
				$this->vue->vue_erreur("Un problème au niveau de la base de données est survenu.");
			}
		}
	}
	?>
