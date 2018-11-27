package main;

import javax.xml.ws.Endpoint;
import java.sql.ResultSet;
import java.util.Date;

import api.GoogleBookAPI;
import db.DBHandler;
import services.SearchImpl;

public class Main {
	
	public static void main(String[] args) {
		
		/*
		try {
			Endpoint.publish("http://localhost:8081/services/search", new SearchImpl());
			Endpoint.publish("http://localhost:8082/services/order", new OrderImpl());
		}
		
		catch(Exception e) {
			e.printStackTrace();
		}
		
		*/
		
		try {
//			DBHandler.insertOrder("CpXeKjZN7ZAC", 1, "Computers", 1);
//			DBHandler.insertOrder("PJZGDwAAQBAJ", 2, "Computers", 5);
//			DBHandler.insertOrder("RMNiDwAAQBAJ", 1, "Computers", 3);
			String mostOrderedComputers = DBHandler.getMostOrderedBookIdByCategory("Computers");
			String mostOrderedFiction = DBHandler.getMostOrderedBookIdByCategory("Fiction");
			System.out.println(mostOrderedComputers);
			System.out.println(mostOrderedFiction);
			
		}
		catch(Exception e) {
			System.out.println("MESSAGE: " + e.getMessage());
			System.out.println("STACK TRACE:");
			e.printStackTrace();
		}
		
		
	}
}
