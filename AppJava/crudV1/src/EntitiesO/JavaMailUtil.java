/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package EntitiesO;

import java.util.Properties;
import javax.mail.Authenticator;
import javax.mail.Message;
import javax.mail.MessagingException;
import javax.mail.PasswordAuthentication;
import javax.mail.Session;
import javax.mail.Transport;
import javax.mail.internet.AddressException;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeMessage;

/**
 *
 * @author BENJOU
 */
public class JavaMailUtil {
    
    public static void sendmail(String recipient,String Subject,String Text) throws AddressException, MessagingException {
       
        System.out.println("en cours d'envoi...");
       
        Properties properties = new Properties();
        properties.put("mail.smtp.auth", "true");
        properties.put("mail.smtp.starttls.enable", "true");
        properties.put("mail.smtp.host", "smtp.gmail.com");
        properties.put("mail.smtp.port", "587");
       
        String myAccountEmail="benjabli98@gmail.com";
        String password= "benjou1964";
       
        Session session = Session.getInstance(properties, new Authenticator(){
            @Override
            protected PasswordAuthentication getPasswordAuthentication() {
               return  new PasswordAuthentication(myAccountEmail,password);
        }
        });
       
        Message message = prepareMessage(session, myAccountEmail , recipient, Subject, Text);
        Transport.send(message);
        System.out.println("message envoyé");
    
       
       
   
   
}

    private static Message prepareMessage(Session session, String myAccountEmail, String recipient, String Subject, String Text) throws AddressException, MessagingException {
    Message message= new MimeMessage(session);
    message.setFrom(new InternetAddress(myAccountEmail));
    message.setRecipient(Message.RecipientType.TO, new InternetAddress(recipient));
    message.setSubject(Subject);
    message.setText(Text);
        return message;
    }
    
}
