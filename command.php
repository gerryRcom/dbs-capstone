<?php

if($_REQUEST['cmd'] == 'quickScan')
        {
                shell_exec('touch /var/www/html/commandqueue/quickScan.cmd');
                echo "Initial scan running, please wait and return to GUI once scan is complete</br>";
                echo "The scan might take some time depending on how many hosts being scanned</br>";
                echo "You'll know the scan is complete as the -SCAN- will stop displaying on the LED display</br>";
                echo "<a href=\"index.php\">Return to home GUI</a>";
        }
else if($_REQUEST['cmd'] == 'cmd1')
        {
                shell_exec('touch /var/www/html/commandqueue/cmd1.cmd');
                echo "command 1 running, please wait";
        }
else if($_REQUEST['cmd'] == 'cmd2')
        {
                echo "command 2 running, please wait";
        }
else
        {
                shell_exec('touch /var/www/html/commandqueue/'.$_GET['cmd'].'.cmd');
        }

?>
