package RandomIT;

import java.net.Socket;
import java.io.BufferedReader;
import java.io.InputStreamReader;

/**
 * This class reads the incoming XML files
 * The files are then cut up in little pieces
 * These pieces are used to check the data
 * 
 * @author Maurice Pater (397390)
 * @version 1.0
 */
class ClientThread extends Thread {
  private Socket socket;

  /**
   * Constructor
   * 
   * @param socket The socket to connect to
   */
  public ClientThread(Socket socket) {
    this.socket = socket;
  }

  /**
    * Runs the thread 
    * Gets the .XML files and cuts it up into strings
    */
  @Override
  public synchronized void run() {
    try (BufferedReader in = new BufferedReader(new InputStreamReader(socket.getInputStream()))){
      String out = "";
      String line = "";
      while (true) {
        line = in.readLine();
        out += (line + "\n");
        if (line.equals("</WEATHERDATA>")) {
          Run.rawinput.add(out);
          out = "";
        }
      }
    } catch (Exception e) { 
      //e.printStackTrace();
    }
  }
}
