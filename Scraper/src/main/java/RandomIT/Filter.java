package RandomIT;

class Filter implements Runnable {
   private Thread t;
   private String threadName;
   
   Filter( String name) {
      threadName = name;
      System.out.println("[FILTER] Creating and starting " +  threadName );
   }
   
   // Runs the thread, insert code here to be run
   public void run() {
      System.out.println("[FILTER] Running " +  threadName );
      int i = 0;
      /* Infinite loop */
      while(i < 25) {
         System.out.println( "[FILTER] RunAmount: " + i );
         i = i + 1;
      }
      System.out.println("[FILTER] Thread " +  threadName + " exiting.");
   }

   // Starts the thread
   public void start () {
      System.out.println("[FILTER] Starting " +  threadName );
      if (t == null) {
         t = new Thread (this, threadName);
         t.start ();
      }
   }
 }