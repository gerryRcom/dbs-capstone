<html><head><title>Test php</title></head><body>
</br></br>
        <a href="command.php?cmd=quickScan">Run ping scan of network (quick)</a></br>
        <a href="command.php?cmd=cmd1">Command 1</a></br>

<?php
        if (file_exists('initialScan.xml')) {
        $xml = simplexml_load_file('initialScan.xml');
        foreach ($xml->host as $discoveredHost){

                print_r("<a href=\"command.php?cmd=".(string)$discoveredHost->address[0]['addr']."\">Deep Scan Of: ".(string)$discoveredHost->address[0]['addr']."</a>");
                print_r('</br>');
        }
} else {
    exit('No previous scan results to display');
}
?>
</body></html>
