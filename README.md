###dbs-capstone: https://github.com/gerryRcom/dbs-capstone

###Hardware:
</br>Model 3 B+</br>
Scroll pHAT HD Display</br>
16GB Micros SD</br>

###Steps:
</br>Download pi-map image: https://1drv.ms/f/s!AsbLqPzqmhmoibovQoSSo13lLQC8ow</br>
Use Wi32 Disk Imager to write the .img file to a minimum 16GB Micro SD Card</br>
Connect to LAN and boot Pi</br>
Access GUI through IP displayed on the LED screen (might take 60 seconds before IP displays)</br>

###Should you need to access the shell, user/ password are:
</br>User: pi</br>
Pass: lu2rmGonOaiQ.Ih!HKZK</br>

###Rough steps should you wish to manually install
</br>Install Raspbian OS (Stretch Lite) to your SD card</br>
Install (solder) the ScrollpHAT HD LED Display</br>
Install the following packages from the repository</br>
apt-get install python-scrollphathd</br>
apt-get install apache2</br>
apt-get install php7.0</br>
apt-get install nmap</br>
apt-get install php7.0-xml</br>
apt-get install python-ipaddress</br>
apt-get install ipcalc</br>
Copy the pi-map folder and it's contents to the pi users home folder</br>
Copy the rest of the files/ folders to the Apache www root folder</br>
Give the www user write access to the commandqueue and scanarchives folders within the web root folder</br>
Add a 1 min cron task to run the pi-map-process.sh</br>