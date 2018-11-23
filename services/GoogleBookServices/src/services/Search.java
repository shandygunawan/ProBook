package services;

import javax.jws.WebMethod;
import javax.jws.WebParam;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;
import javax.jws.soap.SOAPBinding.Style;
import javax.xml.bind.annotation.XmlElement;

@WebService
@SOAPBinding(style = Style.RPC)
public interface Search {
	@WebMethod
	public String searchBooks(@WebParam(name = "title") @XmlElement(required = true) String title);
	
	@WebMethod
	public String getBookDetails(@WebParam(name="id") @XmlElement(required = true) String id);
}
