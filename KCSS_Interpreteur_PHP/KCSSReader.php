<?php

/*

<sequence> ->  @ <nom> { [ <var> | <block> | <sequence> ] }         <- pas de @<nom> ni de '{}' pour root
<var> ->  $ <nom> ( : <valeur> )
<block> ->  ( . | # | : ) <tag> { [ <var> | <attribut> | <block> ] }
<attribut> ->  <nomProp> : [ <valeur> | <var> ]
<nom> ->  *
<valeur> ->  * ; | \n
<tag> -> liste
<nomProp> -> liste

*/

class Words {

  private static $tags = array("a","abbr","acronym","address","applet","area","article","aside","audio","b","base","basefont","bdo","big","blockquote","body","br","button","canvas","caption","center","cite","code","col","colgroup",
  "datalist","dd","del","dfn","div","dl","dt","em","embed","fieldset","figcaption","figure","font","footer","form","frame","frameset","head","header","h1","h2","h3","h4","h5","h6",
  "hr","html","i","iframe","img","input","ins","kbd","label","legend","li","link","main","map","mark","meta","meter","nav","noscript","object","ol","optgroup","option","p","param",
  "pre","progress","q","s","samp","script","section","select","small","source","span","strike","strong","style","sub","sup","table","tbody","td","textarea","tfoot","th","thead","time","title",
  "tr","u","ul","var","video","wbr","*");

  private static $pseudoElements = array("active",":after",":before","checked","disabled","empty","enabled","first-child",":first-letter",":first-line","first-of-type","focus","hover","in-range","invalid",
  "last-child","last-of-type","link","only-of-type","only-child","optional","out-of-range","read-only","read-write","required","target","valid","visited","root",":selection"
  );

  private static $pseudoElementsParam = array("lang","not","nth-child","nth-last-child","nth-last-of-type","nth-of-type");

  private static $inParams = array("+", "-", " ");

  private static $separators = array(","," ",">","+","~");

  private static $inAttribut = array("=","~","|","^","$","*","_",".",'"',"'"," ");

  private static $inMedia = array(":","-",",","(",")"," ");

  private static $mediaTypes = array("@charset","@font-face","@font-feature-values","@import","@media","@keyframes",);

  private static $properties = array("align-content","align-items","align-self","all","animation","animation-delay","animation-direction","animation-duration","animation-fill-mode","animation-iteration-count","animation-name","animation-play-state","animation-timing-function","backface-visibility","background","background-attachment","background-blend-mode","background-clip","background-color","background-image","background-origin","background-position","background-repeat","background-size","border","border-bottom","border-bottom-color","border-bottom-left-radius","border-bottom-right-radius","border-bottom-style","border-bottom-width","border-collapse","border-color","border-image","border-image-outset","border-image-repeat","border-image-slice","border-image-source","border-image-width","border-left","border-left-color","border-left-style","border-left-width","border-radius","border-right","border-right-color","border-right-style","border-right-width","border-spacing","border-style","border-top","border-top-color","border-top-left-radius","border-top-right-radius","border-top-style","border-top-width","border-width","bottom","box-decoration-break","box-shadow","box-sizing","break-after","break-before","break-inside","caption-side","caret-color","clear","clip","color","column-count","column-fill","column-gap","column-rule","column-rule-color","column-rule-style","column-rule-width","column-span","column-width","columns","content","counter-increment","counter-reset","cursor","direction","display","empty-cells","filter","flex","flex-basis","flex-direction","flex-flow","flex-grow","flex-shrink","flex-wrap","float","font","font-family","font-feature-settings","font-kerning","font-language-override","font-size","font-size-adjust","font-stretch","font-style","font-synthesis","font-variant","font-variant-alternates","font-variant-caps","font-variant-east-asian","font-variant-ligatures","font-variant-numeric","font-variant-position","font-weight","grid","grid-area","grid-auto-columns","grid-auto-flow","grid-auto-rows","grid-column","grid-column-end","grid-column-gap","grid-column-start","grid-gap","grid-row","grid-row-end","grid-row-gap","grid-row-start","grid-template","grid-template-areas","grid-template-columns","grid-template-rows","hanging-punctuation","height","hyphens","image-rendering","isolation","justify-content","left","letter-spacing","line-break","line-height","list-style","list-style-image","list-style-position","list-style-type","margin","margin-bottom","margin-left","margin-right","margin-top","max-height","max-width","min-height","min-width","mix-blend-mode","object-fit","object-position","opacity","order","orphans","outline","outline-color","outline-offset","outline-style","outline-width","overflow","Specifies what happens if content overflows an element's box","overflow-wrap","overflow-x","overflow-y","padding","padding-bottom","padding-left","padding-right","padding-top","page-break-after","page-break-before","page-break-inside","perspective","perspective-origin","pointer-events","position","quotes","resize","right","tab-size","table-layout","text-align","text-align-last","text-combine-upright","text-decoration","text-decoration-color","text-decoration-line","text-decoration-style","text-indent","text-justify","text-orientation","text-overflow","text-shadow","text-transform","text-underline-position","top","transform","transform-origin","transform-style","transition","transition-delay","transition-duration","transition-property","transition-timing-function","unicode-bidi","user-select","vertical-align","visibility","white-space","widows","width","word-break","word-spacing","word-wrap","writing-mode","z-index");



  public static function tagExist($tag){
    foreach (self::$tags as $t) {
      if($tag == $t) return true;
    }

    return false;
  }

  /*
    return:
    0 -> n'existe pas
    1 -> simple
    2 -> avec params
  */
  public static function pseudoElementsExist($elem){
    foreach (self::$pseudoElements as $t) {
      if($elem === $t) return 1;
    }

    foreach (self::$pseudoElementsParam as $t) {
      if($elem === $t) return 2;
    }

    return 0;
  }

  public static function isSeparator($sep){
    foreach (self::$separators as $t) {
      if($sep === $t) return true;
    }

    return false;
  }

  public static function propertieExist($prop){
    foreach (self::$properties as $t) {
      if($prop === $t) return true;
    }

    return false;
  }

  public static function attributCharExist($c){
    foreach (self::$inAttribut as $t) {
      if($c === $t) return true;
    }

    return false;
  }

  public static function paramCharExist($p){
    foreach (self::$inParams as $t) {
      if($p == $t) return true;
    }

    return false;
  }

  public static function mediaExist($m){
    foreach (self::$mediaTypes as $t) {
      if($m == $t) return true;
    }

    return false;
  }

  public static function mediaCharExist($m){
    foreach (self::$inMedia as $t) {
      if($m == $t) return true;
    }

    return false;
  }
}


///////////////////////////////////////////////



class Node {
  protected $childs;

  function __construct() {
    $this->childs = array();
  }

  public function addChild($c){
    if($c) array_push($this->childs, $c);
  }

  public function getChilds(){
    return $this->childs;
  }

  public function haveChilds(){
    return count($this->childs) > 0;
  }

  //public function toCSS($p){}
}

class Sequence extends Node{
  private $root;
  private $nom;
  private $mediaChilds;

  function __construct($root = false) {
    parent::__construct();
    $this->root = $root;
    $this->nom = "";
    $this->mediaChilds = array();
  }

  public function isRoot(){
    return $this->root;
  }

  public function addMediaChild($c){
    if($c) array_push($this->mediaChilds, $c);
  }

  public function getMediaChilds(){
    return $this->mediaChilds;
  }

  public function haveMediaChilds(){
    return count($this->mediaChilds) > 0;
  }

  public function setNom($n){
    $this->nom = trim($n);
  }

  public function getNom(){
    return $this->nom;
  }

  public function toCSS(){
    $arr = array();

    foreach ($this->childs as $c) {
      $c->toCSS($arr, new RegleCSS());
    }

    $str = "";

    foreach ($arr as $regle) {
      if ($regle->haveAttributes()) {
        $str .= $regle->getNom() . "{";
        foreach ($regle->getAttributes() as $att) {
          $str .= $att->getNom() .":". $att->getVal() .";";
        }

        $str .= "}";
      }
    }

    foreach ($this->getMediaChilds() as $s) {
      if($s->haveChilds() || $s->haveMediaChilds()) $str .= $s->getNom() . '{' . $s->toCSS() . '}';
    }

    return $str;
  }
}

class Block extends Node{
  private $nom;
  private $attributes;

  function __construct() {
    parent::__construct();
    $this->nom = "";
    $this->attributes = array();
  }

  public function setNom($n){
    $this->nom = trim($n);
  }

  public function getNom(){
    return $this->nom;
  }

  public function addAttribute($att){
    array_push($this->attributes, $att);
  }

  public function getAttributes(){
    return $this->attributes;
  }

  public function toCSS(&$arr, $rcss){
    $rcss->addNom($this);
    $rcss->setAttributes($this->getAttributes());
    array_push($arr, $rcss);

    foreach ($this->getChilds() as $a) {
      $a->toCSS($arr, $rcss->dupliquer());
    }
  }
}


class RegleCSS {
  private $nom;
  private $attributes;

  function __construct($nom = "", $attrs = null) {
    $this->nom = $nom;
    $this->attributes = $attrs;
  }

  public function setAttributes($attrs){
    $this->attributes = $attrs;
  }

  public function getAttributes(){
    return $this->attributes;
  }

  public function haveAttributes(){
    return count($this->attributes) > 0;
  }

  public function addNom(&$block){
    $arrParent = explode(',', $this->getNom());
    $arrEnfant = explode(',', $block->getNom());

    $arr = array();

    for ($i = 0; $i < count($arrParent); ++$i) {
      for ($j = 0; $j < count($arrEnfant); ++$j) {
        $spe = $arrEnfant[$j][0];
        array_push($arr, $arrParent[$i] . (($spe == ':' || $spe == '[' || $arrParent[$i] == '') ? "" : " ") . $arrEnfant[$j]);
      }
    }

    $this->nom = join(',', $arr);
  }

  public function getNom(){
    return $this->nom;
  }

  public function dupliquer(){
    return new RegleCSS($this->getNom(), $this->getAttributes());
  }
}

class Attribut extends Node{
  private $nom;
  private $val;

  function __construct() {
    parent::__construct();
    $this->nom = "";
    $this->val = "";
  }

  public function setNom($n){
    $this->nom = trim($n);
  }

  public function getNom(){
    return $this->nom;
  }

  public function setVal($v){
    $this->val = trim($v);
  }

  public function getVal(){
    return $this->val;
  }
}

class KCSSReader {
  private $text;
  private $length;
  private $pointer;
  private $currentLine;
  private $currentCol;
  private $vars;
  private $feuille;
  private $path;


  function __construct() {
    $this->resetAll();
  }

  private function resetAll(){
    $this->resetAtts();
    $this->resetVars();
  }

  private function resetAtts(){
    $this->text = null;
    $this->length = 0;
    $this->pointer = 0;
    $this->currentLine = 0;
    $this->currentCol = 0;
    $this->path = "KCSS Anonyme";
  }

  private function resetVars(){
    $this->vars = array();
  }

  public function readKCSS($text){
    $this->resetAll();
    $this->readKCSSText($text);
  }

  private function readKCSSText($text){
    $this->text = $this->prePoc($text);

    $this->length = strlen($this->text);
    $this->pointer = 0;

    $this->currentLine = 1;
    $this->currentCol = 0;

    $this->feuille = $this->readSequence(true);
  }

  public function readKCSSFile($paths){
    $this->resetAll();

    $t = gettype($paths);
    $list;
    if($t == "string") $list = array($paths);
    else $list = $paths;

    foreach ($list as $path) {
      $this->path = $path;

      if(!file_exists($path)) $this->exception("Fichier '".$path."' introuvable");

      ob_start();
      require($path);
      $text = ob_get_clean();

      $this->readKCSSText($text);
    }
  }

  public function writeCSS(){
    if($this->feuille) return $this->feuille->toCSS();
    return "";
  }

  public function writeCSSFile($path){
    $file = fopen($path, "w");
    fwrite($file, $this->writeCSS());
    fclose($file);
  }

////////////////////////////////////////////////////////////////////////////////

  private function prePoc($text){
    $finalText = "";

    $commentChar = null;
    $wait = false;

    for ($i = 0; $i < strlen($text)-1; ++$i) {
      $c1 = $text[$i];
      $c2 = $text[$i+1];

      $wait = false;

      if(!$commentChar){
        if($c1 == '/' && $c2 == '/') $commentChar = chr(10);
        else if ($c1 == '/' && $c2 == '*') $commentChar = '*';
      } else {
        if(ord($commentChar) == 10 && $this->isNewLine($c1)) $commentChar = null;
        else if ($commentChar == '*' && $c1 == '*' && $c2 == '/'){
          $commentChar = null;
          $wait = true;
          ++$i;
        }
      }

      if((!$commentChar && !$wait) || $this->isNewLine($c1)) $finalText .= $c1;
    }

    return $finalText;
  }

  private function notEOF(){
    return $this->pointer < $this->length;
  }

  private function readChar($offset = 0){
    $index = $this->pointer + $offset;
    if($index >= $this->length) return 0;
    return $this->text[$index];
  }

  private function nextChar($n = 1){
    while ($n--) {
      ++$this->currentCol;

      if($this->readChar() == "\n"){
        ++$this->currentLine;
        $this->currentCol = 0;
      }

      ++$this->pointer;
    }
  }

  private function skipSpaces(){
    $c = $this->readChar();
    while (ord($c) <= 32){
      $this->nextChar();
      $c = $this->readChar();
    }
  }

  private function isSimpleChar($c){
    $v = $c ? ord($c) : $c;
    return ($v >= 97 && $v <= 122) || ($v >= 65 && $v <= 90) || ($v >= 48 && $v <= 57 || $v == 95 || $v == 45);
  }

  private function isNewLine($c){
    $code = ord($c);
    return $code == 10 || $code == 13;
  }

  private function readNom($move = false){
    $buffer = "";
    $offset = 0;

    $c = $this->readChar();
    while($this->isSimpleChar($c)){
      $buffer .= $c;
      $c = $this->readChar(++$offset);
    }

    if ($move) $this->nextChar($offset);

    return $buffer;
  }

  private function exception($str){
    $error = "
    <div style=\"border: 2px solid red;border-radius:20px;padding:1em;display:inline-block;\">
      <span>{$this->path}: {$str}</span><br>
      <span style=\"padding-left:1em;\">- Ligne: {$this->currentLine}</span><br>
      <span style=\"padding-left:1em;\">- Colonne: {$this->currentCol}</span><br>
    </div>
    ";

    throw new Exception($error);
  }


//////////////////////////////////////////////////////////////


  private function readSequence($root = false){
    $seq = new Sequence($root);

    $this->skipSpaces();

    if(!$root){
      if($this->readChar() != '@') return null;

      $this->nextChar();

      $nomFinal = "@";

      $c = $this->readChar();

      $fisrtWord = true;

      while ($this->isSimpleChar($c) || Words::mediaCharExist($c) || $c == '?') {
        if($c == '?') {

          $this->nextChar();
          $nomFinal .= $this->readVarVal();
          $c = $this->readChar();

        } else {
          $nomFinal .= $c;
          $this->nextChar();
          $c = $this->readChar();

          if($fisrtWord && ($c == ' ' || $c == '{')){
            $fisrtWord = false;
            if(!Words::mediaExist($nomFinal)) $this->exception("Le type de bloc '".$nomFinal."' n'existe pas");
          }
        }
      }

      $this->skipSpaces();

      if($this->readChar() != '{') $this->exception("Jeton imprévu -> '".$this->readChar()."'");
      $this->nextChar();

      $seq->setNom($nomFinal);
    }


    $this->skipSpaces();


    while ($this->notEOF() && !(!$root && $this->readChar() == '}')) {

      if(!$this->readVar()){
        $node = $this->readSequence();
        if($node) $seq->addMediaChild($node);
        else {
          $node = $this->readBlock();

          if ($node) $seq->addChild($node);

          else $this->exception("Il y a une erreur autour de:");
        }
      }

      $this->skipSpaces();

    }

    if(!$root){
      if($this->readChar() != '}') $this->exception("Jeton imprévu -> '".$this->readChar()."'");
      $this->nextChar();
    }

    return $seq;
  }



  private function readVar(){
    if($this->readChar() != '?') return false;

    $this->nextChar();
    $nomVar = $this->readNom(true);

    $this->skipSpaces();

    if($this->readChar() != ':') $this->exception("Séparateur ':' manquant");

    $this->nextChar();
    $this->skipSpaces();

    $buffer = "";
    $c = $this->readChar();
    while($c != ';' && !$this->isNewLine($c)){
      $buffer .= $c;
      $this->nextChar();
      $c = $this->readChar();
    }

    if($c == ';') $this->nextChar();

    $this->vars[$nomVar] = $buffer;

    $this->skipSpaces();

    return true;
  }

  private function readVarVal(){
    $nomVar = $this->readNom(true);
    if(!isset($this->vars[$nomVar])) $this->exception("La variable '".$nomVar."' n'existe pas");
    return $this->vars[$nomVar];
  }


  private function readBlock(){
    $block = new Block();

    $nomFinal = "";

    do {
      $c = $this->readChar();

      if ($c != ':' && $c != '[') {
        if($c == '.' || $c == '#'){
          $nomFinal .= $c;
          $this->nextChar();
          $nomFinal .= $this->readNom(true);
        } else if ($c == '*'){
          $nomFinal .= $c;
          $this->nextChar();
        } else {
          $buff = $this->readNom(true);

          if(Words::tagExist($buff)) $nomFinal .= $buff;
          else {
           $this->exception("Le tag '".$buff."' n'existe pas");
          }
        }
      }


      if($this->readChar() == '['){

        $nomFinal .= '[';

        $this->nextChar();

        $c = $this->readChar();

        while($this->isSimpleChar($c) || Words::attributCharExist($c) || $c == '?'){
          if($c == '?') {

            $this->nextChar();
            $nomFinal .= $this->readVarVal();
            $c = $this->readChar();

          } else {

            $nomFinal .= $c;
            $this->nextChar();
            $c = $this->readChar();

          }
        }

        if($this->readChar() != ']') $this->exception("Jeton imprévu -> '".$this->readChar()."'");

        $nomFinal .= ']';

        $this->nextChar();
      }


      if($this->readChar() == ':') {

        $nomFinal .= ':';

        $buffer = "";
        $this->nextChar();

        $c = $this->readChar();

        while($this->isSimpleChar($c) || $c == '-' || $c == ':'){
          $buffer .= $c;

          $this->nextChar();
          $c = $this->readChar();
        }

        $type = Words::pseudoElementsExist($buffer);

        if ($type == 1) {
          $nomFinal .= $buffer;
        } else if ($type == 2) {
          $nomFinal .= $buffer;

          if($this->readChar() != '(') $this->exception("Jeton imprévu -> '".$this->readChar()."'");

          $nomFinal .= '(';

          $this->nextChar();

          $c = $this->readChar();

          while ($this->isSimpleChar($c) || Words::paramCharExist($c) || $c == '?') {
            if($c == '?') {

            $this->nextChar();
            $nomFinal .= $this->readVarVal();
            $c = $this->readChar();

            } else {
              $nomFinal .= $c;
              $this->nextChar();
              $c = $this->readChar();
            }
          }

          if($this->readChar() != ')') $this->exception("Jeton imprévu -> '".$this->readChar()."'");

          $nomFinal .= ')';

          $this->nextChar();

        } else {
         $this->exception("Le sélecteur '".$buffer."' n'existe pas");
        }
      }


      $sep = $this->readChar();
      if (Words::isSeparator($sep)) {
        $this->nextChar();
        $this->skipSpaces();
        if (Words::isSeparator($this->readChar())){
          $nomFinal .= $this->readChar();
          $this->nextChar();
          $this->skipSpaces();
        } else {
          $nomFinal .= $sep;
        }
      } else {
        $this->skipSpaces();
        if($this->readChar() != '{') return null;
      }

    } while ($this->readChar() != '{');

    $block->setNom($nomFinal);

    $this->nextChar();

    $this->skipSpaces();

    while ($this->readChar() != '}') {

      if(!$this->readVar()){
        $node = $this->readAttribut();
        if ($node) $block->addAttribute($node);
        else{
          $node = $this->readBlock();
          if ($node) $block->addChild($node);
        }

        if (!$node) {
          $this->skipSpaces();
          if ($this->readChar() != '}') {
           $this->exception("Fermeture du bloc '".$block->getNom()."' introuvable");
          }
        }
      }

      $this->skipSpaces();
    }

    $this->nextChar();

    return $block;
  }


  private function readAttribut(){
    $att = new Attribut();

    $buff = $this->readNom();
    $c = $this->readChar();
    if((!$this->isSimpleChar($c) && $c != '@') || Words::tagExist($buff)) return null;

    $buffer = "";
    $offset = 0;

    $c = $this->readChar();
    while($this->isSimpleChar($c) || $c == '-' || $c == '@'){
      $buffer .= $c;
      $c = $this->readChar(++$offset);
    }

    if (!Words::propertieExist($buffer)) $this->exception("La propriété '".$buffer."' n'existe pas");

    $att->setNom($buffer);

    $this->nextChar($offset);
    $this->skipSpaces();
    if ($this->readChar() != ':') $this->exception("Séparateur ':' manquant");
    $this->nextChar();
    $this->skipSpaces();


    $valBuffer = "";
    $c = $this->readChar();
    $previousChar = $c;

    while ($c != ';' && !$this->isNewLine($c) && $c != '}') {
      if($this->readChar() == '?'){
        $this->nextChar();
        $valBuffer .= $this->readVarVal();

      } else {
        if($c != ' ' || $previousChar != ' ') $valBuffer .= $c;
        $this->nextChar();
      }

      $previousChar = $c;
      $c = $this->readChar();
    }

    if ($c == ';') $this->nextChar();

    $att->setVal($valBuffer);

    return $att;
  }

}

?>
