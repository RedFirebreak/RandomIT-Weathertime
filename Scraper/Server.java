import java.io.*;
import java.net.*;
import java.util.*;

public class Server
{
    //initialize socket and input stream
    private Socket socket = null;
    private ServerSocket server = null;
    public static Stack<String> xml = new Stack<String>();

    // constructor with port
    public Server(int port)
    {
      try
      {
        // starts server and waits for a connection
        server = new ServerSocket(port);

        while(true)
        {
          socket = server.accept();
          new ServerThread(socket).start();
        }
  		}
      catch(IOException | NullPointerException i)
      {
      }
    }

    public static void main(String args[])
    {
      Server server = new Server(7789);
    }
}
