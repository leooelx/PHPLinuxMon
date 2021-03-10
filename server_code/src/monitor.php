<?php

if (isset($_POST['nome_do_server'])){
    $NAME_value = $_POST['nome_do_server'];
    $IP_value   = $_POST['ip_do_server'];
}else{
    echo "Requisicao invalida";
    exit();
}

$host       = escapeshellarg("root@".$IP_value);
$commandArg = escapeshellarg("/mon/cpu");
$CPU_value  = shell_exec('ssh ' . $host . ' cat ' . $commandArg);
$commandArg = escapeshellarg("/mon/ram");
$RAM_value  = shell_exec('ssh ' . $host . ' cat ' . $commandArg);
$commandArg = escapeshellarg("/mon/users");
$USERS_value= shell_exec('ssh ' . $host . ' cat ' . $commandArg);
$commandArg = escapeshellarg("/mon/procs");
$PROC_value = shell_exec('ssh ' . $host . ' cat ' . $commandArg);
?>

<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8">
    <title>Server Monitor</title>
    <link rel="stylesheet" href="style.css">
    <script src="jquery-2.2.1.js"></script>
  </head>
  <body>
  <div id="details" align="center">
    <button onclick="goBack()">Back</button>
    <br>
    <h1>Details</h1>
        <table>
            <tr>
                <th scope="row">Hostname:</th>
                <th id="th_hostname" scope="row"><?= $NAME_value ?></th>
            </tr>
                <th scope="row">CPU: </th>
                <th id="th_cpu" scope="row"><?= $CPU_value ?></th>
            </tr>
            <tr>
                <th scope="row">RAM:</th>
                <th id="th_ram"scope="row"><?= $RAM_value ?></th>
            </tr>
            <tr>
                <th scope="row">LOGGED USERS:</th>
                <th id="th_users" scope="row"><?= $USERS_value ?></th>
            </tr>
            <tr>
                <th scope="row">OPEN PROCESS:</th>
                <th id="th_proc" scope="row"><?= $PROC_value ?></th>
            </tr>
        </table>
        </div>
        <script>
        $(document).ready( function(){
                setInterval(function(){
                    location.reload();
                }, 5000);
        });
        function goBack() {
            window.history.back();
        };
        </script>
    </body>
</html>
