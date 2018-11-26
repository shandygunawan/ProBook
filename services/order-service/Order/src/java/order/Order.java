/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package order;

import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import javax.jws.WebService;
import javax.jws.WebMethod;
import javax.jws.WebParam;
import org.json.*;
import java.sql.*;
import com.mysql.jdbc.jdbc2.optional.MysqlDataSource;
import java.io.IOException;
import java.util.logging.Level;
import java.util.logging.Logger;


/**
 *
 * @author ASUS
 */
@WebService(serviceName = "Order")
public class Order {

    /**
     * This is a sample web service operation
     * @param book_id
     * @param jumlah
     * @param rekening
     * @param category
     * @param harga
     * @return 
     * @throws java.io.IOException 
     */
    @WebMethod(operationName = "orderBook")
    public String orderBook(@WebParam(name = "book") String book_id, @WebParam(name="jumlah")int jumlah, @WebParam(name="rekening") String rekening, @WebParam(name="category") String category, @WebParam(name="harga") double harga) throws IOException  {
        String url = "http://localhost:8081/transfer";
        double transfer_temp = jumlah * harga;
        String transfer_amount = Double.toString(transfer_temp);
        String body = "src_number="+rekening+"&dst_number=1&amount="+transfer_amount;
        URL link = new URL(url);
        HttpURLConnection connection =  (HttpURLConnection) link.openConnection();
        connection.setRequestMethod("POST");
        connection.setDoOutput(true);
        DataOutputStream wr = new DataOutputStream(connection.getOutputStream());
        wr.writeBytes(body);
	wr.flush();
        wr.close();
        BufferedReader in = new BufferedReader(new InputStreamReader(connection.getInputStream()));
        String input;
        StringBuffer response = new StringBuffer();
        
        while ((input = in.readLine()) != null){
            response.append(input);
        }
        in.close();
        JSONObject data = new JSONObject(response.toString());
        String response_data = data.getString("response");
        
        if (response_data.equals("Transaction success")){
            try {
                
                MysqlDataSource mysql = new MysqlDataSource();
                mysql.setUser("root");
                mysql.setPassword("");
                mysql.setServerName("localhost");
                mysql.setDatabaseName("bookservice");
                
                Connection con = mysql.getConnection();
                
                //query
                PreparedStatement stmt =null;
                stmt = con.prepareStatement("INSERT INTO orders (book_id, category,jumlah) VALUES (?,?,?)");
                stmt.setString(1,book_id);
                stmt.setString(2,category);
                stmt.setInt(3,jumlah);
                stmt.executeUpdate();
                con.commit();
                
                stmt.close();
                con.close();
                
            } catch (SQLException ex) {
                Logger.getLogger(Order.class.getName()).log(Level.SEVERE, null, ex);
            }
            return "success";
        }
        else{
            return "failed";
        }
        
        
    }
}
