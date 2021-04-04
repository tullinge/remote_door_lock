# ESP32

## Librarys
  * ArduinoHttpClient
  * ESP32_Arduino_Servo_Libary
  * HTTPClient
  * WiFi
  * WiFiClientSecure

All ESP32 libraries are under [```ESP32/lib```](ESP32/lib).

Make sure to put the libraries in the correct folder, they should be in:
```
C:\Users\"Your Name"\Documents\Arduino\Libraries
```

### Schematics
<img src="ESP32_schematic.jpg" height="400">

## Setup 
### Servo or Relay
 - If change servo to 0 for relay insted of servo
 ````
 int servo = 1;
 ````
### Pin settings
 - Enter the pin number were your relay or servo is attached to output_pin, for example 13 
 - Enter the pin number were your led (if used) is attached to led_pin, for example 15 
 ````
int output_pin = Enter_pin_num_here; 
int led_pin = Enter_pin_num_here;
 ````
### Wi-Fi settings
- Enter your Wi-Fi name to ssid
- Enter your Wi-Fi password to password
````
const char* ssid = "Enter_info_here";
const char* password = "Enter_info_here";
````
### API settings
- Enter your API insted of the exampel server name
````
String serverName = "http://Enter_URL_here.com/api/Enter_filename_here.php"; 
````
### Starting the script
 - Make sure to select the correct bord type 
   - In our case it was the ESP32 PIKO KIT
 - Upload to your ESP32 device
