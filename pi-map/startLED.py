import scrollphathd
from scrollphathd.fonts import font3x5
#Ensure text remains on display once code finishes running
scrollphathd.set_clear_on_exit(False)
scrollphathd.write_string('SCAN',font=font3x5,brightness=0.2)
scrollphathd.show()
