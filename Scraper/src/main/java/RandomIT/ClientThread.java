package RandomIT;
import java.io.*;
import java.net.*;
import java.util.*;

class ClientThread extends Thread
{
    private Socket socket;
    private BufferedReader in = null;
    private String out;

    public ClientThread(Socket socket)
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
            ServerThread.xml.push(out);
            //String xml = ServerThread.xml.getLast();
            //System.out.println(xml);
            int count = ServerThread.xml.size();
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
