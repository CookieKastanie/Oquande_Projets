<?php

class KJSImports{
  private $fileList;

  function __construct(){
    $this->fileList = array();
  }

  public function add($path){
    array_push($this->fileList, new JSFile($path, 1000));
  }

  public function getList(){
    $all = array();

    foreach ($this->fileList as $file) {
      foreach ($file->getImports() as $import) {
        array_push($all, $import);
      }
    }

    return array_reverse(array_unique($all, SORT_STRING));
  }

  public function getText(){
    $list = $this->getList();
    $str = "";

    foreach ($list as $p) $str .= "<script type=\"text/javascript\" src=\"".$p."\"></script>\n";
    return $str;
  }
}


class JSFile{
  private $path;
  private $name;
  private $imports;

  function __construct($path, $rec){
    if ($rec == 0) throw new Exception("Erreur: Boucle d'import JavaScript détecté");

    $infos = pathinfo($path);

    $this->path = $infos['dirname'];
    $this->name = $infos['basename'];

    $files = array();

    $imports = $this->readImports($this->readFile($path));
    foreach ($imports as $import) {
      array_push($files, new JSFile($import, $rec - 1));
    }

    $this->imports = $files;
  }

  public function getImports(){
    $list = array($this->path."/".$this->name);

    foreach ($this->imports as $import) {
      $list = array_merge(array_unique($list, SORT_STRING), $import->getImports());
    }

    return array_unique($list, SORT_STRING);
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
          array_push($pathList, $this->path."/".$pathBuffer);
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
