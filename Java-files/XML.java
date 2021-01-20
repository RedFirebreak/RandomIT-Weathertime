import java.io.File;
import javax.xml.parsers.DocumentBuilderFactory;  
import javax.xml.parsers.DocumentBuilder;  
import org.w3c.dom.Document;  
import org.w3c.dom.NodeList;  
import org.w3c.dom.Node;  
import org.w3c.dom.Element;  

public class XML {

    public static void main(String args[]) {
        try {
            File file = new File("Java-files/probeersel.XML");
            DocumentBuilderFactory dbf = DocumentBuilderFactory.newInstance();  
            
            DocumentBuilder db = dbf.newDocumentBuilder();  
            Document doc = db.parse(file);  
            doc.getDocumentElement().normalize();  
            System.out.println("Root element: " + doc.getDocumentElement().getNodeName());  

            NodeList nodeList = doc.getElementsByTagName("student");  
            
            for (int i = 0; i < nodeList.getLength(); i++) {  
                Node node = nodeList.item(i);  
                System.out.println("\nNode Name :" + node.getNodeName());  
                if (node.getNodeType() == Node.ELEMENT_NODE) {  
                    Element eElement = (Element) node;  
                    System.out.println("Student id: "+ eElement.getElementsByTagName("id").item(0).getTextContent());  
                    System.out.println("First Name: "+ eElement.getElementsByTagName("firstname").item(0).getTextContent());  
                    System.out.println("Last Name: "+ eElement.getElementsByTagName("lastname").item(0).getTextContent());  
                    System.out.println("Subject: "+ eElement.getElementsByTagName("subject").item(0).getTextContent());  
                    System.out.println("Marks: "+ eElement.getElementsByTagName("marks").item(0).getTextContent());  
                }  
            }  
        } catch (Exception e) {  
            e.printStackTrace();  
        } 
    }
}