<?php
	class VueMesCourses extends VueGenerique{

		public function affiche($liste, $titre){
			$this->titre="Liste ".$titre;
			$this->contenu='
			<h1> Voici la liste de vos '.$titre.' </h1>
			<div id="listeInfo">'; 
			foreach($liste as $info){
				$dateDepart=explode(" ",$info["dateDepart"]);
			
				$date=explode("-",$dateDepart[0]);
				$annee=$date[0];
				$mois=$date[1];
				$jour=$date[2];
	
				$horaire=explode(":",$dateDepart[1]);
				$heure=$horaire[0];
				$minute=$date[1];
				$this->contenu.='
				<div class="infoCourse"
				 ';
				if($info["active"]==false){
					$this->contenu.=' id="desactive" ';
				}
				else{
					$this->contenu.=' id="active" ';
				}
				$this->contenu.='
				>	
				<a class="align" href="index.php?module=course&amp;action=consultation&amp;idCourse='.$info["idItineraire"].'" >
					<h3 class="align">'.$jour.'/'.$mois.'/'.$annee.' <br/> '.$heure.'h'.$minute.'</h3>				
					<h3 class="align">'.$info["paysDepart"].' <br/> '.$info["villeDepart"].' <br/> '.$info["rueDepart"].'</h3> 
					<div class="align"><img class="fleche" src="images/arrow.png" /></div>
					<h3 class="align">'.$info["paysArrivee"].' <br/> '.$info["villeArrivee"].' <br/> '.$info["rueArrivee"].'</h3>	
					<div class="align">
					<img class="vignettes" src="images/
				';

				if($info["smoke"]==true) {
					$this->contenu.='yes';	
				}
				else{
					$this->contenu.="no";
				}
			
				$this->contenu.='Smoke.gif" />
			
				<img class="vignettes" src="images/
				';
		
				if($info["pet"]==true) {
					$this->contenu.='yes';	
				}
				else{
					$this->contenu.="no";
				}
				
				$this->contenu.='Pet.gif" />		
				<img class="vignettes" src="images/
				';
				
				if($info["bagage"]==true) {
						$this->contenu.='yes';	
				}
				else{
						$this->contenu.="no";
				}
				$this->contenu.='Bagage.gif" />	
				</div>
				';
				if($titre=="trajets"){
					$this->contenu.='<h3 class="align">'.$info["nbReservation"].' passager(s)</h3>';	
				}
				else if($titre=="courses"){
					$this->contenu.='<h3 class="align">'.$info["nbPassager"].'/'.$info["nbPassagersMax"].' passagers</h3>
						<h3 class="align">'.$info["prix"].'$</h3>					
					';	
				}
				$this->contenu.='
				</a>
				<div class="align">
				<form method="POST" onsubmit"return confirm(\"Etes vous sûr de vouloir supprimer ce trajet, en cas de suppression répétée votre compte sera suspendu\")" action="index.php?module=course&amp;action=';
				if($titre=="trajets"){
					$newNbPassager=$info["nbPassager"]-$info["nbReservation"];
					$this->contenu.='annulerTrajet">
					<input class="align" type="hidden" name="newNbPassager" value="'.$newNbPassager.'"  />
					';
				}
				else if($titre=="courses"){
					$this->contenu.='annulerCourse">
					';
				}
				
				$this->contenu.='
					<input class="align" type="hidden" name="idCourse" value="'.$info["idItineraire"].'"/>
					<button class="align" type="submit">
						<img id="supButton" src="images/delete-button.png"/>
					</button>
				</form>

				</div>				
				</div>';
								
			}
			$this->contenu.="</div>";
		}
	}
?>
