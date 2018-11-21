<html><head><title>Device scan results</title></head><body>
</br>
<p>
<img src="images/logo_pi-map.png" alt="Pi-Map Logo" titel="Pi-Map Logo" style="float:right;width:280px;height:240px;">
<h2>Welcome to Pi-Map, hover over the controls below for more information and please note the Pi LED screen has two modes which will inform you of the current status:</h2>
</br>
</p>

<h3>Device Scan Results</h3>


<?php
        if (file_exists($_GET['cmd'].".xml")) {
        $xml = simplexml_load_file($_GET['cmd'].".xml");
        foreach ($xml->host as $discoveredHost){

                print_r("Dicovered device IP: ".(string)$discoveredHost->address[0]['addr']);
                print_r("</br>");
                print_r("Discovered device MAC: ".(string)$discoveredHost->address[1]['addr']." MAC Vendor: ".(string)$discoveredHost->address[1]['vendor']);
                print_r("</br>");
                print_r("<a href=\"command.php?cmd=".(string)$discoveredHost->address[0]['addr']."\"><img src=\"images/button_full-device-scan.png\" alt=\"Perform a full scan of this device\" title=\"Perform a full scan of this device\"></a>");
                print_r('</br></br>');
        }
} else {
    exit('No device scan results to display');
}
?>
</body></html>