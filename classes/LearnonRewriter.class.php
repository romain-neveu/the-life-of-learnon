<?php
class LearnonRewriter {

    public Learnon $learnon;
    public ReflectionObject $reflectObject;

    public function __construct(Learnon $learnon) {
        $this->learnon = $learnon;
        $this->reflectObject = new ReflectionObject($this->learnon);
    }

    public function getClassBody() {
        $verbose = true;
        $codeLines = [];
        // Class declaration
        $codeLines[] = "class Learnon" . $this->learnon->uuid . " { ";
        $codeLines[] = "";
        // Properties

        if($verbose) echo "<b>Voici la liste des propriétés :</b><br />";
        foreach ($this->listProperties() as $property) {
            $codeLines[] = "\t" . $this->getPropertyBody($property);
            if($verbose) echo "- ".$property->getName()." <br />";

        }
        $codeLines[] = "";
        

        // Methods
            if($verbose) echo "<br /><b>Voici la liste des méthodes :</b><br />";
            foreach ($this->listMethods() as $method) {
                foreach ($this->getMethodBody($method) as $codeLine) {
                    $codeLines[] = "\t" . $codeLine;
                }
                $codeLines[] = "";
                if($verbose) echo "- ".$method->getName()." <br />";
            }
        // Functions (methods found in properties because set at runtime)
            if($verbose) echo "<br /><b>Voici la liste des fonctions :</b><br />";
            foreach ($this->listFunctions() as $functionName => $function) {
                foreach ($this->getFunctionBody($functionName, $function) as $codeLine) {
                    $codeLines[] = "\t" . $codeLine;
                }
                $codeLines[] = "";
                if($verbose) echo "- ".$function->getName()." <br />";
            }
        $codeLines[] = "}";
        return join("\n", $codeLines);
    }

    public function listProperties(): array {
        $properties = [];
        // list properties name
        foreach ($this->reflectObject->getProperties() as $property) {
            // Some properties can be functions, we only want properties here
            if($this->isProperty($property)) {
                // store name and current value
                $properties[$property->getName()] = $property;
            }
        }
        return $properties;
    }

    public function isProperty(ReflectionProperty $property)  {
        // the way we do it, some function are considered properties
        return ($property->isDefault() || isset($this->learnon->{$property->getName()})) && !is_callable($this->learnon->{$property->getName()});
    }

    public function isFunction(ReflectionProperty $property)  {
        // the way we do it, some function are considered properties
        return ($property->isDefault() || isset($this->learnon->{$property->getName()})) && is_callable($this->learnon->{$property->getName()});
    }

    public function listMethods()  {
        $methods = [];
        foreach ($this->reflectObject->getMethods() as $method) {
            $methods[$method->getName()] = $method;
        }
        return $methods;
    }

    public function listFunctions()  {
        $functions = [];
        // Some properties can be function (added dynamically at runtime)
        foreach ($this->reflectObject->getProperties() as $property) {
            if ($this->isFunction($property)) {
                $function = new ReflectionFunction($this->learnon->{$property->getName()});
                $functions[$property->getName()] = $function;
            }
        }
        return $functions;
    }

    public function getPropertyBody(ReflectionProperty $property)  {
        $code = "public $" . $property->getName() . "";
        $value = $property->getValue($this->learnon);
        if ($value != null) {
            $code .= " = " . $this->getPropertyBodyValue($value);
        }
        $code .= ";";
        return $code;
    }
 
    public function getPropertyBodyValue($value) {
        $result = null;
        switch (gettype($value)) {
            case "boolean":
                $result = $value ? "true" : "false";
                break;
            case "integer":
            case "double":
                $result = $value;
                break;
            case "string":
                $result = "\"" . $value . "\"";
                break;
            default:
                break;
        }
        return $result;
    }

    public function getMethodBody(ReflectionMethod $method)  {
        $codeLines[] = "public function " . $method->getName() . "() {";
        // read body from source code
        $fileContent = file($method->getFileName());
        // indent from first line (to have a pretty output)
        $indentationOnFirstLine = preg_replace("/^(\s*).*\n?/m", "$1", $fileContent[$method->getStartLine()]);
        for($lineNumber = $method->getStartLine(); $lineNumber < $method->getEndLine() - 1; $lineNumber++) {
            $codeLines[] = "\t" . str_replace($indentationOnFirstLine, "", rtrim($fileContent[$lineNumber]));
        }
        $codeLines[] = "}";
        return $codeLines;
    }

    public function getMethodName(ReflectionMethod $method)  {
        return $method->getName();
    }

    public function getFunctionBody(string $functionName, ReflectionFunction $function)  {
        $codeLines[] = "public function " . $functionName . "() {";
        // read body from source code
        $fileContent = file($function->getFileName());
        // indent from first line (to have a pretty output)
        $indentationOnFirstLine = preg_replace("/^(\s*).*\n?/m", "$1", $fileContent[$function->getStartLine()]);
        for($lineNumber = $function->getStartLine(); $lineNumber < $function->getEndLine() - 1; $lineNumber++) {
            $codeLines[] = "\t" . str_replace($indentationOnFirstLine, "", rtrim($fileContent[$lineNumber]));
        }
        $codeLines[] = "}";
        return $codeLines;
    }

}
?>