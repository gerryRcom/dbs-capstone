#Returns the IP address of the ethernet adapter
/sbin/ifconfig eth0 | awk '/inet /{print $2}'