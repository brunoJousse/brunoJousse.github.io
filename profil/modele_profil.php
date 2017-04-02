<?php			
		
	class ModeleProfil extends ModeleGenerique{	
		public function getUtilisateur($pseudo){
			try{
				$result=self::$connexion->prepare("select * from inf345_30.Utilisateur where pseudo=?");
				$result->execute(array($pseudo));
				return $result->fetch(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e){
				throw new ModeleProfilException();
			}
		}
		
		public function editerCompte($pseudo, $nom, $prenom, $identifiant, $mail, $tel, $admin){
			try{
				$result=self::$connexion->prepare("update inf345_30.Utilisateur set pseudo=?, nom=?, prenom=?, mail=?, telephone=?, admin=? where pseudo=?");
				$result->execute(array($identifiant, $nom, $prenom, $mail, $tel, $admin, $pseudo));
				if($result->rowCount()==0)
					return false;
				return true;		
			}
			catch(PDOException $e){
				throw new ModeleProfilException();
			}
		}
		
		public function supprimerCompte($pseudo){
			try{
				$result=self::$connexion->prepare("delete from inf345_30.Utilisateur where pseudo=?");
				$result->execute(array($pseudo));
				if($result->rowCount()==0){
					return false;
				}
				return true;		
			}
			catch(PDOException $e){
				throw new ModeleProfilException();
			}
		}
		
		public function editerNbAnnulation($pseudo, $nbAnnulation){
			try{
				$result=self::$connexion->prepare("update inf345_30.Utilisateur set nbAnnulation=? where pseudo=?");
				$result->execute(array($nbAnnulation, $pseudo));
				if($result->rowCount()==0)
					return false;
				return true;		
			}
			catch(PDOException $e){
				throw new ModeleProfilException();
			}
		}
		
		public function bonMdp($pseudo, $mdp){
			try{
				$result=self::$connexion->prepare("select mdp from inf345_30.Utilisateur where pseudo=:pseudo");
				$result->bindValue('pseudo', $pseudo);
				$result->execute();
				$enregistrement=$result->fetch(PDO::FETCH_ASSOC);	
				$bonMdp=$enregistrement['mdp'];
				$mdpEncrypt=hash('sha256', $mdp.$pseudo);
				if($bonMdp!=$mdpEncrypt){
					return false;
				}
			return true;
			}
			catch(PDOException $e){
				throw new ModeleCompteException();
			}
		}
		
		public function editerMdp($pseudo, $mdp){
			try{
				$result=self::$connexion->prepare("update inf345_30.Utilisateur set mdp=:mdp where pseudo=:pseudo");
				$mdpHash=hash('sha256', $mdp.$pseudo);
				$result->bindValue("mdp", $mdpHash);
				$result->bindValue("pseudo", $pseudo);
				$result->execute();
			} catch(PDOException $e){
				throw new ModeleCompteException();
			}
		}
	    
	}
?>
