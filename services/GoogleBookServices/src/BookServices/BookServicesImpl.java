package BookServices;

import BookServices.BookServices;

import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.xml.ws.Endpoint;

@WebService
public class BookServicesImpl implements BookServices {
	private String title;
	private String author;

	public BookServicesImpl() {
		title = "Oregairu";
		author = "Wataru Watari";
	}

	@WebMethod
	public String getTitle(){
		return title;
	}

	@WebMethod
	public String getAuthor(){
		return author;
	}

	public static void main(String[] argv) {
		Object implementor = new BookServicesImpl();
		String address = "http://localhost/BookServices";
		Endpoint.publish(address, implementor);
	}
}