package BookServices;

import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.xml.ws.Endpoint;
@WebService
public interface BookServices {

	@WebMethod
	String getTitle();

	@WebMethod
	String getAuthor();
}