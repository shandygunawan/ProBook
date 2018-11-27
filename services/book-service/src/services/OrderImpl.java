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

import javax.jws.WebParam;
import javax.jws.WebService;

import org.json.JSONObject;

import db.DBHandler;

@WebService(endpointInterface = "services.Order")
public class OrderImpl implements Order {
	
	@Override
	public String getOrdersByUserId(Integer user_id) throws Exception {
		return DBHandler.getOrdersByUserId(user_id);
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
