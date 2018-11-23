package main;

import java.util.ArrayList;

import javax.xml.ws.Endpoint;

import api.GoogleBookAPI;
import model.Book;
import services.SearchImpl;

public class Main {
	
	public static void main(String[] args) {
		
		try {
			Endpoint.publish("http://localhost:5432/services/search", new SearchImpl());
		}
		
		catch(Exception e) {
			e.printStackTrace();
		}
		
		/*
		GoogleBookAPI api = new GoogleBookAPI();
		
		String list = api.getBooksByTitle("The Selfish Gene");
		
		System.out.println(list);
		*/
		
	}
}
