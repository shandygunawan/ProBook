
package order;

import javax.xml.bind.JAXBElement;
import javax.xml.bind.annotation.XmlElementDecl;
import javax.xml.bind.annotation.XmlRegistry;
import javax.xml.namespace.QName;


/**
 * This object contains factory methods for each 
 * Java content interface and Java element interface 
 * generated in the order package. 
 * <p>An ObjectFactory allows you to programatically 
 * construct new instances of the Java representation 
 * for XML content. The Java representation of XML 
 * content can consist of schema derived interfaces 
 * and classes representing the binding of schema 
 * type definitions, element declarations and model 
 * groups.  Factory methods for each of these are 
 * provided in this class.
 * 
 */
@XmlRegistry
public class ObjectFactory {

    private final static QName _IOException_QNAME = new QName("http://order/", "IOException");
    private final static QName _OrderBook_QNAME = new QName("http://order/", "orderBook");
    private final static QName _OrderBookResponse_QNAME = new QName("http://order/", "orderBookResponse");

    /**
     * Create a new ObjectFactory that can be used to create new instances of schema derived classes for package: order
     * 
     */
    public ObjectFactory() {
    }

    /**
     * Create an instance of {@link IOException }
     * 
     */
    public IOException createIOException() {
        return new IOException();
    }

    /**
     * Create an instance of {@link OrderBook }
     * 
     */
    public OrderBook createOrderBook() {
        return new OrderBook();
    }

    /**
     * Create an instance of {@link OrderBookResponse }
     * 
     */
    public OrderBookResponse createOrderBookResponse() {
        return new OrderBookResponse();
    }

    /**
     * Create an instance of {@link JAXBElement }{@code <}{@link IOException }{@code >}}
     * 
     */
    @XmlElementDecl(namespace = "http://order/", name = "IOException")
    public JAXBElement<IOException> createIOException(IOException value) {
        return new JAXBElement<IOException>(_IOException_QNAME, IOException.class, null, value);
    }

    /**
     * Create an instance of {@link JAXBElement }{@code <}{@link OrderBook }{@code >}}
     * 
     */
    @XmlElementDecl(namespace = "http://order/", name = "orderBook")
    public JAXBElement<OrderBook> createOrderBook(OrderBook value) {
        return new JAXBElement<OrderBook>(_OrderBook_QNAME, OrderBook.class, null, value);
    }

    /**
     * Create an instance of {@link JAXBElement }{@code <}{@link OrderBookResponse }{@code >}}
     * 
     */
    @XmlElementDecl(namespace = "http://order/", name = "orderBookResponse")
    public JAXBElement<OrderBookResponse> createOrderBookResponse(OrderBookResponse value) {
        return new JAXBElement<OrderBookResponse>(_OrderBookResponse_QNAME, OrderBookResponse.class, null, value);
    }

}
