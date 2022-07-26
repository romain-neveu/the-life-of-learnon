<?php 
define('CLASSES_DIR', './classes');

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
		echo "Controle en cours <br />";
		$this->evolutionCheck();
	}

	private function evolutionCheck(){
		$className = get_class($this);
		$fileName = CLASSES_DIR."/".$className.".class.php";
		echo "Je dois ouvrir le fichier ".$fileName."<br />";
		$file = fopen($fileName, 'r+');
		var_dump($file);
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
