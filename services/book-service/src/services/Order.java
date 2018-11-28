package services;

import java.io.IOException;
import javax.jws.WebMethod;
import javax.jws.WebParam;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;
import javax.jws.soap.SOAPBinding.Style;


@WebService
@SOAPBinding(style = Style.RPC)
public interface Order {
	
	@WebMethod
	public String orderBook(@WebParam(name = "book_id") String book_id,  @WebParam(name="user_id") int user_id, @WebParam(name="jumlah")int jumlah, @WebParam(name="rekening") String rekening, @WebParam(name="category") String category, @WebParam(name="harga") double harga) throws IOException;
	
	@WebMethod
	public String getOrdersByUserId(@WebParam(name = "user_id") Integer user_id) throws Exception;
	
	@WebMethod
	public String getReviewsByBookId(@WebParam(name = "book_id") String book_id) throws Exception;
	
	@WebMethod
	public void updateOrderReview(@WebParam(name = "order_id") Integer order_id, @WebParam(name = "score") Integer score, @WebParam(name = "comment") String comment) throws Exception;
}
