import pymysql.cursors
import pymysql
connection = pymysql.connect(host='localhost',
                             user='',
                             password='',
                             db='',
                             charset='utf8mb4',
                             cursorclass=pymysql.cursors.DictCursor)
try:
    with connection.cursor() as cursor:
        sql = "select * from SETTINGS where id =1"
        cursor.execute(sql)
        record = cursor.fetchone()

        restart = int(record['restart'])
  
        #sensor settings
        sensor24=int(record['sensor_all_time'])
        s_start = record['s_start']
        s_stop = record['s_stop']
        email= str(record['email'])
        sdifference=s_stop-s_start
        #record settings
        record24=int(record['record_all_time'])
        t_start=record['t_start']
        t_stop=record['t_stop']  
        resolutionV= int(record['resolutionV']) 
        resolutonH=int(record['resolutionH']) 
        framerate=int(record['framerate']) 
        time=int(record['time']) 
        difference=t_stop-t_start
        space_limit = 8000000000
        #password settings
        camera_name = "admin"
        camera_psswd = "admin"
        #email settings
        email_server = "" 
        email_port = 587
        email_email = ""
        email_psswd = ""
finally:
    print('Database reading OK')
    connection.close()







