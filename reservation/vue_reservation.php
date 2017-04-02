<?php
	class VueReservation extends VueGenerique{

		public function affiche($idCourse, $prix, $nbPassagersDispo, $adresseDepart, $date, $adresseArrivee){
			$this->titre="Réservation";
			
			$this->contenu='<br/><br/>
			<h2>Confirmation réservation et paiement du trajet partant de '.$adresseDepart.', '.$date.', jusqu\'à '.$adresseArrivee.'. </h2>			<br/><br/>
				
			<div id="reservation">
			<form action="index.php?module=reservation&amp;action=paiement&amp;idCourse='.$idCourse.'" method=POST >
				<h3> Nombre de passagers:</h3>
				';
				for($i=1; $i<=$nbPassagersDispo; $i++){
					
					$vraiPrix=$i*$prix;
					$this->contenu.='<input id="radio'.$i.'" type="radio" name="nbPassagers" value="'.$i.'" onclick="changerPrix('.$vraiPrix.')" ';
	
					if($i==1){
						$this->contenu.=' checked ';
					}				
					
			
					$this->contenu.= '/> &nbsp;&nbsp;		
   				 <label for="radio'.$i.'"> '.$i.' </label>';				
				}
								
				$this->contenu.='
				<input type="hidden" id="prixHidden" name="prix" value="'.$prix.'" /> 				
				<br/> <br/>
				<h3 id="prix">Prix : '.$prix.'$</h3>
				<input type="submit" value="Payer" />
			</form>
			</div>
			
			
			 <script>
				function changerPrix(prix){
					document.getElementById("prix").innerHTML="Prix : "+prix+"$";
					document.getElementById("prixHidden").value=prix;
				}
			</script>
			';
		}
	}
?>
