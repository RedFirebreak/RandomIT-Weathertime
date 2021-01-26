package RandomIT;

class Filter implements Runnable {
   private Thread t;
   private String threadName;
   
   Filter( String name) {
      threadName = name;
      System.out.println("[FILTER] Creating and starting " +  threadName );
   }
   
   // Runs the thread, insert code here to be run
   public synchronized void run() {
      System.out.println("[FILTER] Running " +  threadName );
      /* Infinite loop */
      while(true) {
         int queueAmount = Run.validinput.size();
         if (queueAmount > 0) {
            Run.filteredinput.add(Run.validinput.poll());
         }
      }
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