package RandomIT;

import java.util.HashMap;
import org.json.simple.JSONObject;
import java.io.FileWriter;
import java.io.IOException;
import java.io.File;

/**
 * Stores the validated and filtered data into .json files
 * The files are stored in ./data and are sorted per client
 * 
 * @author Stefan Jilderda (406347)
 * @version 1.1
 */
class DataStorage implements Runnable {
   private Thread t;
   private String threadName;
   private static FileWriter file;
   private String defaultstoragelocation = "./weatherdata/"; // Please include a trailing slash

   /**
    * Constructor
    * 
    * @param name The name for the thread
    */
   DataStorage(String name) {
      threadName = name;
      System.out.println("[DATASTORAGE] Creating and starting " +  threadName);
   }
   
   /**
    * Runs the thread 
    * Gives the data a timestamp and stores it in ./data
    * Filename is "stationnumber - timestamp.json"
    */
   @Override
   public synchronized void run() {
      System.out.println("[DATASTORAGE] Running " + threadName);
      //Infinite loop to keep the thread alive
      while (true) {
         int queueAmount = Run.filteredinput.size();
         if (queueAmount > 0) {
            //Get a hashMap from the list
            HashMap<String, String> hashMap = Run.filteredinput.poll();

            long timestamp = System.currentTimeMillis();
            String stationID = "INVALID";

            //Get the required variables
            try {
               stationID = hashMap.get("StationNumber");
            } catch (Exception e) {  
               //e.printStackTrace();
            }

            //Add a timestamp
            try {
               hashMap.put("Timestamp", String.valueOf(timestamp));
            } catch (Exception e) {
               //e.printStackTrace();
            }

            //Turn the hashMap into .json 
            JSONObject json = new JSONObject();
            try {
               json.putAll(hashMap);
            } catch (Exception e) {
               //e.printStackTrace();
            }

            // Save (all) data if the queue is not too big
            // try {
            //    if (queueAmount < 160000) { 
            //       //Make sure the directory is created
            //       File directory = new File(defaultstoragelocation);
            //       if (!directory.exists()) {
            //          directory.mkdir();
            //       }

            //       //Constructs a FileWriter given a file name, using the platform's default charset
            //       file = new FileWriter(defaultstoragelocation + stationID + "-" + timestamp + ".json");
            //       file.write(json.toJSONString());
            //    }
            // } catch (Exception e) {
            //       //e.printStackTrace();
            // } finally {
            //    try {
            //       if (queueAmount < 160000) { 
            //          file.flush();
            //          //file.close();
            //       }
            //    } catch (Exception e) {
            //       //e.printStackTrace();
            //    }
            // }

            // Save ALL client data
            try {
               if (hashMap.get("Client").equals("")) {
                  //No extra data saving is required
               } else { //Save the json in the client-folder aswell

                  //Remove [] and all special chars from string 
                  String rawclients = hashMap.get("Client").replaceAll("[^a-zA-Z, ]", "");

                  //Split into array from different clients
                  String[] clients = rawclients.split(", ");

                  //Walk trough the array
                  for (String clientname : clients) {
                     //Make sure the directory is created
                     File directory = new File(defaultstoragelocation + clientname);
                     if (!directory.exists()) {
                        directory.mkdir();
                     }

                     try {
                        //Constructs a FileWriter given a file name, using the platform's default charset
                        file = new FileWriter(defaultstoragelocation + clientname + "/" + stationID + "-" + timestamp + ".json");
                        file.write(json.toJSONString());
                     } catch (IOException e) {
                           //e.printStackTrace();
                     } finally {
                        try {
                           file.flush();
                           //file.close();
                        } catch (Exception e) {
                           //e.printStackTrace();
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
      System.out.println("[DATASTORAGE] Starting " +  threadName);
      if (t == null) {
         t = new Thread(this, threadName);
         t.start();
      }
   }
}