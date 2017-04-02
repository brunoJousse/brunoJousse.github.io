<?php
	class VueCourse extends VueGenerique{

		public function afficheForm(){
			$this->titre="Créer course";
			$this->contenu='
			<h1> Créer une nouvelle course</h1>				<br/>
				
			<form onsubmit="return confirm(\"Etes vous sur de vouloir créer cette course ?\");" action=index.php?module=course&amp;action=creation method=POST >
				<Label>Lieu de départ:</Label><input type="text" autocomplete="off" name="lieuDepart" placeholder="Pays / Ville / Nom de la Rue" maxlength="400" required > &nbsp;&nbsp;
				<Label>Date de départ:</Label><input type="text" autocomplete="off" name="dateDepart" placeholder="dd-mm-yyyy" maxlength="10" required >  <input type="text" autocomplete="off" name="heureDepart" placeholder="hh:mm" maxlength="8" required ><br/><br/>
				<Label>Lieu d\'arrivée:</Label><input type="text" autocomplete="off" name="lieuArrivee" placeholder="Pays / Ville / Nom de la Rue" maxlength="400" required >&nbsp;&nbsp;
				<Label>Prix:</Label><input type="text" autocomplete="off" name="prix" placeholder="Prix" maxlength="3" required >&nbsp;&nbsp;
				<Label>Nombre de passagers max:</Label><input type="text" autocomplete="off" name="nbPassagersMax" placeholder="Nombre passagers max" maxlength="2" required >&nbsp;&nbsp;
				
				<!-- <Label>Date d\'arrivée:</Label><input type="text" autocomplete="off" name="dateDepart" placeholder="dd-mm-yyyy" maxlength="10" required >  <input type="text" autocomplete="off" name="heureArrivee" placeholder="00:00:00" maxlength="8" required > --> <br/><br/>

				<label id="cigarette"> Cigarettes:
 					<input id="smoke" type="checkbox" name="smoke" value="true" />
					<label for="smoke" ></label>
				</label>
				&nbsp;&nbsp;
				
				<label id="valise"> Gros bagage:
 					<input id="bagage" type="checkbox" name="bagage" value="true" />
					<label for="bagage" ></label>
				</label>
				&nbsp;&nbsp;
				
				<label id="animaux"> Animaux:
 					<input id="pet" type="checkbox" name="pet" value="true" />
					<label for="pet" ></label>
				</label>
				&nbsp;&nbsp;
				<br/>
				<br/>
				<input type="submit" value="Créer course"/>			
					<br/>				<br/>
				<p> <font color="red"> Attention, soyez sûr que les informations rentrées soient les bonnes car il est impossible de les modifier et l\'annulation répétée de courses peut entraîner une suspension de votre compte ! </font></p>
			</form>
			';
		}


		public function afficheCourse($informations){
			$dateDepart=explode(" ",$informations["dateDepart"]);
			
			$date=explode("-",$dateDepart[0]);
			$annee=$date[0];
			$mois=$date[1];
			$jour=$date[2];

			$horaire=explode(":",$dateDepart[1]);
			$heure=$horaire[0];
			$minute=$date[1];
			
			$nbPassagersDispo=$informations["nbPassagersMax"]-$informations["nbPassager"] ;
			
			$this->titre="Informations";
			$this->contenu='
			<h1><u>Informations concernant la course:</u></h1><br/><br/>
			
			<h2> Adresse de départ: <h2> <h3>Pays: '.$informations["paysDepart"].', Ville: '.$informations["villeDepart"].', Rue: '.$informations["rueDepart"].'</h3> <br/> 
			<h2> Horaire du départ:</h2> <h3>Le '.$jour.'/'.$mois.'/'.$annee.' à '.$heure.'h'.$minute.'</h3><br/><br/>
			<h2> Adresse d\'arrivée: <h2> <h3>Pays: '.$informations["paysArrivee"].', Ville: '.$informations["villeArrivee"].', Rue: '.$informations["rueArrivee"].'</h3> <br/> <br/>
			<h2> Prix du trajet: </h2><h3>'.$informations["prix"].'$ </h3> <br/><br/>
			<h2> Nombre de places restantes: </h2><h3> '.$nbPassagersDispo.'</h3><br/><br/>
			
			<h2> Autorisations: </h2><br/>				
			<img class="vignettes" src="images/
			';

			if($informations["smoke"]==true) {
				$this->contenu.='yes';	
			}
			else{
				$this->contenu.="no";
			}
			
			$this->contenu.='Smoke.gif" />
			
			<img class="vignettes" src="images/
			';

			if($informations["pet"]==true) {
				$this->contenu.='yes';	
			}
			else{
				$this->contenu.="no";
			}
			
			$this->contenu.='Pet.gif" />		
			<img class="vignettes" src="images/
			';
			
			if($informations["bagage"]==true) {
				$this->contenu.='yes';	
			}
			else{
				$this->contenu.="no";
			}
			$this->contenu.='Bagage.gif" />	
			
			<br/><br/>
			
			<h1> <u>Informations concernant le conducteur:</u></h1><br/><br/>
			
			<h2>Pseudo: </h2><h3>'.$informations["pseudo"].'</h3> <br/>
			<h2>Nom: </h2><h3>'.$informations["nom"].'</h3> <br/>
			<h2>Prénom: </h2><h3>'.$informations["prenom"].'</h3> <br/>
			<h2>Téléphone: </h2><h3>'.$informations["telephone"].'</h3>
			<h2>Mail: </h2><h3>'.$informations["mail"].'</h3>

			
			';
			 if($informations["active"]==true){
					$this->contenu.='<form action="index.php?module=reservation" method="POST" >
						<input type=hidden name=idCourse value="'.$informations["idItineraire"].'" />
						<input type=hidden name=prix value="'.$informations["prix"].'" />
						<input type=hidden name=nbPassagersDispo value="'.$nbPassagersDispo.'" />
						<input type=hidden name=adresseDepart value="'.$informations["villeDepart"].' rue '.$informations["rueDepart"].', '.$informations["paysDepart"].'" />
						<input type=hidden name=dateD value="le '.$jour.'/'.$mois.'/'.$annee.' à '.$heure.'h'.$minute.'" />
						<input type=hidden name=adresseArrivee value="'.$informations["villeArrivee"].' rue '.$informations["rueArrivee"].', '.$informations["paysArrivee"].'" />
						
						<br/><br/>
						<input type="submit" value="Réserver"/>
					</form>									
									';
			}
		}
	}
?>
