package services;

import java.io.IOException;
import javax.jws.WebMethod;
import javax.jws.WebParam;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;
import javax.jws.soap.SOAPBinding.Style;
import javax.xml.bind.annotation.XmlElement;

@WebService
@SOAPBinding(style = Style.RPC)
public interface Order {
	
	@WebMethod
	public String getOrdersByUserId(@WebParam(name = "user_id") Integer user_id) throws Exception;
	
	@WebMethod
	public void updateOrderReview(@WebParam(name = "order_id") Integer order_id, @WebParam(name = "score") Integer score, @WebParam(name = "comment") String comment) throws Exception;
}
