// These lines includes all the libaries needed
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

// This is the setup
void setup() 
{
  // These lines of code connects to your wi-fi
  WiFi.begin(ssid, password);
  while(WiFi.status() != WL_CONNECTED) {
    delay(250);
  }
 
  // These are for the debug led
  pinMode(led_pin, OUTPUT);
  digitalWrite(led_pin, LOW);
  
  // These lines of code checks if you are using a servo or relay
  if (servo == 1)
  {
    // These lines are for the servo code
    myservo.attach(output_pin);
    myservo.write(25);
  }
  else
  {
    // These lines are for the relay code
    pinMode(output_pin, OUTPUT);
    digitalWrite(output_pin, LOW);
  }
}
void loop()
{
  delay(delay_timer);
  
  // This line of code sets the led status to low
  digitalWrite(led_pin, LOW);
  
  //Check WiFi connection status
  if(WiFi.status()== WL_CONNECTED)
  {
    // This sets the led status to high
    digitalWrite(led_pin, HIGH);
    
    // These lines connects the ESP32 to your API
    HTTPClient http;
    String serverPath = serverName;
    http.begin(serverPath.c_str());
    
    // Send HTTP GET request
    int httpResponseCode = http.GET();
    
    // This line chcks if the http response code is OK
    if (httpResponseCode == 200)
    {
      // These lines of code converts the string from the API to an int
      String payload = http.getString();
      int value = atoi(payload.c_str());
      
      // These lines of code prevents boot up signals
      if (init_oldvalue == 0)
      {
        oldvalue = value;
        init_oldvalue = 1;
      }
      
      // These lines of code checks if value is greater then the old value and runs the code
      if (value > oldvalue)
      {
        if (toggle == 1)
        {
          if (toggle_state == 0)
          {
            if (servo == 1)
            {
              // This is the code which makes the servo run
              myservo.write(25);
            }
            else
            {
              // This is the code which makes the relay run
              digitalWrite(output_pin, LOW);
            }
            toggle_state = 1;
          }
          else
          {
            if (servo == 1)
            {
              // This is the code which makes the servo run
              myservo.write(5);
            }
            else
            {
              // This is the code which makes the relay run
              digitalWrite(output_pin, HIGH);
            }
            toggle_state = 0;
          }
          Serial.println(toggle_state);
        }
        else
        {
          if (servo == 1)
          {
            // This is the code which makes the servo run
            myservo.write(5);
            delay(act_timer);
            myservo.write(25);
          }
          else
          {
            // This is the code which makes the relay run
            digitalWrite(output_pin, HIGH);
            delay(act_timer);
            digitalWrite(output_pin, LOW);
          }
        }
      oldvalue = value; 
      }
    }
    // This line ends the connection to the API
    http.end();
  }
}
