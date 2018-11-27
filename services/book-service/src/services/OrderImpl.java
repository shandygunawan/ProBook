package services;

import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.util.logging.Level;
import java.util.logging.Logger;

import javax.jws.WebService;

import org.json.JSONObject;

@WebService(endpointInterface = "services.Order")
public class OrderImpl implements Order {
	
	private String url_order = "http://localhost:8080/transfer"; 
	
	@Override
	public String orderBook(String book_id, int jumlah, String rekening, String category, double harga) throws IOException {
        double transfer_temp = jumlah * harga;
        String transfer_amount = Double.toString(transfer_temp);
        String body = "src_number="+rekening+"&dst_number=1&amount="+transfer_amount;
        URL link = new URL(url_order);
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
                Logger.getLogger(Order_cks.class.getName()).log(Level.SEVERE, null, ex);
            }
            return "success";
        }
        else{
            return "failed";
        }
		
	}
}
