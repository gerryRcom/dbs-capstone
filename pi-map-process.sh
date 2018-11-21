#!/bin/bash
#Source of function: https://stackoverflow.com/questions/50413579/bash-convert-netmask-in-cidr-notation
IPprefix_by_netmask() {
	#function returns prefix for given netmask in arg1
	 ipcalc -nb 1.1.1.1 $1 | sed -n '/Netmask/s/^.*=[ ]/\//p'
}
ipAdd=$(/sbin/ifconfig eth0 | awk '/inet /{print $2}')
ipMask=$(/sbin/ifconfig eth0 | awk '/inet /{print $4}')
ipCIDR=$(IPprefix_by_netmask $ipMask)
if [ -e /var/www/html/commandqueue/quickScan.cmd ]
	then
		#echo $ipAdd
		#echo $ipMask
		#echo $ipCIDR
		pkill python
		python /home/pi/pi-map/startLED.py
		mv /var/www/html/commandqueue/quickScan.cmd /var/www/html/commandqueue/running/
		rm /var/www/html/commandqueue/running/default.cmd
		sudo nmap -sP -oX /var/www/html/initialScan.xml $ipAdd$ipCIDR
		python /home/pi/pi-map/stopLED.py
		rm /var/www/html/commandqueue/running/quickScan.cmd

#Archive all the previous results (.xml files) in order to clear the system and prepare for a new scan
elif [ -e /var/www/html/commandqueue/archiveResults.cmd ]
	then
		pkill python
		python /home/pi/pi-map/startLED.py
		mv /var/www/html/commandqueue/archiveResults.cmd /var/www/html/commandqueue/running/
		rm /var/www/html/commandqueue/running/default.cmd
		tar -cf /var/www/html/scanarchives/$ipAdd-$ipMask.tar /var/www/html/*.xml
		rm /var/www/html/*.xml
		python /home/pi/pi-map/stopLED.py
		rm /var/www/html/commandqueue/running/archiveResults.cmd

#Run NMAP scan against selected IP addresses and output to .xml
elif [ -e /var/www/html/commandqueue/*.cmd ]
	then
		for device in /var/www/html/commandqueue/*.cmd;
		do
			deviceIP=$(basename $device .cmd)
			#echo $deviceIP
			pkill python
			python /home/pi/pi-map/startLED.py
			mv /var/www/html/commandqueue/$deviceIP.cmd /var/www/html/commandqueue/running/
			sudo nmap -O -oX /var/www/html/$deviceIP.xml $deviceIP
			python /home/pi/pi-map/stopLED.py
			rm /var/www/html/commandqueue/running/$deviceIP.cmd
		done

elif [ -e /var/www/html/commandqueue/running/*.cmd ]
	then
		#Essentially wait until running jobs finish
		echo "" > /dev/null 
#If all other commands have run then display the device IP back on the screen
else
	sudo touch /var/www/html/commandqueue/running/default.cmd
	#/usr/bin/python /home/pi/pi-map/ipLED.py $(bash /home/pi/pi-map/getIP.sh)
	
fi
