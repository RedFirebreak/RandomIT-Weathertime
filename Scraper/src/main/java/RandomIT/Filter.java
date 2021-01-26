package RandomIT;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

class Filter implements Runnable {
   private Thread t;
   private String threadName;
   
   Filter( String name) {
      threadName = name;
      System.out.println("[FILTER] Creating and starting " +  threadName );
   }
   
   // Runs the thread, insert code here to be run.
   public synchronized void run() {
      System.out.println("[FILTER] Running " +  threadName );

      int i = 0;

      ArrayList<String> stationListClient1 = new ArrayList<String>();

         //Countries'stations neighbouring Iran + Iran.
         stationListClient1.add("375750"); //Azerbaijan
         stationListClient1.add("378630");
         stationListClient1.add("378635");
         stationListClient1.add("378640");
         stationListClient1.add("379070");
         stationListClient1.add("379850");

         stationListClient1.add("381412"); //Turkmenistan

         stationListClient1.add("403560"); //Saudi Arabia
         stationListClient1.add("403570");
         stationListClient1.add("403584");
         stationListClient1.add("403600");
         stationListClient1.add("403610");
         stationListClient1.add("403620");
         stationListClient1.add("403720");
         stationListClient1.add("403730");
         stationListClient1.add("403750");
         stationListClient1.add("403770");
         stationListClient1.add("403940");
         stationListClient1.add("404050");
         stationListClient1.add("404150");
         stationListClient1.add("404160");
         stationListClient1.add("404170");
         stationListClient1.add("404200");
         stationListClient1.add("404300");
         stationListClient1.add("404370");
         stationListClient1.add("404380");
         stationListClient1.add("404390");
         stationListClient1.add("404450");
         stationListClient1.add("404770");
         stationListClient1.add("404800");
         stationListClient1.add("404950");
         stationListClient1.add("404980");

         stationListClient1.add("404480"); //U.A.E
         stationListClient1.add("404490");
         stationListClient1.add("404520");
         stationListClient1.add("411840");
         stationListClient1.add("411940");
         stationListClient1.add("411960");
         stationListClient1.add("411980");
         stationListClient1.add("412160");
         stationListClient1.add("412170");
         stationListClient1.add("412180");

         stationListClient1.add("412410"); //Oman
         stationListClient1.add("412460");
         stationListClient1.add("412540");
         stationListClient1.add("412560");
         stationListClient1.add("412880");
         stationListClient1.add("413140");
         stationListClient1.add("413160");
         stationListClient1.add("405750");

         stationListClient1.add("407060"); //Iran
         stationListClient1.add("407090");
         stationListClient1.add("407120");
         stationListClient1.add("407180");
         stationListClient1.add("407190");
         stationListClient1.add("407290");
         stationListClient1.add("407300");
         stationListClient1.add("407310");
         stationListClient1.add("407320");
         stationListClient1.add("407340");
         stationListClient1.add("407360");
         stationListClient1.add("407390");
         stationListClient1.add("407430");
         stationListClient1.add("407450");
         stationListClient1.add("407470");
         stationListClient1.add("407540");
         stationListClient1.add("407570");
         stationListClient1.add("407620");
         stationListClient1.add("407660");
         stationListClient1.add("407720");
         stationListClient1.add("407780");
         stationListClient1.add("407802");
         stationListClient1.add("408000");
         stationListClient1.add("408090");
         stationListClient1.add("408110");
         stationListClient1.add("408190");
         stationListClient1.add("408210");
         stationListClient1.add("408230");
         stationListClient1.add("408310");
         stationListClient1.add("408410");
         stationListClient1.add("408480");
         stationListClient1.add("408560");
         stationListClient1.add("408580");
         stationListClient1.add("408590");
         stationListClient1.add("408750");
         stationListClient1.add("408790");

         stationListClient1.add("409480"); //Afghanistan

         stationListClient1.add("415300"); //Pakistan
         stationListClient1.add("415710");
         stationListClient1.add("416410");
         stationListClient1.add("417490");
         stationListClient1.add("417560");
         stationListClient1.add("417800");


         //Countries' station located in the Pacific
         ArrayList<String> pacificstationListClient1 = new ArrayList<String>();
         pacificstationListClient1.add("702759"); //Palau
         pacificstationListClient1.add("914080");

         pacificstationListClient1.add("749316"); //Marshall Islands
         pacificstationListClient1.add("912500");
         pacificstationListClient1.add("913660");
         pacificstationListClient1.add("913760");

         pacificstationListClient1.add("912120"); //Guam
         pacificstationListClient1.add("912180");

         pacificstationListClient1.add("912210"); //Mariana Islands
         pacificstationListClient1.add("912320");
         pacificstationListClient1.add("912333");

         pacificstationListClient1.add("912450"); //Wake Island

         pacificstationListClient1.add("913340"); //Micronesia
         pacificstationListClient1.add("913480");
         pacificstationListClient1.add("913481");
         pacificstationListClient1.add("913691");
         pacificstationListClient1.add("914130");

         pacificstationListClient1.add("916100"); //Kiribati


      /* Infinite loop */
      while(true) {
         if (Run.validinput.isEmpty()) {
            // Do nothing
         } else {
               //Make list for clients.
               List<String> clientlist = new ArrayList<String>();

               //Hashmap containing valid data.
               HashMap<String, String> hashmap = Run.validinput.poll();

               //Filter for Iran's neighbouring countries
               if(stationListClient1.contains(hashmap.get("StationNumber"))){
                  //Filtered data required by client comes through. Add client name to list.
                  clientlist.add("UniversityTeheran");   
               }

               //Filter for clients requirements of data from Pacific stations.
               if(pacificstationListClient1.contains(hashmap.get("StationNumber"))){
                  String temperature = hashmap.get("Temperature");
                  Double temp = Double.parseDouble(temperature);

                  if(temp >= 0 || temp <= 10){
                     //Filtered data required by client comes through. Add client name to list.
                     clientlist.add("UniversityTeheran");
                  }
               }

               //Put client name from list into hashmap.
               hashmap.put("Client", clientlist.toString());

               //Submit filtered data.
               Run.filteredinput.add(hashmap);
         }
      }
   }

   // Starts the thread.
   public void start () {
      System.out.println("[FILTER] Starting " +  threadName );
      if (t == null) {
         t = new Thread (this, threadName);
         t.start ();
      }
   }
 }