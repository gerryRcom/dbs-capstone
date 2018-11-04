#This script will discover the IP address and the network address of the LAN
#apt-get install python-ipaddress required for ipaddress library
import ipaddress
import sys
#Source of IP discovery code Stackoverflow: https://stackoverflow.com/a/30990617
import socket
def get_ip_address():
    s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
    s.connect(("8.8.8.8", 80))
    return s.getsockname()[0]
netAddress = ipaddress.IPv4Network(unicode(get_ip_address()))
sys.exit(netAddress)
