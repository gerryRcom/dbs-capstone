#!/bin/bash
if [ -e /var/www/html/commandqueue/initialScan.cmd ]
	then
		python /home/pi/pi-map/startLED.py
		rm /var/www/html/commandqueue/initialScan.cmd
		sudo nmap -O -oX /var/www/html/initialScan.xml 192.168.50.50
		python /home/pi/pi-map/stopLED.py
#elif [ $2 == 'yes' ]
	#then
	   #        echo You may go to the party but be back before midnight.
	    #else
   #    echo You may not go to the party.
fi
