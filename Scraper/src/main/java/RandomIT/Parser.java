package RandomIT;
import java.io.File;
import java.util.Scanner;
import java.util.HashMap;
import java.util.ArrayList;

class Parser implements Runnable {
   private Thread t;
   private String threadName;
   
   Parser( String name) {
      threadName = name;
      System.out.println("[PARSER] Creating and starting " +  threadName );
   }
   
   // Runs the thread, insert code here to be run
   public void run() {
      System.out.println("[PARSER] Running " +  threadName );
      
      //Load all valid stations
      ArrayList<String> validStationNumbers = new ArrayList<String>();
      try (Scanner scanner = new Scanner(new File("./station_country_data.dat"))) {
         while(scanner.hasNextLine()) {
            String line = scanner.nextLine().toLowerCase().replaceAll("[^[0-9]+$]", "");
            validStationNumbers.add(line);
         }
      } catch (Exception e) {  
         e.printStackTrace();  
      }
      
      while(true) {
         System.out.println("IM ALIVE");
         int queueAmount = Run.rawinput.size();
         if (queueAmount > 0) {
            try {
               String xmlString = Run.rawinput.poll();

               // CUT OUT XML
               // FILTER NULL POINTERS

               //String xmlString = "<?xml version=\"1.0\"?><WEATHERDATA><MEASUREMENT><STN>722251</STN><DATE>2021-01-26</DATE><TIME>12:47:39</TIME><TEMP>-1.3</TEMP><DEWP>-5.1</DEWP><STP>990.0</STP><SLP>968.0</SLP><VISIB>9.5</VISIB><WDSP>8.1</WDSP><PRCP>0.00</PRCP><SNDP>0.0</SNDP><FRSHTT>100000</FRSHTT><CLDC>83.3</CLDC><WNDDIR>207</WNDDIR></MEASUREMENT><MEASUREMENT><STN>722261</STN><DATE>2021-01-26</DATE><TIME>12:47:39</TIME><TEMP>1.0</TEMP><DEWP>-1.9</DEWP><STP>980.3</STP><SLP>967.0</SLP><VISIB>6.4</VISIB><WDSP>9.9</WDSP><PRCP>0.00</PRCP><SNDP>0.0</SNDP><FRSHTT>000000</FRSHTT><CLDC>97.3</CLDC><WNDDIR>216</WNDDIR></MEASUREMENT><MEASUREMENT><STN>722260</STN><DATE>2021-01-26</DATE><TIME>12:47:39</TIME><TEMP>0.3</TEMP><DEWP>-6.0</DEWP><STP>1012.8</STP><SLP>1020.6</SLP><VISIB>15.6</VISIB><WDSP>9.2</WDSP><PRCP>0.27</PRCP><SNDP>0.0</SNDP><FRSHTT>010000</FRSHTT><CLDC>79.4</CLDC><WNDDIR>287</WNDDIR></MEASUREMENT><MEASUREMENT><STN>25900</STN><DATE>2021-01-26</DATE><TIME>12:47:39</TIME><TEMP>-1.2</TEMP><DEWP>-3.7</DEWP><STP>1013.9</STP><SLP>1015.0</SLP><VISIB>10.8</VISIB><WDSP>15.0</WDSP><PRCP>0.12</PRCP><SNDP>2.8</SNDP><FRSHTT>111000</FRSHTT><CLDC>52.0</CLDC><WNDDIR>92</WNDDIR></MEASUREMENT><MEASUREMENT><STN>60590</STN><DATE>2021-01-26</DATE><TIME>12:47:39</TIME><TEMP>-1.2</TEMP><DEWP>-5.0</DEWP><STP>1000.2</STP><SLP>1010.9</SLP><VISIB>20.2</VISIB><WDSP>1.8</WDSP><PRCP>0.11</PRCP><SNDP>0.2</SNDP><FRSHTT>111000</FRSHTT><CLDC>51.2</CLDC><WNDDIR>199</WNDDIR></MEASUREMENT><MEASUREMENT><STN>217120</STN><DATE>2021-01-26</DATE><TIME>12:47:39</TIME><TEMP>-25.7</TEMP><DEWP>-29.1</DEWP><STP>978.9</STP><SLP>1004.8</SLP><VISIB>78.6</VISIB><WDSP>21.5</WDSP><PRCP>0.00</PRCP><SNDP>0.0</SNDP><FRSHTT>100000</FRSHTT><CLDC>54.9</CLDC><WNDDIR>243</WNDDIR></MEASUREMENT><MEASUREMENT><STN>722256</STN><DATE>2021-01-26</DATE><TIME>12:47:39</TIME><TEMP>-11.1</TEMP><DEWP>-22.2</DEWP><STP>1014.6</STP><SLP>1007.0</SLP><VISIB>24.2</VISIB><WDSP>31.1</WDSP><PRCP>0.00</PRCP><SNDP>0.0</SNDP><FRSHTT>100000</FRSHTT><CLDC>60.1</CLDC><WNDDIR>358</WNDDIR></MEASUREMENT><MEASUREMENT><STN>722269</STN><DATE>2021-01-26</DATE><TIME>12:47:39</TIME><TEMP>1.6</TEMP><DEWP>-5.6</DEWP><STP>1013.3</STP><SLP>1020.4</SLP><VISIB>8.5</VISIB><WDSP>12.3</WDSP><PRCP>0.19</PRCP><SNDP>0.0</SNDP><FRSHTT>010000</FRSHTT><CLDC>52.6</CLDC><WNDDIR>21</WNDDIR></MEASUREMENT><MEASUREMENT><STN>60580</STN><DATE>2021-01-26</DATE><TIME>12:47:39</TIME><TEMP>0.6</TEMP><DEWP>-1.4</DEWP><STP>1010.2</STP><SLP>1010.8</SLP><VISIB>5.2</VISIB><WDSP>26.7</WDSP><PRCP>0.02</PRCP><SNDP>0.0</SNDP><FRSHTT>010000</FRSHTT><CLDC>51.4</CLDC><WNDDIR>30</WNDDIR></MEASUREMENT><MEASUREMENT><STN>722268</STN><DATE>2021-01-26</DATE><TIME>12:47:39</TIME><TEMP>3.3</TEMP><DEWP>-4.5</DEWP><STP>1020.8</STP><SLP>1020.6</SLP><VISIB>6.5</VISIB><WDSP>17.1</WDSP><PRCP>0.12</PRCP><SNDP>0.0</SNDP><FRSHTT>101000</FRSHTT><CLDC>86.6</CLDC><WNDDIR>169</WNDDIR></MEASUREMENT></WEATHERDATA>";

               // \/\/ THIS ONE NULLPOINTERS SOMETIMES  UwU fix daddy \\
               for (String subString : xmlString.split("<MEASUREMENT>")) {
                  if(subString.contains("STN")) {
                     String stationNumber = subString.substring(subString.indexOf("<STN>") + 5, subString.indexOf("</STN>"));
                     String date = subString.substring(subString.indexOf("<DATE>") + 6, subString.indexOf("</DATE>"));
                     String time = subString.substring(subString.indexOf("<TIME>") + 6, subString.indexOf("</TIME>"));
                     String temperature = subString.substring(subString.indexOf("<TEMP>") + 6, subString.indexOf("</TEMP>"));
                     String dewPoint = subString.substring(subString.indexOf("<DEWP>") + 6, subString.indexOf("</DEWP>"));
                     String stationLevelPressure = subString.substring(subString.indexOf("<STP>") + 5, subString.indexOf("</STP>"));
                     String seaLevelPressure = subString.substring(subString.indexOf("<SLP>") + 5, subString.indexOf("</SLP>"));
                     String visibility = subString.substring(subString.indexOf("<VISIB>") + 7, subString.indexOf("</VISIB>"));
                     String windSpeed = subString.substring(subString.indexOf("<WDSP>") + 6, subString.indexOf("</WDSP>"));
                     String percipitation = subString.substring(subString.indexOf("<PRCP>") + 6, subString.indexOf("</PRCP>"));
                     String snowDrop = subString.substring(subString.indexOf("<SNDP>") + 6, subString.indexOf("</SNDP>"));
                     String events = subString.substring(subString.indexOf("<FRSHTT>") + 8, subString.indexOf("</FRSHTT>"));
                     String cloudCoverage = subString.substring(subString.indexOf("<CLDC>") + 6, subString.indexOf("</CLDC>"));
                     String windDirection = subString.substring(subString.indexOf("<WNDDIR>") + 8, subString.indexOf("</WNDDIR>"));
                     Boolean freeze = false;
                     Boolean rain = false;
                     Boolean snow = false;
                     Boolean hail = false;
                     Boolean storm = false;
                     Boolean tornado = false;
                     
                     if(events != null) {
                        if (events.charAt(0) == '1') {
                           freeze = true;
                        }
                        if (events.charAt(1) == '1') {
                           rain = true;
                        }
                        if (events.charAt(2) == '1') {
                           snow = true;
                        }
                        if (events.charAt(3) == '1') {
                           hail = true;
                        }
                        if (events.charAt(4) == '1') {
                           storm = true;
                        }
                        if (events.charAt(5) == '1') {
                           tornado = true;
                        }
                     }

                     HashMap<String, String> returnHash = new HashMap<String, String>();

                     //Actual checks if data is valid
                     if (validStationNumbers.contains(stationNumber)) {
                        if (Double.parseDouble(temperature) >= -9999.9 && Double.parseDouble(temperature) <= 9999.9) { 
                           if (Double.parseDouble(dewPoint) >= -9999.9 && Double.parseDouble(dewPoint) <= 9999.9) { 
                              if (Double.parseDouble(stationLevelPressure) >= 0 && Double.parseDouble(stationLevelPressure) <= 9999.9) { 
                                 if (Double.parseDouble(seaLevelPressure) >= 0 && Double.parseDouble(seaLevelPressure) <= 9999.9) { 
                                    if (Double.parseDouble(visibility) >= 0 && Double.parseDouble(visibility) <= 999.9) { 
                                       if (Double.parseDouble(windSpeed) >= 0 && Double.parseDouble(windSpeed) <= 999.9) { 
                                          if (Double.parseDouble(percipitation) >= 0 && Double.parseDouble(percipitation) <= 999.9) { 
                                             if (Double.parseDouble(snowDrop) >= -999.9 && Double.parseDouble(snowDrop) <= 9999.9) { 
                                                if (Double.parseDouble(cloudCoverage) >= 0 && Double.parseDouble(cloudCoverage) <= 99.9) { 
                                                   if (Double.parseDouble(windDirection) >= 0 && Double.parseDouble(windDirection) <= 359) { 
                                                      //System.out.println("DEBUG De data is valide.");
                                                      //Add keys and values
                                                      returnHash.put("StationNumber", stationNumber);
                                                      returnHash.put("Date", date);
                                                      returnHash.put("Time", time);
                                                      returnHash.put("Temperature", temperature);
                                                      returnHash.put("DewPoint", dewPoint);
                                                      returnHash.put("StationLevelPressure", stationLevelPressure);
                                                      returnHash.put("SeaLevelPressure", seaLevelPressure);
                                                      returnHash.put("Visibility", visibility);
                                                      returnHash.put("Windspeed", windSpeed);
                                                      returnHash.put("Percipitation", percipitation);
                                                      returnHash.put("SnowDrop", snowDrop);
                                                      returnHash.put("Freeze", freeze.toString());
                                                      returnHash.put("Rain", rain.toString());
                                                      returnHash.put("Snow", snow.toString());
                                                      returnHash.put("Hail", hail.toString());
                                                      returnHash.put("Storm", storm.toString());
                                                      returnHash.put("Tornado", tornado.toString());
                                                      returnHash.put("CloudCoverage", cloudCoverage);
                                                      returnHash.put("WindDirection", windDirection);
                                                      Run.validinput.add(returnHash);   
                                                   } else { System.out.println("DEBUG De windDirection is niet valide."); }
                                                } else { System.out.println("DEBUG De cloudCoverage is niet valide."); }
                                             } else { System.out.println("DEBUG De snowDrop is niet valide."); }
                                          } else { System.out.println("DEBUG De percipitation is niet valide."); }
                                       } else { System.out.println("DEBUG De windSpeed is niet valide."); }
                                    } else { System.out.println("DEBUG De visibility is niet valide."); }
                                 } else { System.out.println("DEBUG De seaLevelPressure is niet valide."); }
                              } else { System.out.println("DEBUG De stationLevelPressure is niet valide."); }
                           } else { System.out.println("DEBUG De dewPoint is niet valide."); }
                        } else { System.out.println("DEBUG De temperature is niet valide."); }
                     } else { System.out.println("DEBUG De stationNumber is niet valide."); }
                  } else { //System.out.println("DEBUG Deze had geen STN.");
                  }
               }
            } catch (Exception e) {  
               e.printStackTrace();  
            }
         }
      }
   }

   // Starts the thread
   public void start () {
      System.out.println("[PARSER] Starting " +  threadName );
      if (t == null) {
         t = new Thread (this, threadName);
         t.start ();
      }
   }
}