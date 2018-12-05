<?php
$secondCountdown=60 - date("s");
if($_REQUEST['cmd'] == 'quickScan')
	{
		shell_exec('touch /var/www/html/commandqueue/quickScan.cmd');
		echo "Initial scan will begin in approx ".$secondCountdown." seconds, please wait and return to GUI once scan is complete</br>";
		echo "The scan might take some time depending on how many hosts being scanned</br>";
		echo "You'll know the scan is complete as the -SCAN- will stop displaying on the LED display</br>";
		echo "<a href=\"index.php\">Return to main GUI</a>";
	}
else if($_REQUEST['cmd'] == 'archiveResults')
	{
		shell_exec('touch /var/www/html/commandqueue/archiveResults.cmd');
		echo "Archiving previous results, please wait, task will run in approx ".$secondCountdown." seconds</br>";
		echo "<a href=\"index.php\">Return to main GUI</a>";
	}
else if($_REQUEST['cmd'] == 'scanDiscovered')
	{
		#shell_exec('touch /var/www/html/commandqueue/scanDiscovered.cmd');
		echo "Running scan on all discoverd hosts, scan will begin in approx ".$secondCountdown." seconds</br>";
		echo "Note if there are currently no discovered hosts the scan will return nothing</br></br>";
		echo "<a href=\"index.php\"><img src=\"images/button_home-page.png\" alt=\"Return to main GUI\" title=\"Return to main GUI\"></a>";
		if (file_exists('initialScan.xml'))
		{
			$xml = simplexml_load_file('initialScan.xml');
			foreach ($xml->host as $discoveredHost)
				{
					shell_exec('touch /var/www/html/commandqueue/'.(string)$discoveredHost->address[0]['addr'].'.cmd');
				}
		}
		else
		{
			echo "Error, no previous scan results to display";
		}
	}

else
	{
		shell_exec('touch /var/www/html/commandqueue/'.$_GET['cmd'].'.cmd');
		echo "Device scan will begin in approx ".$secondCountdown. " seconds, pleasee wait and return to the main GUI once scan is complete</br>";
		echo "You will know the scan is complete as the -SCAN- message will stop displaying on the LED display</br>";
		echo "<a href=\"index.php\">Return to main GUI</a>";
	}

?>

