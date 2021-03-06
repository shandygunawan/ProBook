package main;

import javax.xml.ws.Endpoint;
import java.sql.ResultSet;
import java.util.Date;

import api.GoogleBookAPI;
import db.DBHandler;
import services.OrderImpl;
import services.SearchImpl;

public class Main {
	
	public static void main(String[] args) {
		
		
		try {
			Endpoint.publish("http://localhost:8081/services/search", new SearchImpl());
			Endpoint.publish("http://localhost:8082/services/order", new OrderImpl());
		}
		
		catch(Exception e) {
			e.printStackTrace();
		}
		
		
		
		
		try {
			
//			OrderImpl orderImpl = new OrderImpl();
//			String result = orderImpl.getNewestOrderByUserId(2);
//			System.out.println(result);
//			orderImpl.orderBook("CpXeKjZN7ZAC", 3, 2, "1234123412341234", "Computers", 1000.00);
			
//			Float rating = DBHandler.getAverageRatingByBookId("PJZGDwAAQBAJ");
//			System.out.println(rating.toString());
//			 DBHandler.insertOrder("CpXeKjZN7ZAC", 1, "Computers", 1);
//			 DBHandler.insertOrder("PJZGDwAAQBAJ", 2, "Computers", 5);
//			 DBHandler.insertOrder("RMNiDwAAQBAJ", 1, "Computers", 3);
//			 String mostOrderedComputers = DBHandler.getMostOrderedBookIdByCategory("Computers");
//			 String mostOrderedFiction = DBHandler.getMostOrderedBookIdByCategory("Fiction");
//			 System.out.println(mostOrderedComputers);
//			 System.out.println(mostOrderedFiction);
			 
//			 String orders = DBHandler.getOrdersByUserId(1);
//			 System.out.println(orders);
			
//			DBHandler.updateOrderReview(4, 3, "Easy to read.");
			
//			System.out.println(DBHandler.getReviewsByBookId("CpXeKjZN7ZAC"));
			
			// OK SearchImpl searchImpl = new SearchImpl();
			// OK String book = searchImpl.getBooksRecommendation("Fiction");
			// OK System.out.println(book);
			
		}
		catch(Exception e) {
			System.out.println("MESSAGE: " + e.getMessage());
			System.out.println("STACK TRACE:");
			e.printStackTrace();
		}
		
		
	}
}
