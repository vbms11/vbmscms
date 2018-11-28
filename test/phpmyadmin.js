/* 
 * runs a sql using phpmyadmin using default user
 */

function executeQueryWithPhpmyadmin (query, path, appName) {
    
    var defaultPath = "http://localhost/";
    var defaultAppName = "phpmyadmin/";
    
    if (path == undefined) {
        path = defaultPath;
    }
    if (appName == undefined) {
        appName = defaultAppName;
    } 

    function isLoggedIn () {

    }

    function login (onComplete) {
        $.post(path+"import.php",{
            "token": "",
            "sql_query": query
        }, function (data) {
            var url = $(data).find(".a with token on it");
            var token = "";
            onComplete(token);
        });
    }

    function runQuery (query, token) {
        $.post(path+appName+"import.php",{
            "token": token,
            "sql_query": query
        });
    }
    
    $.get(path+appName, function (html) {
        
        if (!isLoggedIn(html)) {
            login(function (html) {
                runQuery(query, getToken(html));
            });
        } else {
            runQuery(query, getToken(html));
        }
    });
    
    
}
