import java.io.*;
import java.net.*;
import java.util.*;

public class ServerThread extends Thread
{
    private Socket socket;
    private BufferedReader in = null;
    private String out;

    public ServerThread(Socket socket)
    {
        this.socket = socket;
    }

    public void run()
    {
      try
      {
        // takes input from the client socket
        in = new BufferedReader(new InputStreamReader(socket.getInputStream()));
        String line = "";

        while(true)
        {
          line = in.readLine();
          out += (line + "\n");
          if(line.equals("</WEATHERDATA>")) {
            Server.xml.add(out);
            //String xml = Server.xml.get(0);
            //System.out.println(xml);
            int count = Server.xml.size();
            System.out.println("aantal XML bestanden: " + count);
            out = "";
          }
        }
      }
      catch(IOException | NullPointerException i)
      {
      }
    }
}
