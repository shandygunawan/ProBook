package model;

import java.util.ArrayList;
import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;

public class BookList {
	@SerializedName("items")
	@Expose
	private ArrayList<Book> bookList;
	
	public ArrayList<Book> getBookList() {
		return bookList;
	}
}
