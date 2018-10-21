<?php

class KImports{
  private $pathList;

  function __construct(){
    $this->pathList = array();
  }

  public function add($path){
    new ImportedFile($this->pathList, $path, 10000);
  }

  public function getList(){
    return $this->pathList;
  }

  /*public function getText(){
    $list = $this->getList();
    $str = "";

    foreach ($list as $p) $str .= "<script type=\"text/javascript\" src=\"".$p."\"></script>\n";
    return $str;
  }*/
}


class ImportedFile{
  private $path;
  private $pathList;

  function __construct(&$pathList, $path, $rec){
    if ($rec == 0) throw new Exception("Erreur: Boucle d'import détecté");
    $this->pathList = &$pathList;

    $infos = pathinfo($path);

    $this->path = $infos['dirname'];
    $name = $infos['basename'];

    $this->addToPathList($this->path."/".$name);

    $imports = $this->readImports($this->readFile($path));
    foreach ($imports as $import) {
      new ImportedFile($this->pathList, $import, $rec - 1);
    }
  }

  private function addToPathList($p){
    if(!in_array($p, $this->pathList)) {
      array_unshift($this->pathList, $p);
      return true;
    }

    return false;
  }

  //////////////////////////////////

  private function readImports($text){
    $buffer = "";

    $pathBuffer = "";
    $find = false;

    $pathList = array();

    for ($i = 0; $i < strlen($text); ++$i) {
      $c = $text[$i];

      if ($find) {
        if ($c != ">") {
          $pathBuffer .= $c;
        } else {
          if($this->addToPathList($this->path."/".$pathBuffer)) array_push($pathList, $this->path."/".$pathBuffer);
          $find = false;
          $buffer = "";
        }
      }

      $buffer .= $c;
      if($buffer[0] != "<") $buffer = "";
      if($buffer == "<import "){
        $find = true;
        $pathBuffer = "";
      }
    }

    return $pathList;
  }

  private function readFile($path){
    if(!file_exists($path)) throw new Exception("Fichier '".$path."' introuvable");

    ob_start();
    require($path);
    return ob_get_clean();
  }
}

?>
