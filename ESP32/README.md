# ESP32

## Librarys
  * ArduinoHttpClient
  * ESP32_Arduino_Servo_Libary
  * HTTPClient
  * WiFi
  * WiFiClientSecure

All ESP32 libraries are under [```lib```](lib).

Make sure to put the libraries in the correct folder, they should be in:
```
C:\Users\"Your Name"\Documents\Arduino\Libraries
```

### Schematics
<img src="schematics_servo_ESP32.jpg" height="400">
<img src="schematics_relay_ESP32.jpg" height="400">

## Setup 

### Arduino IDE
 - To use an ESP32 with the Arduino IDE you have to install the ESP32 board. If you have not installed it already follow [this](https://randomnerdtutorials.com/installing-the-esp32-board-in-arduino-ide-windows-instructions/) guide

## Variables
To run the ESP32 you need to fill out the necessary variables in the file [```ESP32_with_serial-out.ino```](ESP32_with_serial-out.ino) 

### Wi-Fi settings
To run the ESP32 you need to be connected to a WIFI network. To connect to a network you need to fill out these variables:

````cpp
const char* ssid = "Enter_info_here";
const char* password = "Enter_info_here";
````

### API settings
To make the ESP32 read of a site you need to
enter your API instead of the example server name. You can change the URL variable under:

````cpp
String serverName = "http://Enter_Domain_here/api.php?id=Enter_id_here"; 
````

### Other settings
For the pin, servo, toggel, delay and servo extention settings you use the unit list page.(only acessebel for fallback admins) More information about it can be found in [```/website/README.md```](../..website/README.md) under Unit list.

## Uploading the script
 - Make sure to select the correct board type(In our case it was the ESP32 PIKO KIT)
 - Upload to your ESP32 device
