package RandomIT;

import java.io.File;
import java.util.Scanner;
import java.util.HashMap;
import java.util.ArrayList;

/**
 * This class will parse all incoming raw data
 * The data will be validated here
 * Valid data is added to a new Queue
 * This queue is then sent to the filter
 * 
 * @author Stefan Kuppen (405611)
 * @version 1.1
 */
class Parser implements Runnable {
   private Thread t;
   private String threadName;
   
   /**
    * Constructor
    * 
    * @param name The name for the thread
    */
   Parser(String name) {
      threadName = name;
      System.out.println("[PARSER] Creating and starting " +  threadName);
   }
   
   /**
    * Runs the thread 
    * Does the actual checks on the raw data
    * Needed to validate the data so it is between certain ranges
    * Checks if the given station is a known one
    * Missing datapoints are names "MISSING" and will be filled in with averages later
    */
   @Override
   public synchronized void run() {
      System.out.println("[PARSER] Running " +  threadName);
      
      //Load all valid stations
      ArrayList<String> validStationNumbers = new ArrayList<String>();
      try (Scanner scanner = new Scanner(new File("./station_country_data.dat"))) {
         while(scanner.hasNextLine()) {
            validStationNumbers.add(scanner.nextLine().replaceAll("[^0-9]", "")); //only get the numbers of this file
         }
      } catch (Exception e) {  
         e.printStackTrace();  
      }

      //Infinite loop to keep the thread alive
      while (true) {
         if (Run.rawinput.size() > 0 && Run.filteredinput.size() < 160000) {
            HashMap<String, String> returnHash = new HashMap<String, String>();
            try {
               String xmlString = Run.rawinput.poll();
               if (xmlString.contains("<MEASUREMENT>")) {
                  for (String subString : xmlString.split("<MEASUREMENT>")) {
                     if (subString.contains("STN")) {
                        String stationNumber = subString.substring(subString.indexOf("<STN>") + 5, subString.indexOf("</STN>"));
                        if (stationNumber != null && !stationNumber.isEmpty() && validStationNumbers.contains(stationNumber)) {
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

                           returnHash.put("StationNumber", stationNumber);
                           returnHash.put("Date", date);
                           returnHash.put("Time", time);

                           if (!temperature.isEmpty() && temperature != null) {
                              if (Double.parseDouble(temperature) >= -9999.9 && Double.parseDouble(temperature) <= 9999.9) { 
                                 returnHash.put("Temperature", temperature);
                              } else {
                                 returnHash.put("Temperature", "MISSING");
                              }
                           }

                           if (!dewPoint.isEmpty() && dewPoint != null) {
                              if (Double.parseDouble(dewPoint) >= -9999.9 && Double.parseDouble(dewPoint) <= 9999.9) { 
                                 returnHash.put("DewPoint", dewPoint);
                              } else {
                                 returnHash.put("DewPoint", "MISSING");
                              }
                           }

                           if (!stationLevelPressure.isEmpty() && stationLevelPressure != null) {
                              if (Double.parseDouble(stationLevelPressure) >= 0 && Double.parseDouble(stationLevelPressure) <= 9999.9) { 
                                 returnHash.put("StationLevelPressure", stationLevelPressure);
                              } else {
                                 returnHash.put("StationLevelPressure", "MISSING");
                              }
                           }

                           if (!seaLevelPressure.isEmpty() && seaLevelPressure != null) {
                              if (Double.parseDouble(seaLevelPressure) >= 0 && Double.parseDouble(seaLevelPressure) <= 9999.9) { 
                                 returnHash.put("SeaLevelPressure", seaLevelPressure);
                              } else {
                                 returnHash.put("SeaLevelPressure", "MISSING");
                              }
                           }

                           if (!visibility.isEmpty() && visibility != null) {
                              if (Double.parseDouble(visibility) >= 0 && Double.parseDouble(visibility) <= 999.9) { 
                                 returnHash.put("Visibility", visibility);
                              } else {
                                 returnHash.put("Visibility", "MISSING");
                              }
                           }

                           if (!windSpeed.isEmpty() && windSpeed != null) {
                              if (Double.parseDouble(windSpeed) >= 0 && Double.parseDouble(windSpeed) <= 999.9) { 
                                 returnHash.put("Windspeed", windSpeed);
                              } else {
                                 returnHash.put("Windspeed", "MISSING");
                              }
                           }

                           if (!percipitation.isEmpty() && percipitation != null) {
                              if (Double.parseDouble(percipitation) >= 0 && Double.parseDouble(percipitation) <= 999.9) { 
                                 returnHash.put("Percipitation", percipitation);
                              } else {
                                 returnHash.put("Percipitation", "MISSING");
                              } 
                           }

                           if (!snowDrop.isEmpty() && snowDrop != null) {
                              if (Double.parseDouble(snowDrop) >= -999.9 && Double.parseDouble(snowDrop) <= 9999.9) { 
                                 returnHash.put("SnowDrop", snowDrop);
                              } else {
                                 returnHash.put("SnowDrop", "MISSING");
                              } 
                           }

                           if (!cloudCoverage.isEmpty() && cloudCoverage != null) {
                              if (Double.parseDouble(cloudCoverage) >= 0 && Double.parseDouble(cloudCoverage) <= 99.9) { 
                                 returnHash.put("CloudCoverage", cloudCoverage);
                              } else {
                                 returnHash.put("CloudCoverage", "MISSING");
                              } 
                           }

                           if (!windDirection.isEmpty() && windDirection != null) {
                              if (Integer.parseInt(windDirection) >= 0 && Integer.parseInt(windDirection) <= 359) { 
                                 returnHash.put("WindDirection", windDirection);
                              } else {
                                 returnHash.put("CloudCoverage", "MISSING");
                              } 
                           }

                           if (!events.isEmpty() && events != null) {
                              if (events.charAt(0) == '1') {
                                 returnHash.put("Freeze", "true");
                              } else if (events.charAt(0) == '0') {
                                 returnHash.put("Freeze", "false");
                              } else {
                                 returnHash.put("Freeze", "MISSING");
                              }

                              if (events.charAt(1) == '1') {
                                 returnHash.put("Rain", "true");
                              } else if (events.charAt(1) == '0') {
                                 returnHash.put("Rain", "false");
                              } else {
                                 returnHash.put("Rain", "MISSING");
                              }

                              if (events.charAt(2) == '1') {
                                 returnHash.put("Snow", "true");
                              } else if (events.charAt(2) == '0') {
                                 returnHash.put("Snow", "false");
                              } else {
                                 returnHash.put("Snow", "MISSING");
                              }

                              if (events.charAt(3) == '1') {
                                 returnHash.put("Hail", "true");
                              } else if (events.charAt(3) == '0') {
                                 returnHash.put("Hail", "false");
                              } else {
                                 returnHash.put("Hail", "MISSING");
                              }

                              if (events.charAt(4) == '1') {
                                 returnHash.put("Storm", "true");
                              } else if (events.charAt(4) == '0') {
                                 returnHash.put("Storm", "false");
                              } else {
                                 returnHash.put("Storm", "MISSING");
                              }

                              if (events.charAt(5) == '1') {
                                 returnHash.put("Tornado", "true");
                              } else if (events.charAt(5) == '0') {
                                 returnHash.put("Tornado", "false");
                              } else {
                                 returnHash.put("Tornado", "MISSING");
                              }
                           }
                           //Submit validated data
                           Run.validinput.add(returnHash);   
                        }
                     }
                  }
               }
            } catch (Exception e) { 
               //e.printStackTrace();  
            }
         }
      }
   }

   /**
    * Starts the thread
    */
   public void start() {
      System.out.println("[PARSER] Starting " +  threadName);
      if (t == null) {
         t = new Thread(this, threadName);
         t.start();
      }
   }
}