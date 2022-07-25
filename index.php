

<?php 
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
 require_once("functions.php");
 require_once("pdo.php");

	class Learnon{

		private $id;
		private $name;
		private $sexe;
		private $type;
		private $poids;
		private $genome;
		private $r;
		private $g;
		private $b;


// Setters

		public function setPoids($poids){
			$this->poids = $poids;
		}

		public function setSexe($sexe){
			$this->sexe = $sexe;
		}

		public function setType($type){
			$this->type = $type;
		}

		public function setName($name){
			$this->name = ucfirst($name);
		}

// Getters 

		public function getPoids(){
			return $this->poids;
		}

		public function getSexe(){
			return $this->sexe;
		}

		public function getType(){
			return $this->type;
		}

		public function getName(){
			return $this->name;
		}
		public function getHexa(){
			return sprintf("#%02x%02x%02x", $this->r, $this->g, $this->b);
		}

		public function __construct($name = ""){
			if($name == ""){
				$this->setName(randomName(random_int(2,8)));
			}else{
				$this->setName($name);
			}

			$this->r=random_int(0,255);
			$this->g=random_int(0,255);
			$this->b=random_int(0,255);
		}

		public function render(){
			$html='<div id="lernon'.$this->id.'" style="width: 30px; height: 30px; background-color: '.$this->getHexa().'; border-radius:50%; position: absolute;';
			$html.=' margin-left: '.random_int(5,95).'%; ';
			$html.=' margin-top: '.random_int(3,40).'%; ';
			$html.='">';

			//yeux 
			$html.='<div id="lernon'.$this->id.'Eye1" style="width: 10px; height: 10px; background-color: #000000; border-radius:50%; relative: absolute;';
			$html.=' margin-left: 5px; ';
			$html.=' margin-top: 5px; "/></div>';


			$html.='<div id="lernon'.$this->id.'Eye2" style="width: 10px; height: 10px; background-color: #000000; border-radius:50%; relative: absolute;';
			$html.=' margin-left: 15px; ';
			$html.=' margin-top: -9px; "/></div>';

			$html.='<span style="margin-top: -35px; color: '.$this->getHexa().';';
			$html.=' margin-left: -5px;'; // faire un centrage en fonction du this name length
			$html.=' display: block; position: relative;">'.$this->getName().'</span>';

			$html.='</div>';

			echo $html;
		}
	}


?>

<?php if(isset($_REQUEST["go"]) && $_REQUEST['go'] == 1) { $nbLearnons = random_int(0,100); 
	$learnons = array();
	for($i = 0; $i < $nbLearnons; $i++){
		array_push($learnons, new Learnon());
	}

	$bob = new Learnon("Bob");
 } ?>


<h1>Hello Learnons World</h1>

<form action="index.php" methode="post"><input type="hidden" name="go" value="1"/><input type="submit" value="Créer un Learnon" /></form><br />


<?php 


if(isset($learnons)){

	foreach ($learnons as $key => $learnon) {
		$learnon->render();
	}
	$bob->render();
}


?>
