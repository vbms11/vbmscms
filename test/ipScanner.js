/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var IpScanner = {
    
    
};

function IpScanner () {
    
    
    /*
     * scanLocalNetwork(["phpmyadmin/","webappmanager/"],[80,8080],function(response){});
     */
    function scannLocalNetwork (paths, ports, onFoundResult) {
        
        for (var d2=0; d2<256; d2++) {
            for (var d1=0; d1<256; d1++) {
                
                var ipStr = ip[0]+"."+ip[1]+"."+ip[2]+"."+ip[3];
                var ipPort = "http://" + ipStr + ":" + ports[0] + "/";
                $.each(paths, function(index,path){
                    $.get(ipPort+path, function (response) {
                        onFoundResult({
                            "path": path,
                            "response": response
                        });
                    });
                });
            }
        }
    }
}

