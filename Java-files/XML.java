import java.io.File;
import java.util.Scanner;
import java.util.HashMap;
import java.util.ArrayList;
import javax.xml.parsers.DocumentBuilderFactory;  
import org.w3c.dom.Document;  

public class XML {

    public static void main(String args[]) {
        try {
            //Load all valid stations
            ArrayList<String> validStationNumbers = getStationsFromDatFile();
            
            //Load the XML-file to be read
            File file = new File("Java-files/output.XML");
            
            //Open the XML-file
            Document doc = DocumentBuilderFactory.newInstance().newDocumentBuilder().parse(file);

            //Normalizing the document helps generate correct results
            doc.getDocumentElement().normalize();

            //Get data values from XML-file
            String stationNumber = doc.getElementsByTagName("STN").item(0).getTextContent();
            String date = doc.getElementsByTagName("STN").item(0).getTextContent();
            String time = doc.getElementsByTagName("TIME").item(0).getTextContent();
            String temperature = doc.getElementsByTagName("TEMP").item(0).getTextContent();
            String dewPoint = doc.getElementsByTagName("DEWP").item(0).getTextContent();
            String stationLevelPressure = doc.getElementsByTagName("STP").item(0).getTextContent();
            String seaLevelPressure = doc.getElementsByTagName("SLP").item(0).getTextContent();
            String visibility = doc.getElementsByTagName("VISIB").item(0).getTextContent();
            String windSpeed = doc.getElementsByTagName("WDSP").item(0).getTextContent();
            String percipitation = doc.getElementsByTagName("PRCP").item(0).getTextContent();
            String snowDrop = doc.getElementsByTagName("SNDP").item(0).getTextContent();
            String events = doc.getElementsByTagName("FRSHTT").item(0).getTextContent();
            String cloudCoverage = doc.getElementsByTagName("CLDC").item(0).getTextContent();
            String windDirection = doc.getElementsByTagName("WNDDIR").item(0).getTextContent();

            Boolean freeze;
            if (events.charAt(0) == '1') {
                freeze = true;
            } else {
                freeze = false;
            }
            Boolean rain;
            if (events.charAt(1) == '1') {
                rain = true;
            } else {
                rain = false;
            }
            Boolean snow;
            if (events.charAt(2) == '1') {
                snow = true;
            } else {
                snow = false;
            }
            Boolean hail;
            if (events.charAt(3) == '1') {
                hail = true;
            } else {
                hail = false;
            }
            Boolean storm;
            if (events.charAt(4) == '1') {
                storm = true;
            } else {
                storm = false;
            }
            Boolean tornado;
            if (events.charAt(5) == '1') {
                tornado = true;
            } else {
                tornado = false;
            }

            //Temporary hashmap until we know what to do with data
            HashMap<String, String> returnHash = new HashMap<String, String>();

            //Actual checks if data is valid
            if (validStationNumbers.contains(stationNumber)) {
                if (Double.parseDouble(temperature) > -9999.9 && Double.parseDouble(temperature) < 9999.9) { 
                    if (Double.parseDouble(dewPoint) > -9999.9 && Double.parseDouble(dewPoint) < 9999.9) { 
                        if (Double.parseDouble(stationLevelPressure) > 0 && Double.parseDouble(stationLevelPressure) < 9999.9) { 
                            if (Double.parseDouble(seaLevelPressure) > 0 && Double.parseDouble(seaLevelPressure) < 9999.9) { 
                                if (Double.parseDouble(visibility) > 0 && Double.parseDouble(visibility) < 999.9) { 
                                    if (Double.parseDouble(windSpeed) > 0 && Double.parseDouble(windSpeed) < 999.9) { 
                                        if (Double.parseDouble(percipitation) > 0 && Double.parseDouble(percipitation) < 999.9) { 
                                            if (Double.parseDouble(snowDrop) > -999.9 && Double.parseDouble(snowDrop) < 9999.9) { 
                                                if (Double.parseDouble(cloudCoverage) > 0 && Double.parseDouble(cloudCoverage) < 99.9) { 
                                                    if (Double.parseDouble(windDirection) > 0 && Double.parseDouble(windDirection) < 359) { 
                                                        System.out.println("DEBUG De data is valide.");
                                                        //Add keys and values
                                                        returnHash.put("StationNumber", stationNumber);
                                                        returnHash.put("Date", date);
                                                        returnHash.put("Time", time);
                                                        returnHash.put("Temperature", temperature);
                                                        returnHash.put("DewPoint", dewPoint);
                                                        returnHash.put("StationLevelPressure", stationLevelPressure);
                                                        returnHash.put("SeaLevelPressure", seaLevelPressure);
                                                        returnHash.put("Visibility", visibility);
                                                        returnHash.put("Windspeed", windSpeed);
                                                        returnHash.put("Percipitation", percipitation);
                                                        returnHash.put("SnowDrop", snowDrop);
                                                        returnHash.put("Freeze", freeze.toString());
                                                        returnHash.put("Rain", rain.toString());
                                                        returnHash.put("Snow", snow.toString());
                                                        returnHash.put("Hail", hail.toString());
                                                        returnHash.put("Storm", storm.toString());
                                                        returnHash.put("Tornado", tornado.toString());
                                                        returnHash.put("CloudCoverage", cloudCoverage);
                                                        returnHash.put("WindDirection", windDirection);   
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                System.out.println("DEBUG De data is niet valide."); 
            }
        } catch (Exception e) {  
            e.printStackTrace();  
        } 
    }

    public static ArrayList<String> getStationsFromDatFile() {
        ArrayList<String> stationNrList = new ArrayList<String>();
        try (Scanner scanner = new Scanner(new File("Java-files/station_country_data.dat"))) {
            while(scanner.hasNextLine()) {
                String line = scanner.nextLine().toLowerCase().replaceAll("[^[0-9]+$]", "");
                stationNrList.add(line);
            }
        } catch (Exception e) {  
            e.printStackTrace();  
        }
        return stationNrList;
    }
}