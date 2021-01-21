import java.io.File;
import java.util.HashMap;
import javax.xml.parsers.DocumentBuilderFactory;  
import org.w3c.dom.Document;  

public class XML {

    public static final double MAXTEMPERATURE = 10.0;

    public static void main(String args[]) {
        try {
            //Load the file
            File file = new File("Java-files/output.XML");

            //Open the XML-file
            Document doc = DocumentBuilderFactory.newInstance().newDocumentBuilder().parse(file);

            //Normalizing the document helps generate correct results
            doc.getDocumentElement().normalize();

            //Get temperature from XML-file
            double temperature = Double.parseDouble(doc.getElementsByTagName("TEMP").item(0).getTextContent());

            //Temporary hashmap until we know what to do with data
            HashMap<String, String> returnHash = new HashMap<String, String>();

            // if statement needs to be bigger and better, TBA
            if(temperature >= MAXTEMPERATURE) { 
                System.out.println("DEBUG De temperatuur hoog genoeg, namelijk: " + temperature + "°C.");

                //Add keys and values
                returnHash.put("StationNumber", doc.getElementsByTagName("STN").item(0).getTextContent());
                returnHash.put("Date", doc.getElementsByTagName("STN").item(0).getTextContent());
                returnHash.put("Time", doc.getElementsByTagName("TIME").item(0).getTextContent());
                returnHash.put("Temperature", doc.getElementsByTagName("TEMP").item(0).getTextContent());
                returnHash.put("DewPoint", doc.getElementsByTagName("DEWP").item(0).getTextContent());
                returnHash.put("StationLevelPressure", doc.getElementsByTagName("STP").item(0).getTextContent());
                returnHash.put("SeaLevelPressure", doc.getElementsByTagName("SLP").item(0).getTextContent());
                returnHash.put("Visibility", doc.getElementsByTagName("VISIB").item(0).getTextContent());
                returnHash.put("Windspeed", doc.getElementsByTagName("WDSP").item(0).getTextContent());
                returnHash.put("Percipitation", doc.getElementsByTagName("PRCP").item(0).getTextContent());
                returnHash.put("SnowDrop", doc.getElementsByTagName("SNDP").item(0).getTextContent());
                returnHash.put("Events", doc.getElementsByTagName("FRSHTT").item(0).getTextContent()); // is in binary, may need to unpack
                returnHash.put("CloudCoverage", doc.getElementsByTagName("CLDC").item(0).getTextContent());
                returnHash.put("WindDirection", doc.getElementsByTagName("WNDDIR").item(0).getTextContent());                
            } else {
                System.out.println("DEBUG De temperatuur is te laag, namelijk: " + temperature + "°C."); 
            }
        } catch (Exception e) {  
            e.printStackTrace();  
        } 
    }
}