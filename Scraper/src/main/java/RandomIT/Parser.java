package RandomIT;

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
      int i = 0;
      /* Infinite loop */
      while(i < 25) {
         System.out.println( "[PARSER] RunAmount: " + i );
         i = i + 1;
      }
      System.out.println("[PARSER] Thread " +  threadName + " exiting.");
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