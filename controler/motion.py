import http.server
import cgi
import io
import base64
import json
import picamera
from datetime import datetime,timedelta 
from threading import Condition
from urllib.parse import urlparse, parse_qs
from settings import *

PAGE="""\<center><img style="height:90%; width=90%;" src="stream.mjpeg" ></center>"""

def get_data():
    today = datetime.now();
    folder = 'videos'
    data_result = "%s/%02d%02d%04d_%02d_%02d"%(folder, today.day, today.month, today.year, today.hour, today.minute) 
    return data_result

class StreamingOutput(object):
    def __init__(self):
        self.frame = None
        self.buffer = io.BytesIO()
        self.condition = Condition()

    def write(self, buf):
        if buf.startswith(b'\xff\xd8'):
            self.buffer.truncate()
            with self.condition:
                self.frame = self.buffer.getvalue()
                self.condition.notify_all()
            self.buffer.seek(0)
        return self.buffer.write(buf)

class CustomServerHandler(http.server.BaseHTTPRequestHandler):

    def do_AUTHHEAD(self):
        self.send_response(401)
        self.send_header(
            'WWW-Authenticate', 'Basic realm="Camera login and password"')
        self.send_header('Content-type', 'application/json')
        self.end_headers()

    def do_GET(self):
        key = self.server.get_auth_key()
        ''' Present frontpage with user authentication. '''
        if self.headers.get('Authorization') == None:
            self.do_AUTHHEAD()
            
        elif self.headers.get('Authorization') == 'Basic ' + str(key):
            if self.path == '/':
                self.send_response(301)
                self.send_header('Location', '/index.php')
                self.end_headers()
            elif self.path == '/index.php':
                content = PAGE.encode('utf-8')
                self.send_response(200)
                self.send_header('Content-Type', 'text/html')
                self.send_header('Content-Length', len(content))
                self.end_headers()
                self.wfile.write(content)
            elif self.path == '/stream.mjpeg':
                self.send_response(200)
                self.send_header('Age', 0)
                self.send_header('Cache-Control', 'no-cache, private')
                self.send_header('Pragma', 'no-cache')
                self.send_header('Content-Type', 'multipart/x-mixed-replace; boundary=FRAME')
                self.end_headers()
                try:
                    while True:
                        with output.condition:
                            output.condition.wait()
                            frame = output.frame
                        self.wfile.write(b'--FRAME\r\n')
                        self.send_header('Content-Type', 'image/jpeg')
                        self.send_header('Content-Length', len(frame))
                        self.end_headers()
                        self.wfile.write(frame)
                        self.wfile.write(b'\r\n')
                except Exception as e:
                    print("Remove client")
        else:
            self.do_AUTHHEAD()
    def _parse_GET(self):
        gv = parse_qs(urlparse(self.path).query)
        return gv
        
class CustomHTTPServer(http.server.HTTPServer):
    key = ''
    def __init__(self, address, handlerClass=CustomServerHandler):
        super().__init__(address, handlerClass)
    def set_auth(self, username, password):
        self.key = base64.b64encode(bytes('%s:%s' % (username, password), 'utf-8')).decode('ascii')
    def get_auth_key(self):
        return self.key

if __name__ == '__main__':
     with picamera.PiCamera() as camera:
        camera.resolution = (resolutionV, resolutonH)
        camera.framerate = framerate
        output = StreamingOutput()
        camera.start_recording(output, format='mjpeg')
        camera.start_recording(get_data()+'.h264', splitter_port=2, resize=(1920, 1080))
        try:
            server = CustomHTTPServer(('', 8080))
            server.set_auth(camera_name, camera_psswd)
            server.serve_forever()
        finally:
            camera.stop_recording(splitter_port=2)
            camera.stop_recording()