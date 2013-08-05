
<?php

//function connect(){
//    $host = "localhost";
//    $database = "instituto1";
//    $username = "root";
//    $password = "vendetta";
//
//    $con= mysql_connect($host,$database,$username,$password);
//
//    if(mysqli_connect_errno($con))
//    {
//        echo "failed to connect to mysql:" . mysqli_connect_errno();
//    }
//}
$location  = 'Dump.sql';
$hola = run_sql_file($location);
echo print_r($hola);
function run_sql_file($location){
    $host = "127.0.0.1";
    $database = "instituto1";
    $username = "root";
    $password = "vendetta";

    $con= mysql_connect($host,$username,$password);

    if(mysqli_connect_errno($con))
    {
        echo "failed to connect to mysql:" . mysqli_connect_errno();
    }
    else{
        echo "todo salio bien ";
    }


    //load file
    $commands = file_get_contents($location);

    //delete comments
    $lines = explode("\n",$commands);
    $commands = '';
    foreach($lines as $line){
        $line = trim($line);
        if( $line && !startsWith($line,'--') ){
            $commands .= $line . "\n";
        }
    }

    //convert to array
    $commands = explode(";", $commands);

    //run commands
    $total = $success = 0;
    foreach($commands as $command){
        if(trim($command)){
            $success += (@mysql_query($command)==false ? 0 : 1);
            $total += 1;
        }
    }

    //return number of successful queries and total number of queries found
    return array(

        "success" => $success,
        "total" => $total
    );

}




// Here's a startsWith function
function startsWith($haystack, $needle){
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}



?>