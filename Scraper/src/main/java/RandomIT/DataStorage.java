package RandomIT;

import java.util.HashMap;
import org.json.simple.JSONObject;
import java.io.FileWriter;
import java.io.IOException;
import java.io.File;

class DataStorage implements Runnable {
   private Thread t;
   private String threadName;
   private static FileWriter file;

   DataStorage( String name) {
      threadName = name;
      System.out.println("[DATASTORAGE] Creating and starting " +  threadName );
   }
   
   // Runs the thread, insert code here to be run
   public synchronized void run() {
      System.out.println("[DATASTORAGE] Running " +  threadName );
      /* Infinite loop */
      while(true) {
         int queueAmount = Run.filteredinput.size();
         if (queueAmount > 0) {
            // Get a hashmap from the list
            HashMap<String, String> hashmap = Run.filteredinput.poll();

            // Get the required variables
            String stationID = hashmap.get("StationNumber");
            long timestamp = System.currentTimeMillis();

            // Add a current timestamp of processing for saving the date
            hashmap.put("Timestamp", String.valueOf(timestamp));

            // Turn the hasmap into JSON 
            JSONObject json = new JSONObject();
            json.putAll( hashmap );

            // Save the json in the main data file
            try {
               // Make sure the directory is created
               File directory = new File("../data/");
               if (! directory.exists()){
                  directory.mkdir();
               }

               // Constructs a FileWriter given a file name, using the platform's default charset
               file = new FileWriter("../data/" + stationID + "-" + timestamp + ".json");
               file.write(json.toJSONString());
            } catch (IOException e) {
                  e.printStackTrace();
            } finally {
               try {
                  file.flush();
                  file.close();
               } catch (IOException e) {
                  e.printStackTrace();
               }
            }

            if (hashmap.get("Client") == "") {
               // No extra data saving is required
            } else { // Save the json in the client-folder aswell

               // Remove [] and all special chars from string 
               String rawclients = hashmap.get("Client").replaceAll("[^a-zA-Z, ]","");

               // Split into array from different clients
               String[] clients = rawclients.split(", ");

               // Walk trough the array, 
               for (String clientname : clients) {
                  // Make sure the directory is created
                  File directory = new File("../data/" + clientname);
                  if (! directory.exists()){
                     directory.mkdir();
                  }

                  try {
                     // Constructs a FileWriter given a file name, using the platform's default charset
                     file = new FileWriter("../data/" + clientname + "/" + stationID + "-" + timestamp + ".json");
                     file.write(json.toJSONString());
                  } catch (IOException e) {
                        e.printStackTrace();
                  } finally {
                     try {
                        file.flush();
                        file.close();
                     } catch (IOException e) {
                        e.printStackTrace();
                     }
                  }
               }
            }
         }
      }
   }
   
   // Starts the thread
   public void start () {
      System.out.println("[DATASTORAGE] Starting " +  threadName );
      if (t == null) {
         t = new Thread (this, threadName);
         t.start ();
      }
   }
 }