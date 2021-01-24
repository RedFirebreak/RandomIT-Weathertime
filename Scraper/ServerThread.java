import java.io.*;
import java.net.*;

/**
 * This thread is responsible to handle client connection.
 *
 * @author www.codejava.net
 */
public class ServerThread extends Thread
{
    private Socket socket;
    public BufferedReader in = null;
    public String textOutput;

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
          textOutput += (line + "\n");
          if(line.equals("</WEATHERDATA>")) {
            //System.out.println(textOutput);
            textOutput = "";
          }
        }
      }
      catch(IOException i)
      {
      }
    }
}
