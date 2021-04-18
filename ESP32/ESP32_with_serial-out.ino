// These lines includes all the libaries needed
#include <WiFi.h>
#include <HTTPClient.h>
#include <Servo.h>
#include <Stdlib.h>
#include <StringSplitter.h>

Servo myservo;
// Declaration of setting varibels
int servo = 0; // Use 1 for servo and 0 for relay
int toggle = 1; // Use 1 for toggel betwene closed/pressed and open/retracted for every time you request or 0 for a quick closing/press and opening/retraction for every request.

int output_pin = Enter_pin_num_here; // Pinout for servo or relay
int led_pin = Enter_pin_num_here; // Pinout for LED

const char* ssid = "Enter_info_here"; // Your wifi name.
const char* password = "Enter_info_here"; // Your wifi password.

String serverName = "http://Enter_URL_here/api/Enter_filename_here.php"; // The URL of the API page for this ESP32.
// Defult time for delay_timer is 500ms (0.5 second) and 1000ms for act_timer.
int delay_timer = 500; // You can change the time depending on how offen you whant it to update (its not every x ms it will update its ever (x ms + time to run))
int act_timer = 1000; // Time from start of acton to end. For example time the relay is open, or the time the servo has to move and press a button.

// Declaration of varibels (NOT TO BE CHANGED)
int value = 1;
int oldvalue = 0;
int init_oldvalue = 0;
int toggle_state = 0;

// This is the setup
void setup() {
  // These lines of code connects to your wi-fi
  Serial.begin(115200); 
  WiFi.begin(ssid, password);  
  
  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) 
  {
    delay(250);
    Serial.print(".");
  }
  // These lines of codes print out the IP adress
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());
 
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
  
  // Used to redefine pin if the output_pin and led_pin has been changed
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
    Serial.print("HTTP response code: ");
    Serial.println(httpResponseCode);
    
    // This line chcks if the http response code is OK
    if (httpResponseCode == 200)
    {
      // These lines of code converts the string from the API to seperated strngs
      String payload = http.getString();
      Serial.println(payload);
      Serial.println();
      StringSplitter *splitter = new StringSplitter(payload, ',', 50);
      
      // redefines value from the string
      String item_0 = splitter->getItemAtIndex(0);
      int temp_0 = String(item_0).toInt();
      value = temp_0;
      Serial.print("value: ");
      Serial.println(value);
      
      // redefines servo from the string
      String item_1 = splitter->getItemAtIndex(1);
      int temp_1 = String(item_1).toInt();
      servo = temp_1;
      Serial.print("servo: ");
      Serial.println(servo);
      
      // redefines toggle from the string
      String item_2 = splitter->getItemAtIndex(2);
      int temp_2 = String(item_2).toInt();
      toggle = temp_2;
      Serial.print("toggle: ");
      Serial.println(toggle);
      
      // redefines delay_timer from the string
      String item_3 = splitter->getItemAtIndex(3);
      int temp_3 = String(item_3).toInt();
      delay_timer = temp_3;
      Serial.print("Delay timer: ");
      Serial.println(delay_timer);
      
      // redefines act_timer from the string
      String item_4 = splitter->getItemAtIndex(4);
      int temp_4 = String(item_4).toInt();
      act_timer = temp_4;
      Serial.print("Act timer: ");
      Serial.println(act_timer);
      
      // redefines output_pin from the string
      String item_5 = splitter->getItemAtIndex(5);
      int temp_5 = String(item_5).toInt();
      output_pin = temp_5;
      Serial.print("Output pin: ");
      Serial.println(output_pin);
      
      // redefines led_pin from the string
      String item_6 = splitter->getItemAtIndex(6);
      int temp_6 = String(item_6).toInt();
      led_pin = temp_6;
      Serial.print("LED pin: ");
      Serial.println(led_pin);
      
      // These lines of code prevents boot up signals
      if (init_oldvalue == 0)
      {
        oldvalue = value;
        init_oldvalue = 1;
      }
      // These lines prints the old and new value
      Serial.print("value: ");
      Serial.println(value);
      Serial.print("oldvalue: ");
      Serial.println(oldvalue);
      Serial.println();
      
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