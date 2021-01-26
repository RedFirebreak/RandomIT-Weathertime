package RandomIT;
import java.io.*;
import java.net.*;

class ClientThread extends Thread
{
    private Socket socket;
    private BufferedReader in = null;
    private String out;

    public ClientThread(Socket socket)
    {
        this.socket = socket;
    }

    public synchronized void run() {
      try {
        // takes input from the client socket
        in = new BufferedReader(new InputStreamReader(socket.getInputStream()));
        String line = "";

        while(true)
        {
          line = in.readLine();
          out += (line + "\n");
          if(line.equals("</WEATHERDATA>")) {
            Run.rawinput.add(out);
            out = "";
          }
        }
      } catch(IOException | NullPointerException i) {
      }
    }
}
