<?php			
		
	class ModeleMesCourses extends ModeleGenerique{	
	
		public function getMesCourses($pseudo){
			try{			
				$result=self::$connexion->query("select * from inf345_30.Itineraire where Itineraire.pseudo='".$pseudo."'");			
				return $result->fetchAll(PDO::FETCH_ASSOC);	
			} catch(PDOException $e){
				throw new ModeleMesCoursesException();
			}		
		}
	    
	    public function getMesTrajets($pseudo){
			try{			
				$result=self::$connexion->query("select * from inf345_30.Reserver inner join inf345_30.Itineraire using (idItineraire) where Reserver.pseudo='".$pseudo."'");			
				return $result->fetchAll(PDO::FETCH_ASSOC);	
			} catch(PDOException $e){
				throw new ModeleMesCoursesException();
			}				
		}
	}
?>
