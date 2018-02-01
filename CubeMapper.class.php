<?php
/**
 * Extension: CubeMapper
 * Author: Shinjo Park <peremen@gmail.com>
 * Original implementation by Cyrus Hackford
 */

class CubeMapper {
    public static function onParserFirstCallInit(Parser &$parser) {
        $parser->setHook('cubemap', array(__CLASS__, 'extCubeMap'));
        return true;
    }

    /*

    <cubemap block="표시 블럭" cols="열 수" highlight="#강조 색상" rows="행 수">현재 칸번호</cubemap>

    */

    public static function extCubeMap($input, array $args, Parser $parser, PPFrame $frame) {
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
}

?>
