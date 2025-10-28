<?php
class Autoloader {

    private string $prefix;
    private string $racine;

    public function __construct(string $prefix, string $racine) {
        $this->prefix = $prefix;
        $this->racine = $racine;
    }

    public function loadClass(string $class) {
        $class = str_replace($this->prefix, "", $class);
        $class = str_replace("\\", "/", $class);
        $file = $this->racine . $class . ".php";
        if(file_exists($file)){
            require_once $file;
        }
        

    }
    public function register() {
        spl_autoload_register([new self("iutnc\\deefy", "src/"), 'loadClass']);
    }
}