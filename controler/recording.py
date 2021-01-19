import os
import time
import picamera
from datetime import datetime,timedelta 
from settings import *

folder = "videos"

def delete_oldest():
    oldest_file = sorted([ folder+'/'+f for f in os.listdir(folder)], key=os.path.getctime)[0]
    os.remove(oldest_file)
    return check_disc_space()

def get_data(folder):
    today = datetime.now();
    data_result = "%s/%02d%02d%04d_%02d_%02d"%(folder, today.day, today.month, today.year, today.hour, today.minute) 
    return data_result

def take_video(path):
    with picamera.PiCamera() as camera:
        camera.resolution = (resolutionV, resolutonH)
        camera.framerate = framerate
        camera.start_recording(path+'.h264',splitter_port=2)
        camera.wait_recording(time,splitter_port=2)
        camera.stop_recording(splitter_port=2)
    if record24 == 1:
        return check_disc_space()
    else:
        return check_date()

def check_disc_space():
    stat = os.statvfs('./videos')
    result = stat.f_bsize * stat.f_bavail
    if result > space_limit : #23GB
        f_name = get_data(folder)
        take_video(f_name)
    else:
        delete_oldest()

def check_date():
    today = datetime.now()
    now = timedelta( hours = today.hour, minutes = today.minute , seconds = today.second)
    dif = now - t_start
    if dif >= difference:
        exit_program()
    else:
        check_disc_space()

def exit_program():
    print('Stand by mode - record')
    main()

def main(): 
    if record24 == 0:
        while True:
            today = datetime.now()
            now = timedelta( hours = today.hour, minutes = today.minute , seconds = today.second)
            if now >= t_start and now<=t_stop:
                print('Starting camera surveillance')
                check_disc_space()
    else:
        check_disc_space()
main()