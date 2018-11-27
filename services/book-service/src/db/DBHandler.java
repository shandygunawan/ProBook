package db;

import java.sql.Connection;
import java.sql.Date;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;

import model.Book;
import model.SaleInfo;

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
		
		// Close statement and connection
		conn.close();
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
	
	public static Integer getAmountByBookId(String book_id) throws SQLException {
		Connection conn = getConnection();
		
		// SQL query
		String query = "SELECT price FROM " + DBHandler.TABLE_ORDER + " WHERE BookId = ?;";
		
		// Prepare statement and get query's result
		PreparedStatement stmt = conn.prepareStatement(query);
		stmt.setString(1, book_id);
		ResultSet result = stmt.executeQuery();
		
		Integer amount = result.next() ? result.getInt("Amount"):-1; 
		
		return amount;
	}
	
	public static String getMostOrderedBookIdByCategory(String category) throws SQLException {
		Connection conn = getConnection();
		
		// SQL query
		String query = "SELECT BookID, SUM(Amount) as Total FROM " + DBHandler.TABLE_ORDER + " WHERE Category = ?"
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
        stmt.executeUpdate();
        
        System.out.println("Insertion successful for BookId = " + book_id + ", UserId = " + user_id.toString() + ", Amount = " + amount.toString());
	}
}
