import pymysql.cursors
import os
import time as t
import pymysql
from multiprocessing import Process

def restartPi():
    connection = pymysql.connect(host='localhost',
                                user='tom',
                                password='raspberry',
                                db='security',
                                charset='utf8mb4',
                                cursorclass=pymysql.cursors.DictCursor,autocommit=True)
    with connection.cursor() as cursor:
        sql = "UPDATE SETTINGS set restart=0, app_status=0, preview=0 where id =1"
        cursor.execute(sql)
    try:   
        os.system ('sudo pkill -f recording.py & sudo pkill -f sensors.py & sudo pkill -f motion')    
    except:
        print('OFF')
def onAPP(x):
    try:
        os.system ('sudo pkill -f motion.py')
        os.system ('python3 /var/www/html/controler/recording.py & python3 /var/www/html/controler/sensors.py ')
        print('Surveillance - ON')
    except:
        os.system ('python3 /var/www/html/controler/recording.py & python3 /var/www/html/controler/sensors.py ')
        print('Surveillance - ON')
    
def onPREVIEW(x):
    try:
        os.system ('sudo pkill -f recording.py & sudo pkill -f sensors.py')
        os.system ('python3 /var/www/html/controler/motion.py')
        print('Live steam - ON')
    except:
        os.system ('python3 /var/www/html/controler/motion.py')
        print('Live steam - ON')
    
def main(x,y):
    temp_status=x
    temp_preview=y
    while True:
        connection = pymysql.connect(host='localhost',
                                user='tom',
                                password='raspberry',
                                db='security',
                                charset='utf8mb4',
                                cursorclass=pymysql.cursors.DictCursor,autocommit=True)
        with connection.cursor() as cursor:
            sql = "select restart, app_status, preview from SETTINGS where id =1"
            cursor.execute(sql)
            record = cursor.fetchone()
            restart= int(record['restart'])
            status = int(record['app_status'])
            preview = int(record['preview'])        
        if(restart==1):
            connection.close()
            restartPi()
        if(status == 1 and temp_status == 0):
            x = Process(target = main, args = (1,0))
            p = Process(target = onAPP, args = ('1'))  
            x.start()
            p.start()
            x.join()
            p.join()        
        if(status == 0 and temp_status == 1): 
            os.system ('sudo pkill -f recording.py & sudo pkill -f sensors.py')
            print('Surveillance - OFF')
        if(preview == 1 and temp_preview==0):
            x = Process(target = main, args = (0,1))
            y = Process(target = onPREVIEW, args = ('1'))
            x.start()
            y.start()
            x.join()
            y.join()
        if(preview == 0 and temp_preview==1):
            os.system ('sudo pkill -f motion.py')
            print('Live stream - OFF')  
        temp_status = status
        temp_preview = preview
        t.sleep(3)
main(0,0)



