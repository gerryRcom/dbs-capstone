<html><head><title>Test php</title>
<link rel="stylesheet" type="text/css" href="pi-map.css">
</head><body>
</br>
<p>
<img src="images/logo_pi-map.png" alt="Pi-Map Logo" title="Pi-Map Logo" style="float:right;width:280px;height:240px;">
<h2>Welcome to Pi-Map, hover over the controls below for more information and please note the Pi LED screen has two modes which will inform you of the current status:</h2>
<ul><li>Ready mode where the Pi-Map's current IP address will scroll accross the screen, no commands are running when this is displayed.</li>
<li>Scan mode, the word 'SCAN' will be displayed on the screen, when in this mode the device is running a scan or processing something.  Once it ends you might have to refresh the page to see the results.</li></ul>
</br>
</p>
    	<a href="command.php?cmd=quickScan"><img src="images/button_quick-network-scan.png" alt="Perform a quick discover scan of the current subnet (fast scan)" title="Perform a quick discovery scan of the current subnet (fast scan)"></a><a href="command.php?cmd=archiveResults"><img src="images/button_archive-results.png" alt="Archive current discovered hosts and clear all content" title="Archive current discovered hosts and clear all content"></a></br>

<h3>Scan Results</h3>
<div>

<?php
	if (file_exists('initialScan.xml')) {
    	$xml = simplexml_load_file('initialScan.xml');
	foreach ($xml->host as $discoveredHost){
		
		print_r("Dicovered device IP: ".(string)$discoveredHost->address[0]['addr']);
		print_r("</br>");
		print_r("Discovered device MAC: ".(string)$discoveredHost->address[1]['addr']." MAC Vendor: ".(string)$discoveredHost->address[1]['vendor']);
		print_r("</br>");
		print_r("<a href=\"command.php?cmd=".(string)$discoveredHost->address[0]['addr']."\"><img src=\"images/button_full-device-scan.png\" alt=\"Perform a full scan of this device\" title=\"Perform a full scan of this device\"></a>");
		if (file_exists((string)$discoveredHost->address[0]['addr'].".xml")){
			print_r("<a href=\"device.php?cmd=".(string)$discoveredHost->address[0]['addr']."\"><img src=\"images/button_device-scan-results.png\" alt=\"View full device scan results\" title=\"View full device scan results\"></a>");
		}
		print_r('</br></br>');
	}
} else {
    exit('No previous scan results to display');
}
?>
</div>
</body></html>
