#Set script o run every minute via Crontab
#* * * * * /bin/bash /home/pi/pi-map/pi-map-process.sh >>/var/log/pi-map.log
#!/bin/bash
if [ -e /var/www/html/commandqueue/initialScan.cmd ]
    then
        rm /var/www/html/commandqueue/initialScan.cmd
        sudo nmap -oX /var/www/html/initialScan.xml 192.168.50.0/24
#elif [ $2 == 'yes' ]
#   then
#        echo You may go to the party but be back before midnight.
#else
#    echo You may not go to the party.
fi
