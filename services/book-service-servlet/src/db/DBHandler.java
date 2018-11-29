package db;

import java.sql.Connection;
import java.sql.Date;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.text.DecimalFormat;
import java.util.ArrayList;

import org.json.JSONArray;

import model.Book;
import model.SaleInfo;
import util.Convertor;

public class DBHandler {
	private final static String JDBC_DRIVER = "com.mysql.jdbc.Driver";
	private final static String DB_URL = "jdbc:mysql://localhost:3306/wsbook";
	private final static String USER = "root";
	private final static String PASS = "";
	private final static String TABLE_ORDER = "orders";
	private final static String TABLE_PRICE = "Prices";
	private static Connection conn;
	
	public static Connection getConnection() {
		if(conn == null) {
			try {
				// Try to connect to DB
				Class.forName(JDBC_DRIVER);
				conn = DriverManager.getConnection(DB_URL, USER, PASS);
				
				// Success
				System.out.println(String.format("Connected to database %s " + "successfully.", conn.getCatalog()));
				
			}
			catch(Exception e) {
				System.out.println("MESSAGE: " + e.getMessage());
				System.out.println("STACK TRACE:");
				e.printStackTrace();
				
				return null;
			}
		}
		
		return conn;
	}
	
	public static void fetchPricesFromGoogleApi(ArrayList<Book> book_list) throws SQLException {
		Connection conn = getConnection();
		
		for(Book book : book_list) {
			SaleInfo saleInfo = book.getSaleInfo();

			if(saleInfo.getSaleability().matches("FOR_SALE")) {
				String query = "INSERT INTO " + DBHandler.TABLE_PRICE + "(BookId, Price) VALUES (?, ?) ON DUPLICATE KEY UPDATE Price = ?;";
				PreparedStatement stmt = conn.prepareStatement(query);
				stmt.setString(1, book.getId());
				stmt.setFloat(2, saleInfo.getRetailPrice().getAmount());
				stmt.setFloat(3, saleInfo.getRetailPrice().getAmount());
				
				stmt.executeUpdate();
			}
		}
		
	}
	
	public static Float getPriceByBookId(String book_id) throws SQLException {
		Connection conn = getConnection();
		
		// SQL query
		String query = "SELECT price FROM " + DBHandler.TABLE_PRICE + " WHERE BookId = ?;";
		
		// Prepare statement and get query's result
		PreparedStatement stmt = conn.prepareStatement(query);
		stmt.setString(1, book_id);
		
		ResultSet result = stmt.executeQuery();
		
		Float price = result.next() ? result.getFloat("Price"):-1f; 
		
		return price; 
	}
	
	public static String getMostOrderedBookIdByCategory(String category) throws SQLException {
		Connection conn = getConnection();
		
		// SQL query
		String query = "SELECT BookId, SUM(Amount) as Total FROM " + DBHandler.TABLE_ORDER + " WHERE Category = ?"
				+ "GROUP BY BookID ORDER BY total DESC LIMIT 1;";
		
		// Prepare statement and get query's result
		PreparedStatement stmt = conn.prepareStatement(query);
		stmt.setString(1, category);
		
		ResultSet result = stmt.executeQuery();
		
		String mostOrdered = "NONE";
		
		if(result.next()) {
			mostOrdered = result.getString("BookId");
		}
		
		return mostOrdered;
	}
	
	public static String getOrdersByUserId(Integer user_id) throws SQLException {
		Connection conn = getConnection();
		
		String query = "SELECT * FROM " + DBHandler.TABLE_ORDER + " WHERE UserId = ?"
				+ " ORDER BY OrderTime DESC;";
		
		
		// Prepare statement and get query's result
		PreparedStatement stmt = conn.prepareStatement(query);
		stmt.setInt(1, user_id);
		ResultSet result = stmt.executeQuery();
		
		try {
			return Convertor.convertResultSetToJSON(result).toString();
		}
		catch(Exception e) {
			System.out.println("MESSAGE: " + e.getMessage());
			System.out.println("STACK TRACE:");
			e.printStackTrace();
			
			return null;

		}
		
	}
	
	public static String getNewestOrderByUserId(Integer user_id) throws SQLException {
		Connection conn = getConnection();
		
		String query = "SELECT * FROM " + DBHandler.TABLE_ORDER + " WHERE UserId = ?"
				+ " ORDER BY OrderTime DESC LIMIT 1;";
		
		// Prepare statement and get query's result
		PreparedStatement stmt = conn.prepareStatement(query);
		stmt.setInt(1, user_id);
		ResultSet result = stmt.executeQuery();
		
		if(result.next()) {
			 return result.getString("OrderId");
		}
		
		return null;
	}
	
	public static String getReviewsByBookId(String book_id) throws SQLException {
		Connection conn = getConnection();
		
		String query = "SELECT * FROM " + DBHandler.TABLE_ORDER + " WHERE BookId = ? AND Comment IS NOT NULL ORDER BY OrderTime DESC";
		
		// Prepare statement and get query's result
		PreparedStatement stmt = conn.prepareStatement(query);
		stmt.setString(1, book_id);
		ResultSet result = stmt.executeQuery();
		
		try {
			return Convertor.convertResultSetToJSON(result).toString();
		}
		catch(Exception e) {
			System.out.println("MESSAGE: " + e.getMessage());
			System.out.println("STACK TRACE:");
			e.printStackTrace();
			
			return null;
		}
	}
	
	public static Integer getReviewsCountByBookId(String book_id) throws SQLException {
Connection conn = getConnection();
		
		String query = "SELECT COUNT(OrderId) as reviewCount FROM " + DBHandler.TABLE_ORDER + " WHERE BookId = ? AND Score IS NOT NULL";
		
		// Prepare statement and get query's result
		PreparedStatement stmt = conn.prepareStatement(query);
		stmt.setString(1, book_id);
		ResultSet result = stmt.executeQuery();
		
		if(result.next()) {
			 return result.getInt("reviewCount");
		}
		
		return null;
	}
	
	public static Float getAverageRatingByBookId(String book_id) throws SQLException {
		Connection conn = getConnection();
		
		String query = "SELECT AVG(Score) as AvgRating FROM " + DBHandler.TABLE_ORDER + " WHERE BookId = ? AND SCORE IS NOT NULL";
		
		// Prepare statement and get query's result
		PreparedStatement stmt = conn.prepareStatement(query);
		stmt.setString(1, book_id);
		ResultSet result = stmt.executeQuery();
		
		if(result.next()) {
			// round rating to 1 decimal place
			Double avgRating = Math.round(result.getFloat("AvgRating") * 10.0)/10.0;
			
			return avgRating.floatValue();
		}
		
		return null;
	}
	
	public static void insertOrder(String book_id, Integer user_id, String category, Integer amount) throws SQLException {
		Connection conn = getConnection();
		
		// get date & time
		java.util.Date now = new java.util.Date();
		java.text.SimpleDateFormat sdf = new java.text.SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
		String current_time = sdf.format(now);
		
		// SQL query
		String query = "INSERT INTO " + DBHandler.TABLE_ORDER + " (BookId, UserId, Category, Amount, OrderTime) VALUES (?, ?, ?, ?, ?)";
		
		// Prepare statement and get query's result
		PreparedStatement stmt = conn.prepareStatement(query);
		stmt.setString(1,book_id);
		stmt.setInt(2, user_id);
        stmt.setString(3,category);
        stmt.setInt(4, amount);
        stmt.setString(5, current_time);
        
        System.out.println(stmt.toString());
        
        stmt.executeUpdate();
        
        System.out.println("Insertion successful for BookId = " + book_id + ", UserId = " + user_id.toString() + ", Amount = " + amount.toString());
	}
	
	public static void updateOrderReview(Integer order_id, Integer score, String comment) throws SQLException {
		Connection conn = getConnection();
		
		// SQL Query
		String query = "UPDATE " + DBHandler.TABLE_ORDER + " SET Score = ? , Comment = ? WHERE OrderId = ?;";
		
		// Prepare statement and get query's result
		PreparedStatement stmt = conn.prepareStatement(query);
		stmt.setFloat(1, score);
		stmt.setString(2, comment);
        stmt.setInt(3, order_id);
        
        System.out.println(stmt.toString());
        
        stmt.executeUpdate();
	}
}
