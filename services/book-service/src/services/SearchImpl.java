package services;

import javax.jws.WebService;

import api.GoogleBookAPI;
import db.DBHandler;

@WebService(endpointInterface = "services.Search")
public class SearchImpl implements Search {
	
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
}
