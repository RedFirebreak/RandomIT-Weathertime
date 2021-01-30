package RandomIT;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

/**
 * This class filters the data for the clients
 * It is easily expandable for more clients
 * The filtered data will be stored so the DataStorage can do its thing
 * 
 * @author Romano Braxhoofden (405380)
 * @version 1.3
 */
class Filter implements Runnable {
   private Thread t;
   private String threadName;
   
   /**
    * Constructor
    * 
    * @param name The name for the thread
    */
   Filter(String name) {
      threadName = name;
      System.out.println("[FILTER] Creating and starting " + threadName);
   }
   
   /**
    * Runs the thread 
    * Does the actual filtering on the validated data
    */
   @Override
   public synchronized void run() {
      System.out.println("[FILTER] Running " +  threadName);
      ArrayList<String> stationListClient1 = new ArrayList<String>();

      //Stations in Iran and all neighbouring countries
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

      stationListClient1.add("170220"); //Turkey
      stationListClient1.add("170240");
      stationListClient1.add("170260");
      stationListClient1.add("170300");
      stationListClient1.add("170310");
      stationListClient1.add("170340");
      stationListClient1.add("170380");
      stationListClient1.add("170420");
      stationListClient1.add("170500");
      stationListClient1.add("170560");
      stationListClient1.add("170575");
      stationListClient1.add("170600");
      stationListClient1.add("170660");
      stationListClient1.add("170670");
      stationListClient1.add("170671");
      stationListClient1.add("170672");
      stationListClient1.add("170673");
      stationListClient1.add("170674");
      stationListClient1.add("170700");
      stationListClient1.add("170820");
      stationListClient1.add("170840");
      stationListClient1.add("170860");
      stationListClient1.add("170880");
      stationListClient1.add("170900");
      stationListClient1.add("170920");
      stationListClient1.add("170960");
      stationListClient1.add("170980");
      stationListClient1.add("171100");
      stationListClient1.add("171120");
      stationListClient1.add("171150");
      stationListClient1.add("171160");
      stationListClient1.add("171200");
      stationListClient1.add("171240");
      stationListClient1.add("171270");
      stationListClient1.add("171280");
      stationListClient1.add("171290");
      stationListClient1.add("171295");
      stationListClient1.add("171350");
      stationListClient1.add("171400");
      stationListClient1.add("171500");
      stationListClient1.add("171550");
      stationListClient1.add("171600");
      stationListClient1.add("171700");
      stationListClient1.add("171750");
      stationListClient1.add("171800");
      stationListClient1.add("171840");
      stationListClient1.add("171880");
      stationListClient1.add("171890");
      stationListClient1.add("171900");
      stationListClient1.add("171905");
      stationListClient1.add("171950");
      stationListClient1.add("171990");
      stationListClient1.add("172000");
      stationListClient1.add("172005");
      stationListClient1.add("172020");
      stationListClient1.add("172050");
      stationListClient1.add("172100");
      stationListClient1.add("172180");
      stationListClient1.add("172190");
      stationListClient1.add("172340");
      stationListClient1.add("172370");
      stationListClient1.add("172400");
      stationListClient1.add("172410");
      stationListClient1.add("172440");
      stationListClient1.add("172480");
      stationListClient1.add("172500");
      stationListClient1.add("172600");
      stationListClient1.add("172700");
      stationListClient1.add("172720");
      stationListClient1.add("172734");
      stationListClient1.add("172800");
      stationListClient1.add("172900");
      stationListClient1.add("172920");
      stationListClient1.add("172950");
      stationListClient1.add("173000");
      stationListClient1.add("173100");
      stationListClient1.add("173300");
      stationListClient1.add("173500");
      stationListClient1.add("173520");
      stationListClient1.add("173700");
      stationListClient1.add("173750");
      stationListClient1.add("691464");

      //Pacific ocean stations
      ArrayList<String> pacificStationListClient1 = new ArrayList<String>();
      pacificStationListClient1.add("702759"); //Palau
      pacificStationListClient1.add("914080");

      pacificStationListClient1.add("749316"); //Marshall Islands
      pacificStationListClient1.add("912500");
      pacificStationListClient1.add("913660");
      pacificStationListClient1.add("913760");

      pacificStationListClient1.add("912120"); //Guam
      pacificStationListClient1.add("912180");

      pacificStationListClient1.add("912210"); //Mariana Islands
      pacificStationListClient1.add("912320");
      pacificStationListClient1.add("912333");

      pacificStationListClient1.add("912450"); //Wake Island

      pacificStationListClient1.add("913340"); //Micronesia
      pacificStationListClient1.add("913480");
      pacificStationListClient1.add("913481");
      pacificStationListClient1.add("913691");
      pacificStationListClient1.add("914130");

      pacificStationListClient1.add("916100"); //Kiribati

      //Infinite loop to keep the thread alive
      //Checks if the data needs to be linked to certain clients
      while (true) {
         int queueAmount = Run.validinput.size();
         if (queueAmount > 0) {
            //Make list for clients
            List<String> clientlist = new ArrayList<String>();

            //Hashmap containing valid data
            HashMap<String, String> hashmap = Run.validinput.poll();

            //Filter for Iran and neighbouring countries
            try {
               if (stationListClient1.contains(hashmap.get("StationNumber"))) {
                  //Filtered data required by client comes through. Add client name to list
                  clientlist.add("UniversityTeheran");  
               }
            } catch (Exception e) {
               //e.printStackTrace();
            }

            //Filter for Pacific ocean stations
            try {
               if (pacificStationListClient1.contains(hashmap.get("StationNumber"))) {
                  String temperature = hashmap.get("Temperature");

                  if (!temperature.equals("MISSING")) {
                     Double temp = Double.parseDouble(temperature);

                     if (temp >= 0 || temp <= 10) {
                        //Filtered data required by client comes through. Add client name to list
                        clientlist.add("UniversityTeheran");
                     }
                  }
               }
            } catch (Exception e) {
               //e.printStackTrace();
            }

            //Put client name from list into hashmap
            try {
               hashmap.put("Client", clientlist.toString());
            } catch (Exception e) {
               //e.printStackTrace();
            }

            //Submit filtered data
            Run.filteredinput.add(hashmap);
         }
      }
   }

   /**
    * Starts the thread
    */
   public void start() {
      System.out.println("[FILTER] Starting " +  threadName);
      if (t == null) {
         t = new Thread(this, threadName);
         t.start();
      }
   }
}