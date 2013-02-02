<?php

class TableParser {
    
}

class DataSpiderModel {
    
    
    static function start () {
        
        $url = "http://basketball-bund.net/public/tabelle.jsp?print=1&viewDescKey=sport.dbb.views.TabellePublicView/index.jsp_&liga_id=";
        $ids = array("8607");
        //8607 9298
        $liga = "";
        $tabelle = "";
        $ergebnisse = "";
        $spielplan = "";							
        $statistiken = "";
        echo "starting :  ";
        
        foreach ($ids as $id) {
            
            $content = file_get_contents($url.$id);
            $dom = new DOMDocument();
            @$dom->loadHTML($content);
            
            $xp = new domxpath($dom);
            $tables = $xp->query(".//table/tr/td/table/tr/td"); 
            
            for ($i=0; $i<$tables->length; $i++) {
                
                $nodeValue = $tables->item($i)->textContent;
                
                echo $nodeValue;
            }
        }
    }
    
}

?>