import java.io.*;
import java.net.*;

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
            System.out.println(out);
            out = "";
          }
        }
      }
      catch(IOException | NullPointerException i)
      {
      }
    }
}
