package RandomIT;

class DataReceiver implements Runnable {
   private Thread t;
   private String threadName;
   
   DataReceiver( String name) {
      threadName = name;
      System.out.println("[RECEIVER] Creating and starting " +  threadName );
   }
   
   // Runs the thread, insert code here to be run. If the thread is done, it will exit automatically. Make an infinite loop to make sure it stays active if needed.
   public void run() {
      System.out.println("[RECEIVER] Running " +  threadName );
      int i = 0;
      /* Infinite loop */
      while(i < 25) {
         System.out.println( "[RECEIVER] RunAmount: " + i );
         i = i + 1;
      }
      //System.out.println("[RECEIVER] Thread " +  threadName + " exiting.");
   }

   // Starts the thread
   public void start () {
      System.out.println("[RECEIVER] Starting " +  threadName );
      if (t == null) {
         t = new Thread (this, threadName);
         t.start ();
      }
   }
 }