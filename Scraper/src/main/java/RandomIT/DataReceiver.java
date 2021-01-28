package RandomIT;

import java.net.Socket;
import java.net.ServerSocket;

class DataReceiver implements Runnable {
   private Thread t;
   private String threadName;
   private Socket socket = null;
   private ServerSocket server = null;
   private int port = 7789;

   DataReceiver(String name) {
      threadName = name;
      System.out.println("[RECEIVER] Creating and starting " +  threadName);
   }

   //Runs the thread
   public synchronized void run() {
      try {
         //starts server and waits for a connection
         server = new ServerSocket(port);

         while (true)
         {
            socket = server.accept();
            new ClientThread(socket).start();
         }
      } catch (Exception e) {
         //e.printStackTrace();
      }
   }

   //Starts the thread
   public void start() {
      System.out.println("[RECEIVER] Starting " +  threadName);
      if (t == null) {
         t = new Thread(this, threadName);
         t.start();
      }
   }
}
