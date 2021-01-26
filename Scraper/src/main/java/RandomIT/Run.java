package RandomIT;
import java.util.Queue;
import java.util.HashMap;
import java.util.LinkedList;


public class Run {
    public static volatile Queue<String> rawinput = new LinkedList<String>();
    public static volatile Queue<HashMap<String, String>> validinput = new LinkedList<HashMap<String, String>>();
    public static volatile Queue<HashMap<String, String>> filteredinput = new LinkedList<HashMap<String, String>>();

    public static void main( String[] args ) throws InterruptedException {

        /** Receiver thread */
        System.out.println( "[LOG] Starting receiver thread" );
        DataReceiver datareceiver = new DataReceiver("Receiver 1");


        /** Parser thread */
        System.out.println( "[LOG] Starting parser thread" );
        Parser parser = new Parser("Parser 1");


        /** Filter thread */
        System.out.println( "[LOG] Starting filter thread" );
        Filter filter = new Filter("Filter 1");
        

        /** Store thread */
        System.out.println( "[LOG] Starting datastorage thread" );
        DataStorage datastorage = new DataStorage("Datastorage 1");

        System.out.println( "[LOG] Starting server thread" );

        // Starting!
        datareceiver.start();
        parser.start();
        filter.start();
        datastorage.start();

        while(true){
          //System.out.println("RAWINPUT SIZE: " + rawinput.size());
          //System.out.println("VALIDINPUT SIZE: " + validinput.size());
          //System.out.println("FILTEREDINPUT SIZE: " + filteredinput.size());
        }
    }
}
