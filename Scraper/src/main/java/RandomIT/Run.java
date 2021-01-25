package RandomIT;

public class Run {
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
