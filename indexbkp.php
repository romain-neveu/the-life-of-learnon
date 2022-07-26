

<?php 
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();
 require_once("functions.php");
//  require_once("pdo.php");

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

		// position
		private $x;
		private $y;



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

			// poids nominal = 100
			$this->poids=random_int(80, 120);

			// position
			$this->x=random_int(5,95);
			$this->y=random_int(3,40);
		}

		public function move() {
			$x = $this->x + (random_int(-1,1));
			$y = $this->y + (random_int(-1,1));

			// rebond sur les bords
			if ($x < 5) { $x = 5 + 1; }
			if ($x > 95) { $x = 95 - 1; }
			if ($y < 3) { $y = 3 + 1; }
			if ($y > 40) { $y = 40 - 1; }

			$this->x = $x;
			$this->y = $y;
		}

		public function render(){
			$html='<div id="lernon'.$this->id.'" style="width: 30px; height: 30px; background-color: '.$this->getHexa().'; border-radius:50%; position: absolute;';
			$html.=' margin-left: '.$this->x.'%; ';
			$html.=' margin-top: '.$this->y.'%; ';
			$html.=' transform: scale('.($this->poids/100.0).'); ';
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

	class Life {

		public $learnons;
		public $bob;

		public function create() {
			$nbLearnons = random_int(0,100); 
			$this->learnons = array();
			for($i = 0; $i < $nbLearnons; $i++){
				array_push($this->learnons, new Learnon());
			}
			$this->bob = new Learnon("Bob");
		}

		public function save() {
			$_SESSION["learnons"] = serialize($this->learnons);
			$_SESSION["bob"] = serialize($this->bob);
		}

		public function load() {
			if (isset($_SESSION["learnons"])) {
				$this->learnons = unserialize($_SESSION["learnons"]);
			}
			if (isset($_SESSION["bob"])) {
				$this->bob = unserialize($_SESSION["bob"]);
			}
		}

		public function iterate() {
			foreach ($this->learnons as $learnon) {
				$learnon->move();
			}
			$this->bob->move();
		}

	}
?>

<?php
$life = new Life();
$life->load();

if(isset($_REQUEST["go"]) && $_REQUEST['go'] == 1) { 
	$life->create();
}

if(isset($_REQUEST["move"]) && $_REQUEST['move'] == 1) {
	$life->iterate();
}
 
if(isset($_REQUEST["animate"]) && $_REQUEST['animate'] == 1) {
	$life->iterate();
}	

$life->save();

?>
<!DOCTYPE html>
<html>
	<head>
		<title>The life of Learnon</title>
		<style>
			form { display: inline-block; margin: 1em; }
		</style>
	</head>
	<body>
<h1>Hello Learnons World</h1>

<form action="index.php" methode="post"><input type="hidden" name="go" value="1"/><input type="submit" value="Créer un Learnon" /></form>

<?php if(isset($life->learnons)){ ?>
<form action="index.php" methode="post"><input type="hidden" name="move" value="1"/><input type="submit" value="Itérer" /></form>
<?php } ?>

<?php if(isset($life->learnons)){ ?>
<form action="index.php" methode="post" id="form_animate"><input type="hidden" name="animate" value="1"/>
<label>Interval en millisecondes</label><input type="number" name="interval" value="<?= isset($_REQUEST["interval"]) ? $_REQUEST["interval"] : 1000 ?>" />
<input type="submit" value="Animer" />
</form>
<?php } ?>

<?php if(isset($_REQUEST["animate"]) && $_REQUEST['animate'] == 1) { ?>
	<form action="index.php" methode="post"><input type="submit" value="stop" /></form>
<?php } ?>

<br />
<?php 


if(isset($life->learnons)){

	foreach ($life->learnons as $key => $learnon) {
		$learnon->render();
	}
	$life->bob->render();
}


?>

<?php if(isset($_REQUEST["animate"]) && $_REQUEST['animate'] == 1) { ?>
	<script>setTimeout(function() {
		document.getElementById("form_animate").submit();
	}, <?= $_REQUEST["interval"] ?>);</script>
<?php } ?>	

	</body>
</html>