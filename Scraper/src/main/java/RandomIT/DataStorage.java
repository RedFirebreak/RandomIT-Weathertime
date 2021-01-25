package RandomIT;

class DataStorage implements Runnable {
   private Thread t;
   private String threadName;
   
   DataStorage( String name) {
      threadName = name;
      System.out.println("[DATASTORAGE] Creating and starting " +  threadName );
   }
   
   // Runs the thread, insert code here to be run
   public void run() {
      System.out.println("[DATASTORAGE] Running " +  threadName );
      int i = 0;
      /* Infinite loop */
      while(i < 25) {
         System.out.println( "[DATASTORAGE] RunAmount: " + i );
         i = i + 1;
      }
      System.out.println("[DATASTORAGE] Thread " +  threadName + " exiting.");
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