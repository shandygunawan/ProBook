package services;

import javax.jws.WebService;
import api.GoogleBookAPI;

@WebService(endpointInterface = "services.Search")
public class SearchImpl implements Search {
	
	@Override
	public String searchBooks(String title) {
		return GoogleBookAPI.getBooksByTitle(title);
	}
	
	@Override
	public String getBookDetails(String id) {
		return GoogleBookAPI.getBookDetails(id);
	}
}
