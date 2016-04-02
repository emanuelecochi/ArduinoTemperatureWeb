#include <SPI.h>
#include <Ethernet.h>
#include <dht.h>

// Create an array of bytes to specify the mac address
byte mac[] = {0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED};
// ip address "http://it.altervista.org/"
byte server[] = { 136, 243, 88, 137};
// Create an array of bytes to specify the IP address Arduino
IPAddress ip(192, 168, 1, 100);
// Create a client object
EthernetClient client;
// Create a dht object
dht DHT;
// Define pin 9 for sensor DHT22
#define DHT22_PIN 9
// strURL contains the request HTTP GET
String strURL = "";
// query string GET
String data = "";
// save temperature value
double temperature = 0;

void setup()
{
  // Initialize the shield with the mac and ip
  Ethernet.begin(mac, ip);
  Serial.begin(115200);
  Serial.println("connecting...");
  Serial.println("DHT TEST PROGRAM ");
  Serial.print("LIBRARY VERSION: ");
  Serial.println(DHT_LIB_VERSION);
}

void loop()
{
  // Read Data and manage errors 
  Serial.print("DHT11, \t");
  int chk = DHT.read22(DHT22_PIN);
  switch (chk)
  {
    case DHTLIB_OK:
      Serial.print("OK,\t");
      break;
    case DHTLIB_ERROR_CHECKSUM:
      Serial.print("Checksum error,\t");
      break;
    case DHTLIB_ERROR_TIMEOUT:
      Serial.print("Time out error,\t");
      break;
    case DHTLIB_ERROR_CONNECT:
      Serial.print("Connect error,\t");
      break;
    case DHTLIB_ERROR_ACK_L:
      Serial.print("Ack Low error,\t");
      break;
    case DHTLIB_ERROR_ACK_H:
      Serial.print("Ack High error,\t");
      break;
    default:
      Serial.print("Unknown error,\t");
      break;
  }
  // Display Data
  temperature = DHT.temperature;
  Serial.println(temperature, 1);
  // Create the query string GET
  data = "temperature=";
  data += temperature;

  // if you get a connection, report back via serial:
  if (client.connect(server, 80)) {
    Serial.println("connected");
    // Make a HTTP GET request:
    strURL = "GET /esempi/ArduinoTemperature/controller/addTemperature.php?";
    strURL += data;
    strURL += " HTTP/1.1";
    client.println(strURL);
    client.println("Host: emanuelecochi.altervista.org");
    client.println("User-Agent: Arduino/1.0");
    client.println("Connection: close");
    client.println();
    // Wait 1 ms so that the response arrivals the browser of the client
    delay(1);
    while (client.connected()) {
    // Check if there are bytes available for reading
    if (client.available()) {
      char c = client.read();
      Serial.print(c);
      }
    }
    // Close connection
    client.stop();
  }
  else {
    // if you didn't get a connection to the server:
    Serial.println("connection failed");
  }
  // Wait 5 min for new measure
  delay(300000);
}
