<?php
	require_once("modele_itineraire.php");
	require_once("vue_itineraire.php");
	
	class ControleurItineraire extends ControleurGenerique{
			
		public function main(){
			
			$this->model=new ModeleItineraire();
			$this->vue=new VueItineraire();

			/*TODO*/
			
			$requeteSQL="Select * from inf345_30.Itineraire where active=true";
			
			if(isset($_GET["action"]) && $_GET["action"]=="trier"){
				if(($requeteSQL=$this->nouvelleRequete($requeteSQL))==false){
					$this->vue->vue_erreur("Vous avez mal renseigné la date, elle doit respectée la forme: dd-mm-yyyy ");
					return;
				}
			}
			
			//var_dump($requeteSQL);
			
			try{
				if(!($produits=$this->model->getProduits($requeteSQL))){
					$this->vue->vue_erreur("Aucun produit trouvé");		
					return;
				}
			}
			catch(ModeleVenteException $e){
				$this->vue->vue_erreur("La requête n'a pas pu aboutir :/");
				return;
			}

			$this->vue->afficherProduits($produits);
		}
		
		private function nouvelleRequete($requeteSQL){
			
			if(isset($_POST["paysDepart"]) && $_POST["paysDepart"]!=""){
				$requeteSQL.=" and paysDepart like '%".htmlspecialchars($_POST["paysDepart"])."%'";
			}			
			
			if(isset($_POST["villeDepart"]) && $_POST["villeDepart"]!=""){
				$requeteSQL.=" and villeDepart like '%".htmlspecialchars($_POST["villeDepart"])."%'";
			}		
			if(isset($_POST["paysArrivee"]) && $_POST["paysArrivee"]!=""){
				$requeteSQL.=" and paysArrivee like '%".htmlspecialchars($_POST["paysArrivee"])."%'";
			}		

			if(isset($_POST["villeArrivee"]) && $_POST["villeArrivee"]!=""){
				$requeteSQL.=" and villeArrivee like '%".htmlspecialchars($_POST["villeArrivee"])."%'";
			}					
			
			if(isset($_POST["prixMin"]) && is_numeric($_POST["prixMin"])){
				$requeteSQL.=" and prix>=".htmlspecialchars($_POST["prixMin"]);
			}
			
			if(isset($_POST["prixMax"]) && is_numeric($_POST["prixMax"])){
				$requeteSQL.=" and prix<=".htmlspecialchars($_POST["prixMax"]);
			}

			if(isset($_POST["dateMin"]) && $_POST["dateMin"]!=""){
				if(($dateMin=$this->transformDate($_POST["dateMin"]))==false){
					return false;				
				}
				$requeteSQL.=" and CAST(dateDepart as DATE)>=".$dateMin;
			}	
			
			if(isset($_POST["dateMax"]) && $_POST["dateMax"]!=""){
				if(($dateMax=$this->transformDate($_POST["dateMin"]))==false){
					return false;				
				}
				$requeteSQL.=" and CAST(dateDepart as DATE)<=".$dateMax;
			}
			
			if(isset($_POST["nbPassager"]) && is_numeric($_POST["nbPassager"])){
				$requeteSQL.=" and (nbPassagersMax-nbPassager)>=".htmlspecialchars($_POST["nbPassager"]);
			}		
			
			if(isset($_POST['smoke'])){
				switch($_POST['smoke']){
					case "noSmoke" :
						$requeteSQL.=" and smoke=false";
						break;
					case "smoke" :
						$requeteSQL.=" and smoke=true";
						break;		
					default:
					
						break;			
				}
			}
			
			if(isset($_POST['pet'])){
				switch($_POST['pet']){
					case "noPet" :
						$requeteSQL.=" and pet=false";
						break;
					case "pet" :
						$requeteSQL.=" and pet=true";
						break;
					default:
					
						break;					
				}
			}
			
			if(isset($_POST['bagage'])){
				switch($_POST['bagage']){
					case "noBagage" :
						$requeteSQL.=" and bagage=false";
						break;
					case "bagage" :
						$requeteSQL.=" and bagage=true";
						break;					
					default:
					
					break;
				}
			}
				
				
			if(isset($_POST['trie'])){
				switch($_POST['trie']){
					case "prixCrois" :
						$requeteSQL.=" order by prix";
						break;
					case "plusRecent" :
						$requeteSQL.=" order by dateDepart";
						break;
					case "moinsRecent" :
						$requeteSQL.=" order by dateDepart desc";
						break;
					case "nombrePlaceDispo":
						$requeteSQL.=" order by (nbPassagersMax-nbPassager) desc";
						break;
					default:
						$requeteSQL.=" order by dateDepart";
				}
			}		
				
			else{
				$requeteSQL.=" order by dateDepart";	
			}
			
			return $requeteSQL;
		}
		
		private function transformDate($dateDepart){
			$explodedDateDepart=explode("-", trim(htmlspecialchars($dateDepart), " "));

			if(sizeof($explodedDateDepart)!=3){
				return false;
			}
			
			$day=$explodedDateDepart[0];
			$month=$explodedDateDepart[1];
			$year=$explodedDateDepart[2];

			if(strlen($day)>2 || strlen($month)>2 || strlen($year)>4 || !is_numeric($day)|| !is_numeric($month)|| !is_numeric($year) || $day<0 || $month<0 || $month>12 || $year<2000
			|| !($day!=30 && $day!=31 && $day!=28 && $day!=29 || $day==31 && ($month==1 || $month==3 || $month==5 || $month==7 || $month==8 || $month==10 || $month==12) || $day==30 && ($month==4 || $month==6 || $month==9 || $month==11) || $day==28 && $day==29 && $month==2) ){
				return false;	
			}
		
			return $year."-".$month."-".$day;
		}
		
		/*
		private function andOrWhere(){
			$var1="and";
			global $where;
			if(!$where){
				$where=true;
				$var1="where";
			}
			return $var1;
		}*/
	}
	?>
