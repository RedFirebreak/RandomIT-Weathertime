package RandomIT;

import java.net.ServerSocket;

/**
 * Setup the data connection between the socket and the port
 * 
 * @author Maurice Pater (397390)
 * @version 1.0
 */
class DataReceiver implements Runnable {
   private Thread t;
   private String threadName;
   private int port;

   /**
    * Constructor
    * 
    * @param name The name for the thread
    * @param port The port for the socket
    */
   DataReceiver(String name, int port) {
      threadName = name;
      this.port = port;
      System.out.println("[RECEIVER] Creating and starting " +  threadName);
   }

   /**
    * Runs the thread 
    * Sets up the port on which the socket is setup
    * Then starts to run the socket
    */
   @Override
   public synchronized void run() {
      //starts server and waits for a connection
      try (ServerSocket server = new ServerSocket(port)) {
         while (true) {
            new ClientThread(server.accept()).start();
         }
      } catch (Exception e) {
         //e.printStackTrace();
      }
   }

   /**
    * Starts the thread
    */
   public void start() {
      System.out.println("[RECEIVER] Starting " +  threadName);
      if (t == null) {
         t = new Thread(this, threadName);
         t.start();
      }
   }
}
