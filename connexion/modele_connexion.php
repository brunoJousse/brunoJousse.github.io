<?php
	class ModeleConnexion extends ModeleGenerique{
		
		public function connexion($pseudo, $mdp){
			try{
				$result=self::$connexion->prepare("select mdp from inf345_30.Utilisateur where pseudo=:pseudo");
				$result->bindValue('pseudo', $pseudo);
				$result->execute();
			} catch(PDOException $e){
				throw new ModeleConnexionException();
			}

			$enregistrement=$result->fetch(PDO::FETCH_ASSOC);	
			$bonMdp=$enregistrement['mdp'];
			$mdpEncrypt=hash('sha256', $mdp.$pseudo);
			if($bonMdp!=$mdpEncrypt){
				return false;
			}
			return true;
		}
		
		public function creationCompte($nom, $prenom, $pseudo, $mdp, $mail, $tel){
			try{
			$result=self::$connexion->prepare("insert into inf345_30.Utilisateur(nom, prenom, mdp, pseudo, mail, admin, telephone) values (:nom, :prenom, :mdp, :pseudo, :mail, 0, :tel)");
			$result->bindValue('nom', $nom);	
			$result->bindValue('prenom', $prenom);	
			$result->bindValue('pseudo', $pseudo);
			$mdpEncrypt=hash('sha256', $mdp.$pseudo);
			$result->bindValue('mdp', $mdpEncrypt);
			$result->bindValue('mail', $mail);
			$result->bindValue('tel', $tel);
			
			if($result->execute()==0){
				return false;
			}	
			return true;
			} catch(PDOException $e){
				throw new ModeleConnexionException();
			}
			
		}
		
		public function estAdmin($pseudo){
		try{			
			$result=self::$connexion->prepare("select admin, nbAnnulation from inf345_30.Utilisateur where pseudo=:pseudo");
			$result->bindValue('pseudo', $pseudo);
			$result->execute();
						
			} catch(PDOException $e){
				throw new ModeleConnexionException();
			}
			$enregistrement=$result->fetch(PDO::FETCH_ASSOC);	
			return $enregistrement;
		}
	}
?>
