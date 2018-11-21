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
else
	{
		shell_exec('touch /var/www/html/commandqueue/'.$_GET['cmd'].'.cmd');
		echo "Device scan will begin in approx ".$secondCountdown. " seconds, pleasee wait and return to the main GUI once scan is complete</br>";
		echo "You will know the scan is complete as the -SCAN- message will stop displaying on the LED display</br>";
		echo "<a href=\"index.php\">Return to main GUI</a>";
	}

?>

