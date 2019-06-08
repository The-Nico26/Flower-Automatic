#include "DHT.h"
#include "SoilMoisture.h"
#include "ESP8266.h"
#include "Pump.h"

#define DHT_PIN_DATA  2
#define SOILMOISTURE_5V_PIN_SIG  A0
#define VACCUMPUMP_PIN_COIL1  3
#define LED_SETUP 13

const char *SSID     = "SSID"; // Enter your Wi-Fi name 
const char *PASSWORD = "PASSWORD" ; // Enter your Wi-Fi password
int motor = 0;
boolean wifiOn = false;

unsigned int ticks = 0;
const String url = "PATH_HOST";
const String ip = "IP_HOST";

DHT dht(DHT_PIN_DATA);
SoilMoisture soilMoisture_5v(SOILMOISTURE_5V_PIN_SIG);
ESP8266 wifi;
Pump vaccumpump(VACCUMPUMP_PIN_COIL1);

void setup() {
    Serial.begin(115200);
    while (!Serial) ; // wait for serial port to connect. Needed for native USB
    pinMode(LED_SETUP, INPUT);
    digitalWrite(LED_SETUP, HIGH);
    dht.begin();
    delay(500);
    if(wifiOn)
      wifi.init(SSID, PASSWORD);
    delay(500);
    digitalWrite(LED_SETUP, LOW);
}

void loop() {
    while (!Serial) ; // wait for serial port to connect. Needed for native USB
    getHumidity();
    getTemp();
    getWater();
    pumpWater();
    
    delay(5000);
    ticks++;
}

void getHumidity(){
    float dhtHumidity = dht.readHumidity();
    sendUrl(url+"action=captor&name=era_humi&value="+dhtHumidity);
    sendLog("era_humi", "Send_data_captor,era_humi,"+(String)dhtHumidity);
}


void getTemp(){
    float dhtTempC = dht.readTempC();
    sendUrl(url+"action=captor&name=era_temp&value="+dhtTempC);
    sendLog("era_temp", "Send_data_captor,era_temp,"+(String)dhtTempC);
}

void getWater(){
    int soilMoisture_5vVal = soilMoisture_5v.read();
    sendUrl(url+"action=captor&name=era_water&value="+(String)soilMoisture_5vVal);
    sendLog("era_water", "Send_data_captor,era_water,"+(String)soilMoisture_5vVal);
    if(soilMoisture_5vVal > 700 && motor != 1){
      motor = 1;
      sendLog("era_water", "Set_motor:_1");
    }
}

void pumpWater(){
  if(ticks % 2 != 0)return;

  if(motor == 1){
    vaccumpump.on();
    motor = 2;
    sendLog("pump", "Turn_On_Pump");
  }else if(motor == 2){
    vaccumpump.off();
    motor = 0;
    sendLog("pump", "Turn_Off_Pump");
  }
}

void sendLog(String nam, String text){
  sendUrl(url+"action=log&name="+nam+"&value="+text);
}

void sendUrl(String n){
  //Serial.println(n);
  if(wifiOn)
    wifi.http(ip, n.c_str());
}
