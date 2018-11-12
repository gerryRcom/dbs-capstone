#Displays the IP on the LED screen, IP passed as an argument to script
import scrollphathd
import signal
import time
import sys
from scrollphathd.fonts import font3x5
scrollphathd.set_clear_on_exit(False)
scrollphathd.write_string("---"+sys.argv[1],y=1,font=font3x5,brightness=0.2)
x = 1
while x == 1:
    scrollphathd.show()
    scrollphathd.scroll()
    time.sleep(0.2)
