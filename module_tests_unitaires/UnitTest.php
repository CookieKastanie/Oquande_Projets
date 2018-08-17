<?php

class Test{
  private $meth;
  private $params;
  private $output;
  private $res;

  function __construct($meth, $params, $output){
    $this->meth = $meth;
    $this->params = $params;
    $this->output = $output;
    $this->res = null;
  }

  public function __invoke(){
    $this->res = call_user_func_array($this->meth, $this->params);
    return $this->res == $this->output;
  }

  public function getResult(){
    return $this->res;
  }

  public function getOutput(){
    return $this->output;
  }

  public function getMethode(){
    return $this->meth;
  }

  public function getParams(){
    return $this->params;
  }
}


class UnitTest{
  private $tests;

  function __construct(){
    $this->tests = array();
  }

  public function addTest($meth, $params, $output){
    array_push($this->tests, new Test($meth, $params, $output));
  }

  public function start(){
    foreach ($this->tests as $t) {
      try {
        if($t()) $this->valide($t);
        else $this->invalide($t);
      } catch (Exception $e) {
        $this->failed($t, $e);
      }
    }
  }

  //////////////////////////////////////////////////////////

  private function echoMeth($test){
    $meth = $test->getMethode();
    if(gettype($meth) == "array") echo(get_class($meth[0])."->".$meth[1]);
    else echo($meth);

    echo("(");

    $params = $test->getParams();
    $c = count($params);
    for ($i=0; $i < $c; ++$i) {
      echo($params[$i]);
      if($i != ($c-1)) echo(",");
    }

    echo(")");
  }

  private function valide($test){
    echo "<div style=\"border:2px solid green; padding:2px; margin:2px;\">";
    $this->echoMeth($test);
    echo " : Valide";
    echo("</div>");
  }

  private function invalide($test){
    echo "<div style=\"border:2px solid yellow; padding:2px; margin:2px;\">";
    $this->echoMeth($test);
    echo " : Invalide <br>";
    echo "Sortie attandu: ".$test->getOutput()."<br>";
    echo "Sortie effective: ".$test->getResult();
    echo("</div>");
  }

  private function failed($test, $e){
    echo "<div style=\"border:2px solid red; padding:2px; margin:2px;\">";
    $this->echoMeth($test);
    echo " : Exception <br>";
    echo "Sortie attandu: ".$test->getOutput()."<br>";

    echo($e->getMessage());

    echo("</div>");
  }
}

?>
