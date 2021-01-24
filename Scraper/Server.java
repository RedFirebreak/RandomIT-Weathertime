// A Java program for a Server
import java.net.*;
import java.io.*;

public class Server
{
    //initialize socket and input stream
    public Socket socket = null;
    public ServerSocket server = null;
    public int counter = 1;

    // constructor with port
    public Server(int port)
    {
        // starts server and waits for a connection
        try
        {
            server = new ServerSocket(port);
            System.out.println("Server started");

            System.out.println("Waiting for a client ...");
            while(true)
            {
              socket = server.accept();
              System.out.println("Client accepted");

              //thread
              new ServerThread(socket).start();
              System.out.println("thread: " + counter++);
            }
				}
        catch(IOException i)
        {
        }
    }

    public static void main(String args[])
    {
        Server server = new Server(7789);
    }
}
