<?php			
		
	class ModeleCourse extends ModeleGenerique{	
	    
	    public function creationCourse($pseudo, $paysD, $villeD, $rueD, $paysA, $villeA, $rueA, $dateDepart, $nbPassagersMax, $prix, $smoke, $pet, $bagage){
			try{	
	    		$result=self::$connexion->prepare("insert into inf345_30.Itineraire(paysDepart, villeDepart, rueDepart, paysArrivee, villeArrivee, rueArrivee, dateDepart, 
				nbPassagersMax, nbPassager, prix, smoke, pet, bagage, active, pseudo) values (?, ?, ?, ?, ?, ?, ?, ?, 0, ?, ?, ?, ?, true,?)");
	    		if($result->execute(array($paysD, $villeD, $rueD, $paysA, $villeA, $rueA, $dateDepart, $nbPassagersMax, $prix, $smoke, $pet, $bagage, $pseudo))==0){
					return false;
				}
				return true;
	    	}
	    	catch(PDOException $e){
	    		throw new ModeleCourseException();
	    	}	    
	    }
	    
	    public function getInformationsCourse($idCourse){
	    	try{
	    		$result=self::$connexion->prepare("select * from inf345_30.Itineraire inner join inf345_30.utilisateur using(pseudo) where idItineraire=?");
				$result->execute(array($idCourse));
				return $result->fetch(PDO::FETCH_ASSOC);
		  	}
	    	catch(PDOException $e){
	    		throw new ModeleCourseException();
	    	}
	    }
	    
	   public function supprimerCourse($idItineraire, $pseudo){
				try{
					var_dump($idItineraire, $pseudo);
					self::$connexion->beginTransaction();
					$result=self::$connexion->prepare("delete from inf345_30.Itineraire where idItineraire=?");
					$result->execute(array($idItineraire));					
					if($result->rowCount()==0 || !$this->augmenterNbAnnulation($pseudo)){
						self::$connexion->rollback();
						return false;				
					}
					
					//annulation paiement + message aux passagers
					self::$connexion->commit();
					return true;
				} catch(PDOException $e){
					self::$connexion->rollback();
					throw new ModeleCourseException();
				}
		}
		
		public function supprimerTrajet($idItineraire, $pseudo, $newNbPassager){
				try{

					self::$connexion->beginTransaction();
					$result=self::$connexion->prepare("delete from inf345_30.Reserver where idItineraire=? and pseudo=?");
					$result->execute(array($idItineraire,$pseudo));					
					if($result->rowCount()==0 || !$this->augmenterNbAnnulation($pseudo)){
						self::$connexion->rollback();
						return false;				
					}
					$result2=self::$connexion->prepare("update inf345_30.Itineraire set nbPassager=? where idItineraire=?");
					$result2->execute(array($newNbPassager, $idItineraire));
					if($result2->rowCount()==0){
						
						self::$connexion->rollback();
						return false;
					}
					//annulation paiement + message au conducteur
					
					
					self::$connexion->commit();
					return true;
				} catch(PDOException $e){
					self::$connexion->rollback();
					throw new ModeleCourseException();
				}
		}
		
		public function estPassager($idCourse, $pseudoPassager){
			try{
				$result=self::$connexion->prepare("select * from inf345_30.Reserver where idItineraire=? and pseudo=?");
				$result->execute(array($idCourse,$pseudoPassager));
				if($result==null){
					return false;				
				}			
				return true;
			}catch(PDOException $e){
				throw new ModeleCourseException();
			}
		}
		
		public function estConducteur($idCourse, $pseudoConducteur){
			try{
				$result=self::$connexion->prepare("select * from inf345_30.Itineraire where idItineraire=? and pseudo=?");
				$result->execute(array($idCourse,$pseudoConducteur));
				if($result==null){
					return false;				
				}
				return true;
			}catch(PDOException $e){
				throw new ModeleCourseException();
			}
		}
		
		public function augmenterNbAnnulation($pseudo){
			try{
				$result=self::$connexion->query("update inf345_30.Utilisateur set nbAnnulation=(nbAnnulation+1) where pseudo='".$pseudo."'");
				if($result->rowCount()==0){
					return false;				
				}
				return true;
			}catch(PDOException $e){
				throw new ModeleCourseException();
			}		
		}
	}
?>
