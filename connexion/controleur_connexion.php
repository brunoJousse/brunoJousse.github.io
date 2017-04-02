<?php
	require_once("modele_connexion.php");
	require_once("vue_connexion.php");
	
	class ControleurConnexion extends ControleurGenerique{
			
		public function messageConnexion(){
			$this->vue=new VueConnexion();
			$this->modele=new ModeleConnexion();
			if(isset($_SESSION['identifiant']) && isset($_SESSION['mdp'])) {
				$this->vue->vue_erreur("Vous êtes déjà connecté");
			}
			else {
				if(isset($_GET['action']) && $_GET['action']=='connecter' && isset($_POST['identifiant']) && $_POST['identifiant']!="" && isset($_POST['mdp'])) {
					$mdp=htmlspecialchars($_POST['mdp']);
					$identifiant=htmlspecialchars($_POST['identifiant']);
					try{
						if(!$this->modele->connexion($identifiant, $mdp)){
							$this->vue->vue_erreur("La combinaison entre l'identifiant et le mot de passe est incorrecte.");					
						}
						else {
							$result=$this->modele->estAdmin($identifiant);
							if($result["nbAnnulation"]>=3){
								$this->vue->vue_erreur("Votre compte est actuellement banni car vous avez annulé trop de trajets, contactez un admin par mail pour plus d'informations: adminTravelExpress@gamil.com");
							}
							$_SESSION['admin']=$result["admin"];
							$_SESSION['identifiant']=$identifiant;
							$_SESSION['mdp']=$mdp;
							$this->vue->vue_confirm("Vous êtes connecté !");	
						}		
					}
					catch(ModeleConnexionException $e){
						$this->vue->vue_erreur("La connexion n'a pas pu aboutir :/");
					}					
				}
				else if(isset($_GET['action']) && $_GET['action']=='inscrire' && isset($_POST['nom']) && $_POST['nom']!="" && isset($_POST['prenom']) && $_POST['prenom']!="" && isset($_POST['identifiant']) && $_POST['identifiant']!="" && isset($_POST['mdp']) && $_POST['mdp']!="") {
					$nom=htmlspecialchars($_POST['nom']);
					$prenom=htmlspecialchars($_POST['prenom']);
					$mdp=htmlspecialchars($_POST['mdp']);
					$mdp2=htmlspecialchars($_POST['mdp2']);
					$identifiant=htmlspecialchars($_POST['identifiant']);		
					$mail=htmlspecialchars($_POST['mail']);
					$mail2=htmlspecialchars($_POST['mail2']);
					$tel=htmlspecialchars($_POST['tel']);
					
					if($mdp!=$mdp2){
						$this->vue->vue_erreur("Les deux mots de passe ne coincident pas.");
						return;
					}
					if($mail!=$mail2){
						$this->vue->vue_erreur("Les deux mails ne coincident pas.");
						return;
					}
					try{	
						if(!$this->modele->creationCompte($nom, $prenom, $identifiant, $mdp, $mail, $tel)){
							$this->vue->vue_erreur("L'identifiant est déjà utilisé par un autre utilisateur :/");					
						}
						else {
							$this->vue->vue_confirm("Vous êtes inscrit");	
						}
					}
					catch(ModeleConnexionException $e){
						$this->vue->vue_erreur("La connexion n'a pas pu aboutir :/");
					}
				}
				else {	
					$this->vue->affichageConnexion();			
				}
			}
		}
	}
?>
