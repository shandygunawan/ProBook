package api;

import java.util.ArrayList;
import org.json.JSONObject;
import com.google.gson.*; /* https://github.com/google/gson */

import model.Book;
import model.BookList;
import util.NetworkHandler;

public class GoogleBookAPI {
	private String API_KEY = "AIzaSyC2Lvja_w2JU_xjvpxbOruClrtx3Mj0Ggc";
	
	// Constructor
	public GoogleBookAPI() {}
	
	public static String getBooksByTitle(String title) {
		try {
			// Replace space to + for URL
			String url_title = title.replace(" ", "+");
			
			// add title to google's API URL link
			String url_full = "https://www.googleapis.com/books/v1/volumes?q=" + url_title;
		
			// get JSON list of books from HTTPURLConnection
			String str_booklist = NetworkHandler.httpConGet(url_full);
			
			// Convert string to java object class
			Gson gson = new GsonBuilder().setPrettyPrinting().create();
			ArrayList<Book> book_list = (gson.fromJson(str_booklist, BookList.class)).getBookList();

			/*
			System.out.println(str_booklist);
			System.out.println("");
			*/
			
			for (Book book : book_list) {
				book.getVolInfo().setPrice(100.0);
				book.getVolInfo().setQuantity(5);;
			}
			
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
			
			return str_bookDetails;
		}
		catch(Exception e) {
			System.out.println("MESSAGE: " + e.getMessage());
			System.out.println("STACK TRACE:");
			e.printStackTrace();
			
			return null;
		}
		
		
	}
	
}
