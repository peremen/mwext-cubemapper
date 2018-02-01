<?php

$wgExtensionCredits["parserhook"][]=array(
"name"=>"CubeMapper",
"version"=>"1.0",
"author"=>"Cyrus Hackford", 
"url"=>"http://uncyclopedia.kr/wiki/사용자:Cyrus_H.",
"description"=>"[[백괴게임:큐브]]에 지도를 넣기 위한 익스텐션입니다."
);

if(defined("MW_SUPPORTS_PARSERFIRSTCALLINIT"))
	$wgHooks["ParserFirstCallInit"][]="extCubeMapperInit";
else
	$wgExtensionFunctions[]="extCubeMapperInit";
 
function extCubeMapperInit() {
	global $wgParser;
	
	$wgParser->setHook("cubemap","extCubeMap");
	
	return true;
}

/*

<cubemap block="표시 블럭" cols="열 수" highlight="#강조 색상" rows="행 수">현재 칸번호</cubemap>

*/

function extCubeMap($input,$args,&$parser) {
	if(isset($args["highlight"])===false && empty($args["highlight"])===true)
		$highlight="#FFA500";
	else
		$highlight=$args["highlight"];
	
	if(isset($args["block"])===false && empty($args["block"])===true)
		$block="█";
	else
		$block=$args["block"];
	
	if(isset($args["cols"])===false && empty($args["cols"])===true)
		$cols=16;
	else
		$cols=$args["cols"];
	
	if(isset($args["rows"])===false && empty($args["rows"])===true) {
		$rows1=17;
		$rows2=16;
	} else {
		$rows1=$args["rows"]+1;
		$rows2=$args["rows"];
	}
	
	unset($args);
	$input=$parser->recursiveTagParse($input);
	settype($input,"integer");
	
	$a=array();
	for($j=1;$j<$rows1;$j++) {
		$t="";
		for($k=0;$k<$cols;$k++) {
			if((($rows2*$k)+$j)===$input)
				$t.="<span style=\"color:".$highlight.";\">".$block."</span> ";
			else
				$t.=$block." ";
		}
		$a[16-$j]=substr($t,0,-1);
	}
	return implode("<br />",array_reverse($a));
}

?>