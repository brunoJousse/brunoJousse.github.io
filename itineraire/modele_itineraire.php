<?php			
		
	class ModeleItineraire extends ModeleGenerique{	
	
			public function getProduits($requeteSQL){

			try{
				$result=self::$connexion->prepare($requeteSQL);
				$result->execute();
				if($result==NULL){
					return false;
				}
				
				$result=$result->fetchAll(PDO::FETCH_ASSOC); 
			} catch(PDOException $e){
				throw new ModeleVenteException();
			}
			return $result;		
		}	
	}
?>
