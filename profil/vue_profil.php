<?php
	class VueProfil extends VueGenerique{

		public function afficheFormulaire($infos){
			$this->titre="Modifier profil";
			$this->contenu="
			<h2> Modifiez votre profil:</h2><br/>
			
			<form action='index.php?module=profil&amp;action=modifier' method='POST'>
				<label>Pseudo : </label> <input type='text' value='".$infos["pseudo"]."' name='newPseudo' required/> &nbsp;&nbsp;
				<label>Nom : </label> <input type='text' value='".$infos["nom"]."' name='nom' required/> &nbsp;&nbsp;
				<label>Prénom : </label><input type='text' value='".$infos["prenom"]."' name='prenom' required/> <br/>
				<label>Mail : </label><input type='text' value='".$infos["mail"]."' name='mail' required/> &nbsp;&nbsp;
				<label>Téléphone : </label><input type='text' value='".$infos["telephone"]."' name='tel' maxlength=10 required/> <br/><br/>
				
			";
			/*
			if($_SESSION["admin"]==true){
				$this->contenu.="<label>estAdmin : </label><input type='text";
			}
			else{
				$this->contenu.="<input type='hidden";
			}
			$this->contenu.="' value='".$infos['admin']."' name='admin'/>";
			
			if($_SESSION["admin"]==true){
				$this->contenu.="<label>nbAnnulations : </label><input type='text";
			}
			else{
				$this->contenu.="<input type='hidden";
			}
			$this->contenu.="' value='".$infos['nbAnnulation']."' name='nbAnnulation'/>
			*/
			$this->contenu.="<h2> Modifier mot de passe:</h2><br/>
				<label>Mot de passe actuel : </label><input type='password' autocomplete='off' name='mdpAct' placeholder='Mot de passe actuel' maxlength='20' /></br>
				<label>Nouveau mot de passe : </label><input type='password' autocomplete='off' name='mdp1' placeholder='Nouveau mot de passe' maxlength='20'></br>
				<label>Confirmation : </label><input type='password' autocomplete='off' name='mdp2' placeholder='Confirmer mot de passe' maxlength='20'></br></br>			
				
				<input type='hidden' value='".$infos['pseudo']." name='pseudo''/>
				<input type='submit' value='Submit'/>
			</form>
			";
		}
	}
?>
