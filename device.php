<html><head><title>Device scan results</title>
<link rel="stylesheet" type="text/css" href="pi-map.css">
</head><body>
</br>
<p>
<img src="images/logo_pi-map.png" alt="Pi-Map Logo" title="Pi-Map Logo" style="float:right;width:280px;height:240px;">
<h2>Welcome to Pi-Map, hover over the controls below for more information and please note the Pi LED screen has two modes which will inform you of the current status:</h2>
<ul>
<li>Ready mode where the Pi-Map's current IP address will scroll accross the screen, no commands are running when this is displayed.</li>
<li><img src="images/screen_ip.jpg" alt="Image of LED display in ready mode" title="Image of LED display in ready mode"></li>
<li>Scan mode, the word 'SCAN' will be displayed on the screen, when in this mode the device is running a scan or processing something.  Once it ends you might have to refresh the page to see the results.</li>
<li><img src="images/screen_scan.jpg" alt="Image of LED display in Scan mode" title="Image of LED display in Scan mode"></li>
</ul>
</br>
</p>
<a href="index.php"><img src="images/button_home-page.png" alt="Return to main home page" title="Return to main home page"></a>
<h3>Device Scan Results</h3>
<div>
<?php
        if (file_exists($_GET['cmd'].".xml")) {
        $xml = simplexml_load_file($_GET['cmd'].".xml");
        foreach ($xml->host as $discoveredHost){

                print_r("<strong>Device IP: </strong>".(string)$discoveredHost->address[0]['addr']);
                print_r("</br>");
                print_r("<strong>Device MAC: </strong>".(string)$discoveredHost->address[1]['addr']."<strong> MAC Vendor: </strong>".(string)$discoveredHost->address[1]['vendor']);
                print_r("</br>");
                print_r("<strong>Device OS: </strong>".(string)$discoveredHost->os->osmatch['name']."<strong> OS Accuracy: </strong>".(string)$discoveredHost->os->osmatch['accuracy']."%");
		print_r('</br></br>');
	
	foreach ($xml->host->ports->port as $discoveredPorts){
		print_r("<strong>Discovered port: </strong>".(string)$discoveredPorts['portid']."</br>"); 
	} 
	}}
	
	else {
    exit('No device scan results to display');
}
?>
</div>
</body></html>
