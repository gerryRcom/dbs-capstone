#Returns the subnet mash of the ethernet adapter
/sbin/ifconfig eth0 | awk '/inet /{print $4}'