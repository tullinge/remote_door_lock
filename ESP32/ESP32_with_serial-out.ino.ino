#include <WiFi.h>
#include <HTTPClient.h>
#include <Servo.h>
#include <Stdlib.h>
Servo myservo;
// Declaration of setting varibels
int servo = 1; // Use 1 for servo and 0 for relay

int output_pin = Enter_pin_num_here; // Pinout for servo or relay
int led_pin = Enter_pin_num_here; // Pinout for LED

const char* ssid = "Enter_info_here"; // Your wifi name.
const char* password = "Enter_info_here"; // Your wifi password.

String serverName = "http://Enter_URL_here.com/api/Enter_filename_here.php"; // The URL of the API page for this ESP32.
// Defult time for delay_timer is 500ms (0.5 second) and 1000ms for act_timer.
int delay_timer = 500; // You can change the time depending on how offen you whant it to update (its not every x ms it will update its ever (x ms + time to run))
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
    delay(250);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());
 
 
  pinMode(led_pin, OUTPUT);
  digitalWrite(led_pin, LOW);
  if (servo == 1)
  {
    myservo.attach(output_pin);
    myservo.write(25);
  }
  else
  {
    pinMode(output_pin, OUTPUT);
    digitalWrite(output_pin, LOW);
  }
}
void loop()
{
  delay(delay_timer);
  digitalWrite(led_pin, LOW);
  
  if(WiFi.status()== WL_CONNECTED)//Check WiFi connection status
  {
    digitalWrite(led_pin, HIGH);
    HTTPClient http;
    String serverPath = serverName;
    http.begin(serverPath.c_str());
    // Send HTTP GET request
    int httpResponseCode = http.GET();
    Serial.print("HTTP response code: ");
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
      Serial.print("value: ");
      Serial.println(value);
      Serial.print("oldvalue: ");
      Serial.println(oldvalue);
      Serial.println();
      if (value > oldvalue)
      {
        if (servo == 1)
        {
          myservo.write(5);
          delay(act_timer);
          myservo.write(25);
        }
        else
        {
          digitalWrite(output_pin, HIGH);
          delay(act_timer);
          digitalWrite(output_pin, LOW);
        }
      oldvalue = value; 
      }
    }
    http.end();
  }
}
