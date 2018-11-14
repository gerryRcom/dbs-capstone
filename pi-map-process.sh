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
                echo $ipAdd
                echo $ipMask
                echo $ipCIDR
                pkill python
                python /home/pi/pi-map/startLED.py
                mv /var/www/html/commandqueue/quickScan.cmd /var/www/html/commandqueue/running/
                rm /var/www/html/commandqueue/running/default.cmd
                sudo nmap -O -oX /var/www/html/initialScan.xml $ipAdd$ipCIDR
                python /home/pi/pi-map/stopLED.py
                rm /var/www/html/commandqueue/running/quickScan.cmd
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

fi
