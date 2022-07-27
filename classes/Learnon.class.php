<?php
class Learnon extends SelfRewriting{
	
/* #STARTVARS# */

	public $uuid;
	public $name = "bob";
	public $dateOfBirth;
		
/* #ENDVARS# */

/* #STARTGETTERS# */

/* #ENDGETTERS# */

/* #STARTSETTERS# */

/* #ENDSETTERS# */

/* #STARTDB# */

/* #ENDDB# */

	public function __construct() {
		$this->uuid = uniqid();
	}

    public function __call($method, $args) {
        if (isset($this->$method)) {
            $func = Closure::bind($this->$method, $this, "Learnon");
            return call_user_func_array($func, $args);
        }
    }

	public function getName() { 
		return $this->name;
	}

}
?>