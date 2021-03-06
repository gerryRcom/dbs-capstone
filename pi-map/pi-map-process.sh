#!/bin/bash
#Source of function: https://stackoverflow.com/questions/50413579/bash-convert-netmask-in-cidr-notation
IPprefix_by_netmask() {
	#function returns prefix for given netmask in arg1
	 ipcalc -nb 1.1.1.1 $1 | sed -n '/Netmask/s/^.*=[ ]/\//p'
}
ipAdd=$(/sbin/ifconfig eth0 | awk '/inet /{print $2}')
ipMask=$(/sbin/ifconfig eth0 | awk '/inet /{print $4}')
ipCIDR=$(IPprefix_by_netmask $ipMask)
#Network discovery scan is selected run a full scan of current subnet, subnet determined by code above
if [ -e /var/www/html/commandqueue/quickScan.cmd ]
	then
		pkill python
		python /home/pi/pi-map/startLED.py
		mv /var/www/html/commandqueue/quickScan.cmd /var/www/html/commandqueue/running/
		rm /var/www/html/commandqueue/running/default.cmd
		sudo nmap -sP -oX /var/www/html/initialScan.xml $ipAdd$ipCIDR
		python /home/pi/pi-map/stopLED.py
		rm /var/www/html/commandqueue/running/quickScan.cmd

#Shutdown the Pi-Map device
elif [ -e /var/www/html/commandqueue/shutdownDevice.cmd ]
	then
		python /home/pi/pi-map/stopLED.py
		pkill python
		rm /var/www/html/commandqueue/shutdownDevice.cmd
		rm /var/www/html/commandqueue/running/default.cmd
		sudo shutdown now
		

#Archive all the previous results (.xml files) in order to clear the system and prepare for a new scan
elif [ -e /var/www/html/commandqueue/archiveResults.cmd ]
	then
		archiveDT="archived-$(date '+%d%m%Y-%H%M%S').tar"
		pkill python
		python /home/pi/pi-map/startLED.py
		mv /var/www/html/commandqueue/archiveResults.cmd /var/www/html/commandqueue/running/
		rm /var/www/html/commandqueue/running/default.cmd
		tar -cf /var/www/html/scanarchives/$archiveDT /var/www/html/*.xml
		rm /var/www/html/*.xml
		python /home/pi/pi-map/stopLED.py
		rm /var/www/html/commandqueue/running/archiveResults.cmd

#Run NMAP scan against selected IP addresses and output to .xml
#Used compgen as opposed to -e as -e does not work with wildcard/ multiple files
elif compgen -G "/var/www/html/commandqueue/*.cmd" > /dev/null
	then
		mv /var/www/html/commandqueue/*.cmd /var/www/html/commandqueue/running/
		for device in /var/www/html/commandqueue/running/*.cmd
		do
			deviceIP=$(basename $device .cmd)
			echo $deviceIP >> /var/log/pimap2.log
			pkill python
			python /home/pi/pi-map/startLED.py
			rm /var/www/html/commandqueue/running/default.cmd
			sudo nmap -O -oX /var/www/html/$deviceIP.xml $deviceIP
			python /home/pi/pi-map/stopLED.py
			touch /var/www/html/commandqueue/running/default.cmd
			rm /var/www/html/commandqueue/running/$deviceIP.cmd
		done
		rm /var/www/html/commandqueue/running/default.cmd
#Check if there is a current job in the running queue
#elif [ -e /var/www/html/commandqueue/running/*.cmd ]
elif compgen -G "/var/www/html/commandqueue/running/*.cmd" > /dev/null
	then
		#Essentially wait until running jobs finish
		echo "" > /dev/null
#If all other commands have run then display the device IP back on the screen, IP returned by getIP.sh script
else
	sudo touch /var/www/html/commandqueue/running/default.cmd
	/usr/bin/python /home/pi/pi-map/ipLED.py $(bash /home/pi/pi-map/getIP.sh)
	
fi
