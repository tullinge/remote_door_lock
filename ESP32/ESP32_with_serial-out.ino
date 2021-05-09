// These lines includes all the libaries needed
#include <WiFi.h>
#include <HTTPClient.h>
#include <Servo.h>
#include <Stdlib.h>
#include <StringSplitter.h>

Servo myservo;
// Declaration of setting varibels

const char* ssid = "Enter_wifi_name_here"; // Your wifi name.
const char* password = "Enter_wifi_password_here"; // Your wifi password.

String serverName = "http://Enter_Domain_here/api.php?id=Enter_id_here"; // The URL of the API page for this ESP32.

// Declaration of varibels (NOT TO BE CHANGED)
// Defult time for delay_timer is 500ms (0.5 second) and 1000ms for act_timer.
int servo = 0; // Use 1 for servo and 0 for relay
int toggle = 0; // Use 1 for toggel betwene closed/pressed and open/retracted for every time you request or 0 for a quick closing/press and opening/retraction for every request.

int output_pin = 0; // Pinout for servo or relay
int led_pin = 0; // Pinout for LED

int delay_timer = 0; // You can change the time depending on how offen you whant it to update (its not every x ms it will update its ever (x ms + time to run))
int act_timer = 0; // Time from start of acton to end. For example time the relay is open, or the time the servo has to move and press a button.

int servo_extended = 0; // angle to extend to when activated
int servo_retracted = 0; // angle to retractto to when deactivated

int value = 0; // This is the amount of lines in table
int oldvalue = 0; // This is the  old amount of lines in table 
int toggle_state = 0; // Used of saving the toggle state
int init_oldvalue = 0; // this value is used to not get a startup action

// This is the setup
void setup()
{
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
 
  
}

// Primary loop
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
      
      // Redefines value from the string
      String item_0 = splitter->getItemAtIndex(0);
      int temporary_0 = String(item_0).toInt();
      value = temporary_0;
      Serial.print("value: ");
      Serial.println(value);
      
      // Redefines servo from the string
      String item_1 = splitter->getItemAtIndex(1);
      int temporary_1 = String(item_1).toInt();
      if (servo != temporary_1)
      {
        servo = temporary_1;
      }
      Serial.print("servo: ");
      Serial.println(servo);
      
      // Redefines toggle from the string
      String item_2 = splitter->getItemAtIndex(2);
      int temporary_2 = String(item_2).toInt();
      if (toggle != temporary_2)
      {
        toggle = temporary_2;
      }
      Serial.print("toggle: ");
      Serial.println(toggle);
      
      // Redefines delay_timer from the string
      String item_3 = splitter->getItemAtIndex(3);
      int temporary_3 = String(item_3).toInt();
      if (delay_timer != temporary_3)
      {
        delay_timer = temporary_3;
      }
      Serial.print("Delay timer: ");
      Serial.println(delay_timer);
      
      // Redefines act_timer from the string
      String item_4 = splitter->getItemAtIndex(4);
      int temporary_4 = String(item_4).toInt();
      if (act_timer != temporary_4)
      {
        act_timer = temporary_4;
      }
      Serial.print("Act timer: ");
      Serial.println(act_timer);
      
      // Redefines output_pin from the string
      String item_5 = splitter->getItemAtIndex(5);
      int temporary_5 = String(item_5).toInt();
      if (output_pin != temporary_5)
      {
        output_pin = temporary_5;
        // Used to redefine pin if the output_pin and led_pin has been changed
        if (servo == 1)
        {
          myservo.attach(output_pin);
          myservo.write(servo_retracted);
        }
        else
        {
          pinMode(output_pin, OUTPUT);
          digitalWrite(output_pin, LOW);
        }
      }
      Serial.print("Output pin: ");
      Serial.println(output_pin);
      
      // redefines led_pin from the string
      String item_6 = splitter->getItemAtIndex(6);
      int temporary_6 = String(item_6).toInt();
      if (led_pin != temporary_6)
      {
        led_pin = temporary_6;
        // These are for the debug led
        pinMode(led_pin, OUTPUT);
        digitalWrite(led_pin, LOW);
      }
      Serial.print("LED pin: ");
      Serial.println(led_pin);
      
      // Redefines servo_extended from the string
      String item_7 = splitter->getItemAtIndex(7);
      int temporary_7 = String(item_7).toInt();
      if (servo_extended != temporary_7)
      {
        servo_extended = temporary_7;
      }
      Serial.print("Servo extended: ");
      Serial.println(servo_extended);
      
      // Redefines act_timer from the string
      String item_8 = splitter->getItemAtIndex(8);
      int temporary_8 = String(item_8).toInt();
      if (servo_retracted != temporary_8)
      {
        servo_retracted = temporary_8;
      }
      Serial.print("Servo retracted: ");
      Serial.println(servo_retracted);

      // These lines of code checks if you are using a servo or relay
      if (servo == 1)
      {
        // These lines are for the servo code
        myservo.attach(output_pin);
        myservo.write(servo_retracted);
      }
      else
      {
        // These lines are for the relay code
        pinMode(output_pin, OUTPUT);
        digitalWrite(output_pin, LOW);
      }
      
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
            myservo.write(servo_extended);
            delay(act_timer);
            myservo.write(servo_retracted);
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