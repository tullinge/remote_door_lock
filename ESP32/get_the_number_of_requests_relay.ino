#include <WiFi.h>
#include <HTTPClient.h>
#include <Stdlib.h>

int pos = 0;
int relaypin = 13;
int oldvalue = 1;
int value = 1;
int led = 14;

const char* ssid = "SSID"; // The name of your wifi
const char* password = "PASSWORD"; // Ypur wifi password

//Your Domain name with URL path or IP address with path
String serverName = "HTTP://URL.COM";

// the following variables are unsigned longs because the time, measured in
// milliseconds, will quickly become a bigger number than can be stored in an int.
unsigned long lastTime = 0;
// Timer set to 10 minutes (600000)
//unsigned long timerDelay = 600000;
// Set timer to 5 seconds (5000)
unsigned long timerDelay = 5000;

void setup() {
  Serial.begin(115200); 
  WiFi.begin(ssid, password);
  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());
 
  Serial.println("Timer set to 5 seconds (timerDelay variable), it will take 5 seconds before publishing the first reading.");
  pinMode(led, OUTPUT);
  digitalWrite(led, LOW);
  pinMode(relaypin, OUTPUT);
  digitalWrite(relaypin, LOW);
  
}

void loop() {
  digitalWrite(led, LOW);
  digitalWrite(relaypin, LOW);
  //Send an HTTP POST request every 10 minutes
  if ((millis() - lastTime) > timerDelay) {
    //Check WiFi connection status
    if(WiFi.status()== WL_CONNECTED){
      HTTPClient http;
      digitalWrite(led, HIGH);
      String serverPath = serverName;
      
      // Your Domain name with URL path or IP address with path
      http.begin(serverPath.c_str());
      
      // Send HTTP GET request
      int httpResponseCode = http.GET();
      
      
      
      if (httpResponseCode>0) {
        String payload = http.getString();
        int value = atoi(payload.c_str());
        Serial.println(value);
        Serial.println(oldvalue);
        Serial.println();
        if (oldvalue<value) {
          digitalWrite(relaypin, HIGH);
          delay(1000);
          digitalWrite(relaypin, LOW);
          oldvalue = value; 
        }
        else {
          
        }
      }
      else {
        Serial.print("Error code: ");
        Serial.println(httpResponseCode);
      }
      
      
      // Free resources
      http.end();
    }
    else {
      Serial.println("WiFi Disconnected");
    }
    lastTime = millis();
  }
}
