<?php

class SSH {
  private $conn;

  function __construct($url){
    $this->conn = ssh2_connect('letoutchaud.fr');

    if (!$this->conn) throw new Exception("Echec de la connexion");
  }

  public function end(){
    ssh2_disconnect($this->conn);
  }

  public function login($id, $pwd){
    if (!ssh2_auth_password($this->conn, $id, $pwd)) {
      throw new Exception("Echec de l'identification...");
    }
  }

  public function exec($cmd){
    $output = ssh2_exec($this->conn, $cmd);
    if ($output) {
      stream_set_blocking($output, true);
      return stream_get_contents($output);
    } else {
      return "La commande ".$cmd." n'a pas fonctionné\n";
    }
  }

  public function listing($dir = "./"){
    $str = $this->exec("cd ".$dir."; ls -a;");
    return explode("\n", $str);
  }


  /////ssh2_scp_recv($conn, './index.php', './test.html')
}

/*
class FTP{
  private $conn;

  function __construct($url){
    $this->conn = ftp_connect($url);
    if (!$this->conn) throw new Exception("Echec de la connexion");
  }

  public function __call($func, $a){
    $func = 'ftp_'.$func;

    if(function_exists($func)){
      array_unshift($a, $this->conn);
      var_dump($a);
      return call_user_func_array($func, $a);
    } else {
      throw new Exception("La fonction ".$func." n'existe pas");
    }
  }
}
*/

?>
