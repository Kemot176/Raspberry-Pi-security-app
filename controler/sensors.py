import RPi.GPIO as GPIO
import smtplib, ssl
import os
import time as t
import picamera
from settings import *
from datetime import datetime,timedelta 
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from email.mime.image import MIMEImage
from multiprocessing import Process

GPIO.setmode(GPIO.BOARD) 
GPIO.setup(12, GPIO.IN) #move sensor
GPIO.setup(10, GPIO.IN) #magnet sensor

def updateSQL(x):
    connection = pymysql.connect(host='localhost',user='tom',password='raspberry',db='security',charset='utf8mb4',cursorclass=pymysql.cursors.DictCursor,autocommit=True)
    while True:      
        m=GPIO.input(10)
        if(m==0):
            with connection.cursor() as cursor:
                sql = "UPDATE SETTINGS set magnet_sensor=0 WHERE id =1"
                cursor.execute(sql)
        if(m==1):
            with connection.cursor() as cursor:
                sql = "UPDATE SETTINGS set magnet_sensor=1 WHERE id =1"
                cursor.execute(sql)
        t.sleep(20)

def sensor(x):
    while True:
        if sensor24 == 0:
            today = datetime.now()
            now = timedelta( hours = today.hour, minutes = today.minute , seconds = today.second)
            dif = now - s_start
            if dif >= sdifference:
                print('Stand by mode - sensors')
                main()
            else:
                i=GPIO.input(12) #move
                m=GPIO.input(10) #magnet  
                if(i == 1 or m == 1):
                    if(i==1):
                        mail(get_data(), 0)
                    elif(m==1):
                        mail(get_data(), 1)
        else:
            i=GPIO.input(12) #move
            m=GPIO.input(10) #magnet  
            if(i == 1 or m == 1):
                if(i==1):
                    mail(get_data(), 0)
                elif(m==1):
                    mail(get_data(), 1)
def get_data():
    today = datetime.now();
    date = "%02d/%02d/%04d o godzinie %02d:%02d:%02d "%(today.day, today.month, today.year, today.hour, today.minute,today.second) 
    return date

def mail(date,magnet):
    print('Sending')
    msg = MIMEMultipart()
    msg['Subject'] = 'Alert monitoringu'
    msg['From'] = 'jawa.ogar@interia.pl'
    msg['To'] = 'tomasz.siedlecki97@gmail.com'
    if(magnet==1):
        text = MIMEText('W dniu: ' + date + ' doszło do otwarcia okna, sprawdź nagrania z monitoringu za pomocą aplikacji.')
    else:
        text = MIMEText('W dniu: ' + date + ' wykryto obiekt, sprawdź nagrania z monitoringu za pomocą aplikacji. Następna próba wykrycia obiektu za 15min.')
    msg.attach(text)


    smtp_server = str(email_server)
    port = int(email_port) 
    sender_email = str(email_email)
    password = str(email_psswd)
    receiver_email = str(email)
    context = ssl.create_default_context()
    try:
        server = smtplib.SMTP(smtp_server,port)
        server.ehlo()
        server.starttls(context=context)
        server.ehlo()
        server.login(sender_email, password)
        server.sendmail(sender_email, receiver_email, msg.as_string())
    except Exception as e:
        print(e)
    finally:
        server.quit() 
        t.sleep(600)
        sensor()
        
def main(w):
    if sensor24 == 0:
        while True:
            today = datetime.now()
            now = timedelta( hours = today.hour, minutes = today.minute , seconds = today.second)
            if now >= s_start and now <= s_stop:
                print('Starting sensors surveillance')
                x = Process(target = sensor, args = '1')
                x.start()
                x.join()
    else:
        x = Process(target = sensor, args = '1')
        x.start()
        x.join()
        
p = Process(target = updateSQL, args = '1')
m = Process(target = main, args = '1')
p.start()
m.start()
p.join() 
m.join()       
