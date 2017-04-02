<nav id ="testNav">
	<ul class="niveau1">

		 
		<?php 
			if(isset($_SESSION["identifiant"]) && $_SESSION["identifiant"]!="" && isset($_SESSION["mdp"]) && $_SESSION["mdp"]!="" && isset($_SESSION["admin"]) && $_SESSION["admin"]!=NULL){
				echo '<li><a class="menu" href="index.php?action=deconnexion">Déconnexion</a></li>';
				if($_SESSION["admin"]==true){?>
					<li><a class="menu" href="index.php?module=course">Gérer itinéraire</a></li>
					<li><a class="menuF" href="index.php?module=compte">Gérer comptes</a></li>		
					</nav>				
					<?php return; 
				}
			}
			else{
				echo '<li><a class="menu" href="index.php?module=connexion">Connexion</a></li>';
			}
		?>
		<li><a class="menu">Conducteur<img class="fleche" src="images/arrow-bas.png"></a>
			<ul class="niveau2">
			
				<li><a class="menuF" href="index.php?module=course">Créer course</a></li>
				<li><a class="menuF" href="index.php?module=mesCourses&amp;action=course">Voir mes courses</a></li>
			</ul>
		</li>
		<li><a class="menu">Passager<img class="fleche" src="images/arrow-bas.png"></a>
			<ul class="niveau2">

				<li><a class="menuF" href="index.php?module=itineraire">Chercher itinéraire</a></li>
				<li><a class="menuF" href="index.php?module=mesCourses&amp;action=trajet">Voir mes trajets</a></li>

			</ul>
		</li>

		<li><a class="menuF" href="index.php?module=profil">Profil</a></li>
	</ul>
</nav>
