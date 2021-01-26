package RandomIT;
import java.io.*;
import java.net.*;
import java.util.*;

class DataReceiver implements Runnable {
   private Thread t;
   private String threadName;
   private Socket socket = null;
   private ServerSocket server = null;
   private int port = 7789;

   DataReceiver(String name) {
      threadName = name;
      System.out.println("[RECEIVER] Creating and starting " +  threadName );
   }

   // Runs the thread, insert code here to be run. If the thread is done, it will exit automatically. Make an infinite loop to make sure it stays active if needed.
   public void run() {
     try
     {
       // starts server and waits for a connection
       server = new ServerSocket(port);

       while(true)
       {
         socket = server.accept();
         new ClientThread(socket).start();
       }
     }
     catch(IOException | NullPointerException i)
     {
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
