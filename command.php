<?php

if($_REQUEST['cmd'] == 'initialScan')
	{
		shell_exec('touch /var/www/html/commandqueue/initialScan.cmd');
		echo "Initial scan running, please wait and return to GUI once scan is complete";
	}
else if($_REQUEST['cmd'] == 'cmd1')
	{
		shell_exec('touch /var/www/html/commandqueue/cmd1.cmd');
		echo "command 1 running, please wait";
	}
else if($_REQUEST['cmd'] == 'cmd2')
	{
        shell_exec('touch /var/www/html/commandqueue/cmd2.cmd');
		echo "command 2 running, please wait";
	}
?>

