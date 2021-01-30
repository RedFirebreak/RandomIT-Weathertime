package RandomIT;

import java.util.Queue;
import java.util.HashMap;
import java.util.LinkedList;

/**
 * This class will start threads and multithreading
 * It also creates the Queues needed for other classes
 * 
 * @author Stefan Jilderda (406347)
 * @version 1.0
 */
public class Run {
  public static volatile Queue<String> rawinput = new LinkedList<String>();
  public static volatile Queue<HashMap<String, String>> validinput = new LinkedList<HashMap<String, String>>();
  public static volatile Queue<HashMap<String, String>> filteredinput = new LinkedList<HashMap<String, String>>();
  private static final int port = 7789;

  public static void main(String[] args) {
    //Data receiver thread
    System.out.println("[LOG] Starting receiver thread");
    DataReceiver datareceiver = new DataReceiver("Receiver 1", port);

    //Data parser thread
    System.out.println("[LOG] Starting parser thread");
    Parser parser = new Parser("Parser 1");

    //Data filter thread
    System.out.println("[LOG] Starting filter thread");
    Filter filter = new Filter("Filter 1");

    //Data storage thread
    System.out.println("[LOG] Starting datastorage thread");
    DataStorage datastorage1 = new DataStorage("Datastorage 1");

    System.out.println("[LOG] Starting server thread");

    //Starting...
    datareceiver.start();
    parser.start();
    filter.start();
    datastorage1.start();
  }
}
