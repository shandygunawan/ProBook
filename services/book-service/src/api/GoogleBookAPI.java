package api;

import java.util.ArrayList;
import com.google.gson.*; /* https://github.com/google/gson */

import db.DBHandler;
import model.Book;
import model.BookList;
import util.NetworkHandler;

public class GoogleBookAPI {
	private static String API_KEY = "AIzaSyC2Lvja_w2JU_xjvpxbOruClrtx3Mj0Ggc";
	
	// Constructor
	public GoogleBookAPI() {}
	
	public String getApiKey() {
		return API_KEY;
	}
	
	public void setApiKey(String key) {
		API_KEY = key;
	}
	
	public static String getBooksByTitle(String title) {
		try {
			// Replace space to + for URL
			String url_title = title.replace(" ", "+");
			
			// add title to google's API URL link
			String url_full = "https://www.googleapis.com/books/v1/volumes?q=" + url_title;
		
			// get JSON list of books from HTTPURLConnection
			String str_booklist = NetworkHandler.httpConGet(url_full);
			
			// Convert string to java object class + remove unnecessary components
			Gson gson = new GsonBuilder().setPrettyPrinting().create();
			ArrayList<Book> book_list = (gson.fromJson(str_booklist, BookList.class)).getBookList();
			
			// Fetch data to local DB
			DBHandler.fetchPricesFromGoogleApi(book_list);
			
			return (gson.toJson(book_list).toString());
			
		}
		catch(Exception e) {
			System.out.println("MESSAGE: " + e.getMessage());
			System.out.println("STACK TRACE:");
			e.printStackTrace();
			
			return null;
		}

	}
	
	public static String getBooksByCategory(String category) {
		try {
			
			// add category to google's API URL link
			String url_full = "https://www.googleapis.com/books/v1/volumes?q=subject:" + category;
		
			// get JSON list of books from HTTPURLConnection
			String str_booklist = NetworkHandler.httpConGet(url_full);
			
			// Convert string to java object class + remove unnecessary components
			Gson gson = new GsonBuilder().setPrettyPrinting().create();
			ArrayList<Book> book_list = (gson.fromJson(str_booklist, BookList.class)).getBookList();

			
			return (gson.toJson(book_list).toString());
			
		}
		catch(Exception e) {
			System.out.println("MESSAGE: " + e.getMessage());
			System.out.println("STACK TRACE:");
			e.printStackTrace();
			
			return null;
		}
	}
	
	
	public static String getBookDetails(String id) {
		try {
			String url_full = "https://www.googleapis.com/books/v1/volumes/" + id;
			
			String str_bookDetails = NetworkHandler.httpConGet(url_full);
			
			// Convert string to java object class + remove unnecessary components
			Gson gson = new GsonBuilder().setPrettyPrinting().create();
			Book book = gson.fromJson(str_bookDetails, Book.class);
			
			
			return (gson.toJson(book).toString());
		}
		catch(Exception e) {
			System.out.println("MESSAGE: " + e.getMessage());
			System.out.println("STACK TRACE:");
			e.printStackTrace();
			
			return null;
		}
		
		
	}
	
}
