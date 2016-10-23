<?php
  class Kabe{
	  private $laud=[
	    ".v.v.v.v",
		"v.v.v.v.",
		".v.v.v.v",
		"r.r.r.r.",
		".r.r.r.r",
		"m.m.m.m.",
		".m.m.m.m",
		"m.m.m.m."
	  ];
	  private $aktiivserida=-1;
	  private $aktiivseveerg=-1;
	  function html(){
		  $t="<table>";
		  for($rida=0; $rida<8; $rida++){
			  $t.="\n<tr>";
			  for($veerg=0; $veerg<8; $veerg++){
				  $stiil="";
          if($this->laud[$rida][$veerg]){
					  $stiil.="width:9vh;height:9vh;";
				  }
				  if($this->laud[$rida][$veerg]!="."){
					  $stiil.="background-color: lightgray;";
				  }
				  if($rida==$this->aktiivserida && $veerg==$this->aktiivseveerg){
					  $stiil.="font-size:150%;";
				  }
				  $lahter="&nbsp;";
				  if(in_array($this->laud[$rida][$veerg], ["m", "v", "r"])){
            $kuvatavSymbol = " ";
            $symbolStiil = "";
            if($this->laud[$rida][$veerg] == "m"){
              $kuvatavSymbol = "⛂";
            }
            if($this->laud[$rida][$veerg] == "v"){
              $kuvatavSymbol = "⛀";
            }
            if($this->laud[$rida][$veerg] == "r"){
              $symbolStiil = 'style="display:block";';
            }
					  $lahter="<a href='?rida=$rida&amp;veerg=$veerg' "."$symbolStiil>".
					    $kuvatavSymbol."</a>";
				  }
				  $t.="<td style='$stiil'>$lahter</td>";
			  }
			  $t.="</tr>";
		  }
		  $t.="</table>";
		  return $t;
	  }
	  function k2ik($uusrida, $uusveerg){
      $nupp=$this->laud[$this->aktiivserida][$this->aktiivseveerg];
    if($nupp=="v" && $uusrida-($this->aktiivserida)==1 && $uusveerg-($this->aktiivseveerg)==1 || $uusveerg-($this->aktiivseveerg)==-1){
      $this->laud[$uusrida][$uusveerg]=$nupp;
      $this->laud[$this->aktiivserida][$this->aktiivseveerg]="r";
      $this->aktiivserida=-1;
      $this->aktiivseveerg=-1;}

     if($nupp=="m" && $uusrida-($this->aktiivserida)==-1 && $uusveerg-($this->aktiivseveerg)==1 || $uusveerg-($this->aktiivseveerg)==-1){
      $this->laud[$uusrida][$uusveerg]=$nupp;
		  $this->laud[$this->aktiivserida][$this->aktiivseveerg]="r";
		  $this->aktiivserida=-1;
		  $this->aktiivseveerg=-1;
	  }else{
    $this->aktiivserida=-1;
	  $this->aktiivseveerg=-1;
    }
}

	  function t88tleURL(){
 	   if(isSet($_REQUEST["rida"])){
 	     if($this->aktiivserida==-1){
			  $this->aktiivserida=intval($_REQUEST["rida"]);
			  $this->aktiivseveerg=intval($_REQUEST["veerg"]);
		 } else {
	        $uusrida=intval($_REQUEST["rida"]);
			$uusveerg=intval($_REQUEST["veerg"]);
			$this->k2ik($uusrida, $uusveerg);
		 }
		 $this->salvestaSessiooni();
	   }
	  }
	  function andmedTekstina(){
		  return json_encode(array(
		    "laud" => $this->laud,
			"aktiivnekoht" => [$this->aktiivserida, $this->aktiivseveerg]));
	  }
	  function andmedTekstist($tekst){
		  $abi=json_decode($tekst);
		  $this->laud=$abi->laud;
		  $this->aktiivserida=$abi->aktiivnekoht[0];
		  $this->aktiivseveerg=$abi->aktiivnekoht[1];
	  }
	  function salvestaSessiooni(){
		  $_SESSION["kabe"]=$this->andmedTekstina();
	  }
	  function loeSessioonist(){
		 if(isSet($_REQUEST["uusmang"])){unset($_SESSION["kabe"]);}
		 if(isSet($_SESSION["kabe"])){
		   $this->andmedTekstist($_SESSION["kabe"]);
		 }
	  }
  }
