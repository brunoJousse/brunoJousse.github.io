<?php			
		
	class ModeleReservation extends ModeleGenerique{	
	    
	    public function getPlacesDispo($idCourse){
			try{	    	
	    		$result=self::$connexion->prepare("select nbPassagersMax, nbPassager from inf345_30.Itineraire where idItineraire=?");
	    		$result->execute(array($idCourse));
	    		$infos=$result->fetch(PDO::FETCH_ASSOC);	    		
	    		return $infos;
			} catch(PDOException $e){
				throw new ModeleReservationException();
			}	    
	    }
	    
	    public function getConducteur($idCourse){
	    	try{
	    		$result=self::$connexion->prepare("select pseudo from inf345_30.Itineraire where idItineraire=?");
	    		$result->execute(array($idCourse));
	   	 	$infos=$result->fetch(PDO::FETCH_ASSOC);
	    		return $infos["pseudo"];
			} catch(PDOException $e){
				throw new ModeleReservationException();
			}
	    }
	    
	    public function creerReservation($idCourse, $pseudo, $nbReservations, $infos){
	    	try{			    		
	    		self::$connexion->beginTransaction();
	   		$result=self::$connexion->prepare("insert into inf345_30.Reserver(nbReservation, pseudo, idItineraire) values (?,?,?) ");
	   	 	if(!$this->enleverPlacesDispo($idCourse, $nbReservations, $infos["nbPassagersMax"], $infos["nbPassager"]) || $result->execute(array($nbReservations, $pseudo, $idCourse))==0 ){
					self::$connexion->rollback();					
					return false;	   	 	
	   	 	}
	   	 	self::$connexion->commit();
				return true;
				
			} catch(PDOException $e){
				self::$connexion->rollback();
				throw new ModeleReservationException();
			}
	    }
	    
	    public function enleverPlacesDispo($idCourse, $nbReservations, $nbPassagersMax, $nbPassagers){
			try{	
				$nbPassagersFin=$nbReservations+$nbPassagers;
				
				$sql="update inf345_30.Itineraire set nbPassager=? "; 		
	    		if($nbPassagersFin==$nbPassagersMax){
	    			$sql.=",active=\"false\" ";
	    		}
	    		$sql.=" where idItineraire=? ";
	    		
				$result=self::$connexion->prepare($sql);
				$result->execute(array($nbPassagersFin, $idCourse));
				
				if($result->rowCount()==0){
					return false;
				}
				return true;
			} catch(PDOException $e){
				throw $e;
			}
	    }
	}
?>
