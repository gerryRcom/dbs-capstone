import scrollphathd
import signal
import time
import sys
from scrollphathd.fonts import font3x5
#Ensure IP continues being displayed even when the script finishes running
scrollphathd.set_clear_on_exit(False)
#Take string to be displayed from an argument which will be passed when called
scrollphathd.write_string("---"+sys.argv[1],y=1,font=font3x5,brightness=0.2)
x = 1
#Condition was required to maintain scrolling of text on screen (IP was too big to fit without scrolling)
while x == 1:
    scrollphathd.show()
    scrollphathd.scroll()
    time.sleep(0.2)
