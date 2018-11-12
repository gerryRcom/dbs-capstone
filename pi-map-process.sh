#!/bin/bash
if [ -e /var/www/html/commandqueue/initialScan.cmd ]
        then
                pkill python
                python /home/pi/pi-map/startLED.py
                mv /var/www/html/commandqueue/initialScan.cmd /var/www/html/commandqueue/running/
                rm /var/www/html/commandqueue/running/default.cmd
                sudo nmap -O -oX /var/www/html/initialScan.xml 192.168.50.50
                python /home/pi/pi-map/stopLED.py
                rm /var/www/html/commandqueue/running/initialScan.cmd
#elif [ $2 == 'yes' ]
        #then
           #        echo You may go to the party but be back before midnight.
            #else
   #    echo You may not go to the party.
elif [ -e /var/www/html/commandqueue/running/*.cmd ]
        then
                #Essentially wait until running jobs finish
                echo "" > /dev/null
#If all other commands have run then display the device IP back on the screen
else
        sudo touch /var/www/html/commandqueue/running/default.cmd
        /usr/bin/python /home/pi/pi-map/ipLED.py $(bash /home/pi/pi-map/getIP.sh)
        #sudo touch /var/www/html/commandqueue/running/default.cmd

fi
