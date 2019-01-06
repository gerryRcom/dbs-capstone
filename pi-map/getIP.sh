/sbin/ifconfig eth0 | awk '/inet /{print $2}'

