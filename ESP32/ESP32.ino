#include <WiFi.h>
#include <HTTPClient.h>
#include <Servo.h>
#include <Stdlib.h>
Servo myservo;
// Declaration of setting varibels

int servo = 0; // Use 1 for servo and 0 for relay

int output_pin = 15; // Pinout for servo or relay
int led_pin = 13; // Pinout for LED

const char* ssid = "SSID"; // Your wifi name.
const char* password = "PASSWORD"; // Your wifi password.

String serverName = "http://url.com/"; // The URL of the API page for this ESP32.

int delay_time = 1000; // You can change the time depending on how offen you whant it to update (its not every x ms it will update its ever (x ms + time to run))
int act_timer = 1000; // Time from start of acton to end. For example time the relay is open, or the time the servo has to move and press a button.

// Declaration of varibels (NOT TO BE CHANGED)
int value = 1;
int oldvalue = 0;
int init_oldvalue = 0;

void setup() {
  Serial.begin(115200);
  WiFi.begin(ssid, password);
  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) {
    delay(500);
  }
  Serial.println("Connected to WiFi network with IP Address: "+WiFi.localIP()+"\n");
 
  pinMode(led_pin, OUTPUT);
  digitalWrite(led_pin, LOW);
  if (servo == 1)
  {
    myservo.attach(12);
    myservo.write(20);
  }
  else
  {
    pinMode(output_pin, OUTPUT);
    digitalWrite(output_pin, LOW);
  }
}

void loop()
{
  delay(delay_time);
  digitalWrite(led_pin, LOW);
  digitalWrite(output_pin, LOW);
  //Check WiFi connection status
  
  if(WiFi.status()== WL_CONNECTED)
  {
    digitalWrite(led_pin, HIGH);
    HTTPClient http;
    String serverPath = serverName;
    http.begin(serverPath.c_str());
    
    // Send HTTP GET request
    int httpResponseCode = http.GET();
    Serial.println(httpResponseCode);
    
    if (httpResponseCode == 200)
    {
      String payload = http.getString();
      int value = atoi(payload.c_str());
      
      if (init_oldvalue == 0)
      {
        oldvalue = value;
        init_oldvalue = 1;
      }
      Serial.println("value:"+value+"\n oldvalue:"+oldvalue);      
      if (value > oldvalue)
      {
        if (servo == 1)
        {
          myservo.write(40);
          delay(act_timer);
          myservo.write(20);
        }
        else
        {
          digitalWrite(relaypin, HIGH);
          delay(act_timer);
          digitalWrite(relaypin, LOW);
        }
      oldvalue = value; 
      }
    }
    else
    {
      Serial.println("Error code: "+httpResponseCode);
    }
    http.end();
  }
  else
  {
    Serial.println("WiFi Disconnected");
  }
}
