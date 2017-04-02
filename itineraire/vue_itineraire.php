<?php
	class VueItineraire extends VueGenerique{

		public function afficherProduits($liste){
			$this->titre="Liste des itinéraires";
			
			//filtres déroulants			
			
			$this->contenu="
			<script type=\"text/javascript\" src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js\"></script>
			<script src=\"http://code.jquery.com/jquery-latest.js\"></script>
			<script src=\"jquery.easyPaginate.js\"></script> 			
			
			<script language=\"JavaScript\" type=\"text/JavaScript\">
			function deroul_div(id_div) {
 				if(document.getElementById(id_div).className=='aff_div'){
 					document.getElementById(id_div).className='cache_div'
 				}
  				else if(document.getElementById(id_div).className=='cache_div'){
   				document.getElementById(id_div).className='aff_div'
   			}
			}
			</script>";
			
			//paginate
			
			$this->contenu.="
			
			<script type=\"text/javascript\">
			jQuery(function($){
				$('ul#easyPaginate').easyPaginate({
   				paginateElement: 'li',
    				elementsPerPage: 1
				});
			});	
			</script>";

			// les filtres
			$this->contenu.=' 

				<form action="index.php?module=itineraire&amp;action=trier" method="POST">

					<h3> Filtres :</h3>
					<div><a href="javascript:void(0)" class="clickDiv" onClick="deroul_div(\'autorisations\')"><h4 class="inlineBlock">Autorisations</h4><img class="fleche" src="images/arrow-bas.png"/></a></div>
					<div id=autorisations class="cache_div">
					<label> Animal :</label>&nbsp;&nbsp;';
					
					$this->setRadio("pet");

					$this->contenu.='<label> Bagage :</label>&nbsp;&nbsp;';
					
					$this->setRadio("bagage");
						
					$this->contenu.='<label> Cigarette :</label>&nbsp;&nbsp';

					$this->setRadio("smoke");
					
					$this->contenu.='</div>

						<img class="sep" src="images/depProduits.png"/>
						
					<div><a  href="javascript:void(0)" class="clickDiv" onClick="deroul_div(\'lieu\')"><h4 class="inlineBlock">Lieu</h4><img class="fleche" src="images/arrow-bas.png"/></a></div>
					<div id=lieu class="cache_div">
				<Label>Lieu de départ :  </Label><input '; $this->setValue("paysDepart");  $this->contenu.='type="text" autocomplete="off" name="paysDepart" placeholder="Pays" maxlength="400"/> &nbsp;&nbsp; <input '; $this->setValue("villeDepart"); $this->contenu.=' type="text" autocomplete="off" name="villeDepart" placeholder="Ville" maxlength="400"> &nbsp;&nbsp; <input '; $this->setValue("rueDepart"); $this->contenu.=' type="text" autocomplete="off" name="rueDepart" placeholder="Nom de la Rue" maxlength="400"> <br/>
				<Label>Lieu d\'arrivée :  </Label><input '; $this->setValue("paysArrivee"); $this->contenu.=' type="text" autocomplete="off" name="paysArrivee" placeholder="Pays" maxlength="400"/> &nbsp;&nbsp; <input '; $this->setValue("villeArrivee"); $this->contenu.='type="text" autocomplete="off" name="villeArrivee" placeholder="Ville" maxlength="400"> &nbsp;&nbsp; <input '; $this->setValue("rueArrivee"); $this->contenu.=' type="text" autocomplete="off" name="rueArrivee" placeholder="Nom de la Rue" maxlength="400"> <br/>
				<br/>	
				</div>
				
										<img class="sep" src="images/depProduits.png"/>
										
					<div><a  href="javascript:void(0)" class="clickDiv" onClick="deroul_div(\'date\')"><h4 class="inlineBlock">Date</h4><img class="fleche" src="images/arrow-bas.png"/></a></div>
					<div id=date class="cache_div">
				<Label>Date de départ minimum :  </Label><input'; $this->setValue("dateMin"); $this->contenu.='  type="text" autocomplete="off" name="dateMin" placeholder="dd-mm-yyyy" maxlength="10"/><br/>				
				<Label>Date de départ maximum :  </Label><input '; $this->setValue("dateMax"); $this->contenu.='type="text" autocomplete="off" name="dateMax" placeholder="dd-mm-yyyy" maxlength="10"/><br/>
				<br/>		
				</div>		
				
										<img class="sep" src="images/depProduits.png"/>
										
					<div><a  href="javascript:void(0)" class="clickDiv" onClick="deroul_div(\'prix\')"><h4 class="inlineBlock">Prix</h4><img class="fleche" src="images/arrow-bas.png"/></a></div>
					<div id=prix class="cache_div">
				<Label>Prix minimum :  </Label><input '; $this->setValue("prixMin"); $this->contenu.=' type="text" autocomplete="off" name="prixMin" placeholder="" maxlength="3"/><br/>
				<Label>Prix maximum :  </Label><input '; $this->setValue("prixMax"); $this->contenu.=' type="text" autocomplete="off" name="prixMax" placeholder="" maxlength="3"/><br/>
				<br/>
				</div>
				
										<img class="sep" src="images/depProduits.png"/>
										
					<div><a  href="javascript:void(0)" class="clickDiv" onClick="deroul_div(\'nbPlaces\')"><h4 class="inlineBlock">Nombre de passagers</h4><img class="fleche" src="images/arrow-bas.png"/></a></div>
					<div id=nbPlaces class="cache_div">
				<Label>Nombre minimum de places disponilbes:</Label><input '; $this->setValue("nbPassager"); $this->contenu.=' type="text" autocomplete="off" name="nbPassager"  maxlength="2"/> <br/><br/>
				</div>	
															<img class="sep" src="images/depProduits.png"/>
					
					<div><a  href="javascript:void(0)" class="clickDiv" onClick="deroul_div(\'trie\')"><h4 class="inlineBlock">Triés par:</h4><img class="fleche" src="images/arrow-bas.png"/></a></div>
					<div id=trie class="cache_div">
						<input type="radio" name="trie" value="prixCrois"'; if(isset($_POST["trie"]) && $_POST["trie"]=="prixCrois"){ $this->contenu.=" checked "; } $this->contenu.='/>Prix croissant &nbsp;&nbsp;
						<input type="radio" name="trie" value="plusRecent"'; if(isset($_POST["trie"]) && $_POST["trie"]=="plusRecent"){ $this->contenu.=" checked "; } $this->contenu.='/> Du + au - récent &nbsp;&nbsp;
						<input type="radio" name="trie" value="moinsRecent"'; if(isset($_POST["trie"]) && $_POST["trie"]=="moinsRecent"){ $this->contenu.=" checked "; } $this->contenu.='/> Du - au + récent &nbsp;&nbsp;
						<input type="radio" name="trie" value="nbPlacesDispo"'; if(isset($_POST["trie"]) && $_POST["trie"]=="nbPlacesDispo"){ $this->contenu.=" checked "; } $this->contenu.='/> Par nombre de places restantes &nbsp;&nbsp;
					</div>
					<br/>
					<br/>
					<input id="bouton" type="submit" value="Filtrer"/>
				</form>
			';
			
			//les itinéraires
			
			$this->contenu.='
			<h3>Voici la liste des différents itinéraires proposés:</h3>
			<ul id="easyPaginate">'; 
			
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
				<li class="infoCourse"><div 
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
				$this->contenu.='<h3 class="align">'.$info["nbPassager"].'/'.$info["nbPassagersMax"].' passagers</h3>
						<h3 class="align">'.$info["prix"].'$</h3>					
					';	
				
				$this->contenu.='
				</a> </div></li>';
			}
			$this->contenu.='</ul>';
		}
		
		//Prend en paramètre la valeur du groupe radio
		private function setRadio($string){
			if(isset($_POST[$string])){
				$this->contenu.='<input type="radio" name="'.$string.'" value="'.$string.'" ';
				if($_POST[$string]==$string){
					$this->contenu.="checked";
				}
				$this->contenu.='/>Autorisé &nbsp;&nbsp;
				<input type="radio" name="'.$string.'" value="'."no".ucfirst($string).'" ';
				if($_POST[$string]=="no".ucfirst($string)){
					$this->contenu.="checked";
				}
				$this->contenu.='/>Interdit &nbsp;&nbsp;
				<input type="radio" name="'.$string.'" value="'."indif".ucfirst($string).'" ';
				if($_POST[$string]=="indif".ucfirst($string)){
					$this->contenu.="checked";
				}
					$this->contenu.="/>Indifférent<br/>";
			}
			else{
				$this->contenu.='
						<input type="radio" name="'.$string.'" value="'.$string.'"/>Autorisé &nbsp;&nbsp;
						<input type="radio" name="'.$string.'" value="'."no".ucfirst($string).'"/>Interdit &nbsp;&nbsp;
						<input type="radio" name="'.$string.'" value="'."indif".ucfirst($string).'" checked />Indifférent<br/>
				';			
			}
	
		}
		
		private function setValue($string){
			if(isset($_POST[$string])){$this->contenu.=" value='".$_POST[$string]."' ";}
		}
	
	}
?>
