<?php
	class VueConnexion extends VueGenerique{
		
		public function affichageConnexion(){
			$this->contenu='

<!----------------------------------------------------------------------CONNEXION--------------------------------------------------------------------------------->
			<div id = "connexion">
    				<u><h1 id = titreConnexion>Connexion :</h1> </u>

				<!-------------------------------------TEXTFIELDS CONNEXION---------------------------------->
					<form action="index.php?module=connexion&amp;action=connecter" method="POST"></br>
						<div id = entreeFormCo>
								<input id=formulaireCo type="text" autocomplete="off" name="identifiant" placeholder="Identifiant" required></br></br>
								<input id=formulaireCo type="password" autocomplete="off" name="mdp" placeholder="Mot de passe" required></br></br></br>
						</div>
				<!-------------------------------------BOUTON CONNEXION---------------------------------->
						<div id = buttonCo>
							<input type="submit" value="Se connecter"/>				
						</div>			
					</form>
			</div>


<!------------------------------------------------------------------------SEPARATEUR------------------------------------------------------------------------------->
			<img id = sepCoIns src= "images/Filet-horizontal-bleu.jpg" />


<!-----------------------------------------------------------------------INSCRIPTION-------------------------------------------------------------------------------->
			<div id = "inscription">
				</br> <u> <h1 id = titreInscription>Inscription :</h1> </u> </br>

				<!-------------------------------------TEXTFIELDS INSCRIPTION---------------------------------->
				<form action="index.php?module=connexion&amp;action=inscrire" method="POST">
					<div id = entreeFormIns>

							<input type="text" autocomplete="off" name="prenom" placeholder="Prénom" maxlength="25" required ></br></br>
							<input type="text" autocomplete="off" name="nom" placeholder="Nom" maxlength="25" required></br></br>
							<input type="text" autocomplete="off" name="identifiant" placeholder="Identifiant" maxlength="25" required></br></br>
							<input type="email" autocomplete="off" name="mail" placeholder="Adresse e-mail" maxlength="254" required></br></br>
							<input type="email" autocomplete="off" name="mail2" placeholder="Confirmer e-mail" maxlength="254" required></br></br>
							<input type="password" autocomplete="off" name="mdp" placeholder="Mot de passe" maxlength="254" required></br></br>
							<input type="password" autocomplete="off" name="mdp2" placeholder="Confirmer mot de passe" maxlength="254" required></br></br>
							<input type="text" autocomplete="off" name="tel" placeholder="Numéro de téléphone" maxlength="10" required></br></br></br>
					</div>
				<!-------------------------------------BOUTON INSCRIPTION---------------------------------->
					<div id = buttonIns>
						
						<input type="submit" value="Inscription"/> </br>
					</form>

				</div>
				
			</div>
					';					
				$this->titre="Connexion";
		}
	}
?>
