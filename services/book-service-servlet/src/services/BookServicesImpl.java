package services;

import javax.jws.WebService;
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

import javax.jws.WebParam;
import javax.jws.WebService;

import org.json.JSONObject;

import com.mysql.jdbc.jdbc2.optional.MysqlDataSource;

import db.DBHandler;
import util.NetworkHandler;
import api.GoogleBookAPI;
import db.DBHandler;

@WebService(endpointInterface = "services.BookServices")
public class BookServicesImpl implements BookServices {
	@Override
	public String searchBooksByTitle(String title) {
		return GoogleBookAPI.getBooksByTitle(title);
	}
	
	@Override
	public String getBookDetails(String id) {
		return GoogleBookAPI.getBookDetails(id);
	}
	
	@Override
	public String getBookRecommendation(String category) {
		try {
			
			// Search for the most ordered book with the corresponding category
			String mostOrderedBook = DBHandler.getMostOrderedBookIdByCategory(category);
			// If there is no order in the category
			// return a random book from the corresponding category
			if(mostOrderedBook.matches("NONE")) {
				return GoogleBookAPI.getRandomBookByCategory(category.replace(" ", "+"));
			}
			
			return getBookDetails(mostOrderedBook);
		}
		catch(Exception e) {
			System.out.println("MESSAGE: " + e.getMessage());
			System.out.println("STACK TRACE:");
			e.printStackTrace();
			
			return null;
		}
	}
	
	@Override
	public String orderBook(@WebParam(name = "book_id") String book_id, @WebParam(name = "user_id") int user_id, @WebParam(name="jumlah")int jumlah, @WebParam(name="rekening") String rekening, @WebParam(name="category") String category, @WebParam(name="harga") double harga) throws IOException {
		
		String url = "http://localhost:8083/api/v1/transactions/new";
        double transfer_temp = jumlah * harga;
        String transfer_amount = Double.toString(transfer_temp);
        String body = "src_number="+rekening+"&dst_number=1234123412341234&amount="+transfer_amount;
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
        try {
        	JSONObject data = new JSONObject(response.toString());
            String response_data = data.getString("response");
            
            if (response_data.equals("Transaction success")){
                try {
                	System.out.println("checkpoint");
                	DBHandler.insertOrder(book_id, user_id, category, jumlah);
                    
                } catch (SQLException ex) {
                    Logger.getLogger(Order.class.getName()).log(Level.SEVERE, null, ex);
                }
                return "success";
            }
            else{
                return "failed";
            }
        }
        catch(Exception e) {
        	System.out.println("MESSAGE: " + e.getMessage());
			System.out.println("STACK TRACE:");
			e.printStackTrace();
			
			return null;
        }
        
		/*
		String url = "http://localhost:8083/api/v1/transactions/new";
        double transfer_temp = jumlah * harga;
        String transfer_amount = Double.toString(transfer_temp);
        String params = "src_number="+rekening+"&dst_number=1234123412341234&amount="+transfer_amount;
        URL link = new URL(url);
        
        String response_data = null;
        
        try {
        	response_data = NetworkHandler.httpConPost(url, params);
        }
        catch(Exception e) {
        	System.out.println("MESSAGE: " + e.getMessage());
			System.out.println("STACK TRACE:");
			e.printStackTrace();
        }
        
        if (response_data.equals("Transaction success")){
        	try {
        		DBHandler.insertOrder(book_id, user_id, category, jumlah);
        		return "success";
        	}
        	catch(Exception e) {
        		
    			return null;
        	}
        }
        else{
            return "failed";
        }
        */
	}
	
	@Override
	public String getOrdersByUserId(Integer user_id) throws Exception {
		return DBHandler.getOrdersByUserId(user_id);
	}
	
	@Override
	public String getNewestOrderByUserId(Integer user_id) throws Exception {
		return DBHandler.getNewestOrderByUserId(user_id);
	}
	
	@Override
	public String getReviewsByBookId(String book_id) throws Exception {
		return DBHandler.getReviewsByBookId(book_id);
	}
	
	@Override
	public void updateOrderReview(@WebParam(name = "order_id") Integer order_id, @WebParam(name = "score") Integer score, @WebParam(name = "comment") String comment) throws Exception {
		try {
			DBHandler.updateOrderReview(order_id, score, comment);
		}
		catch(Exception e) {
			System.out.println("MESSAGE: " + e.getMessage());
			System.out.println("STACK TRACE:");
			e.printStackTrace();
		}
	}
}
