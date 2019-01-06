<?php
//Calculate the current amount of seconds before the next minute starts to highlight when the chosen command will run
$secondCountdown=60 - date("s");
if($_REQUEST['cmd'] == 'quickScan')
	//Quick scan tells Pi-Map process to run the basic network discovery scan
	//This is a system level command so will run on the next cron task
	{
		shell_exec('touch /var/www/html/commandqueue/quickScan.cmd');
		echo "Initial scan will begin in approx ".$secondCountdown." seconds, please wait and return to GUI once scan is complete</br>";
		echo "The scan might take some time depending on how many hosts being scanned</br>";
		echo "You'll know the scan is complete as the -SCAN- will stop displaying on the LED display</br></br>";
		echo "<a href=\"index.php\"><img src=\"images/button_home-page.png\" alt=\"Return to main GUI\" title=\"Return to main GUI\"></a>";
	}
else if($_REQUEST['cmd'] == 'archiveResults')
	//Archive results tells the Pi-Map process to archive all current discovered device .xml files and then delete them, essentially wiping the system
	//This is a system level command so will run on the next cron task
	{
		shell_exec('touch /var/www/html/commandqueue/archiveResults.cmd');
		echo "Archiving previous results, please wait, task will run in approx ".$secondCountdown." seconds</br></br>";
		echo "<a href=\"index.php\"><img src=\"images/button_home-page.png\" alt=\"Return to main GUI\" title=\"Return to main GUI\"></a>";
	}
else if($_REQUEST['cmd'] == 'scanDiscovered')
	//Scan discovered will iterate through all discovered device IPs and create a scan command file for each of them which in turn will be processed by the Pi-Map process
	//This is a system level command so will run on the next cron task
	{
		echo "Running scan on all discoverd hosts, scan will begin in approx ".$secondCountdown." seconds</br>";
		echo "Note if there are currently no discovered hosts the scan will return nothing</br></br>";
		echo "<a href=\"index.php\"><img src=\"images/button_home-page.png\" alt=\"Return to main GUI\" title=\"Return to main GUI\"></a>";
		if (file_exists('initialScan.xml'))
		{
			##The network discover scan results are queried and an individual scan command is generated for each discovered IP
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
else if($_REQUEST['cmd'] == 'exportResults')
	//This checks for the existence of the network discovery scan results and if found generates a .csv file with the device details and presents a download link
	//This is a pure php command so runs immediatly
        {
                if (file_exists('initialScan.xml'))
                {
			echo "Exporting discovered devices to .csv</br>";
			echo "Note if there are no discovered hosts the file will be empty</br>";
			$xml = simplexml_load_file('initialScan.xml');
			shell_exec('> /var/www/html/scanarchives/export.csv');
			foreach ($xml->host as $discoveredHost)
			{
				shell_exec('echo '.(string)$discoveredHost->address[0]['addr'].','.(string)$discoveredHost->address[1]['addr'].','.(string)$discoveredHost->address[1]['vendor'].' >>/var/www/html/scanarchives/export.csv');
			}
			echo "View/ download .csv file from <a href=\"scanarchives/export.csv\">this location</a></br>";
		}
		else
		{
			echo "Error, no previous scan results to export";
		}
		echo "</br><a href=\"index.php\"><img src=\"images\button_home-page.png\" alt=\"Return to main GUI\" title=\"Return to main GUI\"></a>";
	}

else if($_REQUEST['cmd'] == 'shutdownDevice')
	//This sends a shutdown command file to the Pi-MAp queue with the Pi-Map process will action
	//This is a system level command so will run on the next cron task
{
	shell_exec('touch /var/www/html/commandqueue/shutdownDevice.cmd');
	echo "Device will shutdown in approx ".$secondCountdown." seconds, please wait.</br>";
}

else
	//The only other parameters that are passed to the system are device IPs, this code generates an indiividual device cmd file and queues it up for scanning
	//This is a system level command so will run on the next cron task
	{
		shell_exec('touch /var/www/html/commandqueue/'.$_GET['cmd'].'.cmd');
		echo "Device scan will begin in approx ".$secondCountdown. " seconds, pleasee wait and return to the main GUI once scan is complete</br>";
		echo "You will know the scan is complete as the -SCAN- message will stop displaying on the LED display</br></br>";
		echo "<a href=\"index.php\"><img src=\"images/button_home-page.png\" alt=\"Return to main GUI\" title=\"Return to main GUI\"></a>";
	}

?>

