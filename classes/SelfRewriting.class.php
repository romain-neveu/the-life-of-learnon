<?php 
define('CLASSES_DIR', 'classes');

class SelfRewriting{

	/**
	 * Les SelfRewriting Classes ont la capacité de 
	 * - Contrôller et faire évoluer, pour chacune de leur variables, l'existence de getters et setters
	 * - Contrôller et faire évoluer, pour chacune de leur variables, l'existence de requêtes à jour d'accès en BDD
	 * - Contrôller et faire évoluer, pour chacune de leur variables, l'existence d'un objet, à jour, en base de données.

	 * Pour cela, elles peuvent lire leur propre code et y effectuer des modifications. Il faut donc qu'elles respectent une certaine structure
	 * #STARTVARS# 
	 * 
	 * 	Définir ici les variables 
	 * 
	 * #ENDVARS#
	 * 
	 * #STARTGETTERS# 
	 * 
	 * 	Définir ici les Getters 
	 * 
	 * #ENDGETTERS#

	 * #STARTSETTERS# 
	 * 
	 * 	Définir ici les Setters
	 *  
	 * #ENDSETTERS#
	 * 
	 * #STARTDB# 
	 * 
	 * Définir ici les accès et méthodes d'écriture en BDD `

	 * #ENDDB#
	 */

	public function __construct($name = ""){
		$this->evolutionCheck();
	}

	private function evolutionCheck(){

		$verbose = true; 

		$className = get_class($this);
		$fileName = CLASSES_DIR."/".$className.".class.php";
 		$contenu = htmlspecialchars(file_get_contents($fileName));
 		
 		// Analyse des variables existantes
 		$startVars = strpos($contenu, "#STARTVARS#");
		$endVars = strpos($contenu, "#ENDVARS#");

		$vars = substr($contenu, ($startVars+15), (int)($endVars-$startVars-18));

		// Etude des variables
		$myVars = explode('private ', $vars); $vars = array();
		$myVars = array_filter($myVars, function($v, $k) {return (strpos($v, '$') === 0);}, ARRAY_FILTER_USE_BOTH);
		foreach($myVars as $key => $value){ array_push($vars, substr($value,1,(strpos($value, ";")-1)));}

		// Variables trouvées et disponibles dans $vars

		if($verbose){ echo sizeof($vars)." variables ont été trouvées : "; foreach($vars as $key => $value){ echo "<br /> - ".$value;}}




	}

	function addSetter($varName){

		$function = "function ";

	}

	function addGetter($varName){

	}




}



/* #STARTVARS# */

/* #ENDVARS# */
	  
/* #STARTGETTERS# */

/* #ENDGETTERS# */

/* #STARTSETTERS# */

/* #ENDSETTERS# */

/* #STARTDB# */

/* #ENDDB# */
?>
