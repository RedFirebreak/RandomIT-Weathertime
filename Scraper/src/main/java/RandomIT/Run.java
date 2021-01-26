package RandomIT;
import java.util.*;

public class Run {
    public static final Queue<String> rawinput        = new LinkedList<String>();
    public static final Queue<HashMap> validinput     = new LinkedList<HashMap>();
    public static final Queue<HashMap> filteredinput  = new LinkedList<HashMap>();

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
          Thread.sleep(1000);
          if(rawinput.size() == 0){
          }
          else{
            System.out.println(rawinput.peek());
            System.out.println(rawinput.size());
          }
        }
    }
}
