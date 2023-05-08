
//Include libraries
#include <LiquidCrystal_I2C.h>
#include <HTTPClient.h>
#include <WiFi.h>

LiquidCrystal_I2C LCD = LiquidCrystal_I2C(0x27, 16, 2);


//Add WIFI data
const char* ssid = "";              //Add your WIFI network name 
const char* password =  "";           //Add WIFI password


//Variables used in the code
String LED_id = "1";                  //Just in case you control more than 1 LED
bool toggle_pressed = false;          //Each time we press the push button    
String data_to_send = "";             //Text data to send to the server
unsigned int Actual_Millis, Previous_Millis;
int refresh_time = 200;               //Refresh rate of connection to website (recommended more than 1s)

//Button press interruption
void IRAM_ATTR isr() {
  toggle_pressed = true;
}

void setup() {
  Serial.begin(115200);                   //Start monitor
  LCD.init();
  LCD.backlight();
  LCD.clear();
  LCD.setCursor(0, 0);  

  //WiFi.begin("Wokwi-GUEST", "", 6);
  WiFi.begin(ssid, password);             //Start wifi connection
  Serial.print("Connecting...");
  LCD.clear();
  LCD.setCursor(0, 0);
  LCD.println("Connecting...");

  while (WiFi.status() != WL_CONNECTED) { //Check for the connection
    delay(500);
    Serial.print(".");
    LCD.println(".");
  }

  Serial.print("Connected, my IP: ");
  LCD.println("Connected, my IP: ");

  Serial.println(WiFi.localIP());
  Actual_Millis = millis();               //Save time for refresh loop
  Previous_Millis = Actual_Millis; 
}


void loop() {  
  //We make the refresh loop using millis() so we don't have to sue delay();
  Actual_Millis = millis();
  if(Actual_Millis - Previous_Millis > refresh_time){
    Previous_Millis = Actual_Millis;  
    if(WiFi.status()== WL_CONNECTED){                   //Check WiFi connection status  
      HTTPClient http;                                  //Create new client      
      
      //Begin new connection to website       
      http.begin("");   //Indicate the destination webpage 
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");         //Prepare the header
      
      int response_code = http.POST(data_to_send);                                //Send the POST. This will giveg us a response code
      
      //If the code is higher than 0, it means we received a response
      if(response_code > 0){
        Serial.println("HTTP code " + String(response_code));                     //Print return code
  
        if(response_code == 200){                                                 //If code is 200, we received a good response and we can read the echo data
          String response_body = http.getString();                                //Save the data comming from the website
          Serial.print("Server reply: ");                                         //Print data to the monitor for debug
          Serial.println(response_body);
          LCD.clear();
          LCD.setCursor(0, 0);
          LCD.println(response_body);

          // #based on the "response_body" open different types of options

        }//End of response_code = 200
      }//END of response_code > 0
      
      else{
       Serial.print("Error sending POST, code: ");
       Serial.println(response_code);
      }
      http.end();                                                                 //End the connection
    }//END of WIFI connected
    else{
      Serial.println("WIFI connection error");
    }
  }
}
