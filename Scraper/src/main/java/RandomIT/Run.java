package RandomIT;

import java.util.Queue;
import java.util.HashMap;
import java.util.LinkedList;

public class Run {
    public static final Queue<String> rawinput        = new LinkedList<String>();
    public static final Queue<HashMap> validinput     = new LinkedList<HashMap>();
    public static final Queue<HashMap> filteredinput  = new LinkedList<HashMap>();

    public static void main( String[] args ) {
        /** Reciever thread */
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

        // Starting!
        datareceiver.start();
        parser.start();
        filter.start();
        datastorage.start();

        /* Infinite loop to monitor this script
        while(i < 200) {
            System.out.println( "[LOG] RunAmount: " + i );
            i = i + 1;
        }*/
    }
}
