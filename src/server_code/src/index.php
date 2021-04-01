<?php include 'controller.php';?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8">
    <title>LinuxMonServer</title>
    <link rel="stylesheet" href="style.css">
    <script src="jquery-2.2.1.js"></script>
  </head>
  <body>
  <div id="hosts" align="center">
    <h1>HOSTS</h1>
      <div align="center">
        <table>
	  <caption>Table principal</caption>
          <tr>
            <th scope="col">HostName</th>
            <th scope="col">IP</th>
            <th scope="col">Descriptions</th>
            <th scope="col">Monitor Mode</th>
          </tr>

          <?php
          for($i = 0; $i < $machine_count; $i += 1){

          if ($machines['status'][$i]){
            $color = "#00ff00";
          }else{
            $color = "#ff0000";
          }
  echo "<tr style=\"background-color:" . $color . "\">";
    echo "<div >";
      echo "<th scope=\"row\">" . $machines['name'][$i] . "</th>";
        echo "<td>" . $machines['ip'][$i] . "</td>";
        echo "<td>" . $machines['description'][$i] . "</td>";
        echo "<td>";
          if ($machines['monitor'][$i] == 1){
        echo "<form method=\"post\" action=\"monitor.php\">";
        echo "<input type=\"text\" hidden name=\"nome_do_server\" value=\"" . $machines['name'][$i] . "\"/>";
        echo "<input type=\"text\" hidden name=\"ip_do_server\" value=\"" . $machines['ip'][$i] . "\"/>";
        echo "<button id=\"btnhost";
        echo $machines['name'][$i];
        echo "\" type=\"submit\" name=\"btngetinf\">System Details</button>";
        echo "</form>";
        echo "</td>";
          }
    echo "</div>";
  echo "</tr>";
          }

	      ?>
        </table>
        </div>
  	</div>
    <script>

      $(document).ready( function(){
              setInterval(function(){
                  $('#hosts').load('/');
              }, 5000);
      });

    </script>
  </body>
</html>
