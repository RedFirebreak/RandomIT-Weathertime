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

   private int alldata_succeeded = 0;
   private int alldata_discarded = 0;

   private int data_forclient = 0;
   private int data_succeeded = 0;

   private int data_failed = 0;
   private int data_failed_io = 0;
   

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

      // Init: "all data" folder
      File directory = new File(defaultstoragelocation);
      if (!directory.exists()) {
         directory.mkdir();
      }

      //Infinite loop to keep the thread alive
      while (true) {
         // If there is something in the queue, WORK!
         if (Run.filteredinput.size() > 0) {
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

            // Fist, check if client data needs to be saved
            try {
               if (stationID != "INVALID") {
                  if (hashMap.get("Client").equals("[]")) {
                     //No extra data saving is required
                  } else { //Save the json in the client-folder aswell
                     data_forclient = data_forclient + 1;

                     //Remove [] and all special chars from string 
                     String rawclients = hashMap.get("Client").replaceAll("[^a-zA-Z, ]", "");

                     //Split into array from different clients
                     String[] clients = rawclients.split(", ");

                     //Walk trough the array
                     for (String clientname : clients) {
                        //Make sure the directory is created
                        File directory1 = new File(defaultstoragelocation + clientname);
                        if (!directory1.exists()) {
                           directory1.mkdir();
                        }

                        try {
                           //Constructs a FileWriter given a file name, using the platform's default charset
                           file = new FileWriter(defaultstoragelocation + clientname + "/" + stationID + "-" + timestamp + ".json");
                           file.write(json.toJSONString());
                           file.flush();
                           data_succeeded = data_succeeded + 1;
                        } catch (IOException e) {
                              //e.printStackTrace();
                              data_failed_io = data_failed_io + 1;
                        }
                     }
                  }
               }
            } catch (Exception e) {
               //e.printStackTrace();
               data_failed = data_failed + 1;
            }


            // Then, Save (all) data if the queue is not too big (16000, 2 second worth of data not being worked on)
            try {
               if (stationID != "INVALID") {   
                  if (Run.filteredinput.size() < 160000) { 
                     // file (and directory) is made in the init of this class
                     file = new FileWriter(defaultstoragelocation + stationID + "-" + timestamp + ".json");
                     file.write(json.toJSONString());
                     file.flush();
                     alldata_succeeded = alldata_succeeded + 1;
                  } else {
                     alldata_discarded = alldata_discarded + 1;
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

   public String givestats() {
      return "All succeeded " + alldata_succeeded + "| All discarded = " +  alldata_discarded + "| Data for client: " + data_forclient + "| clientdata succeeded: " + data_succeeded + "| Abandoned: " + data_failed + "| Abandoned IO: " + data_failed_io;
   }
}