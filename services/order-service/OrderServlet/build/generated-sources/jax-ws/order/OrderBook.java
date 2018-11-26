
package order;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlType;


/**
 * <p>Java class for orderBook complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="orderBook"&gt;
 *   &lt;complexContent&gt;
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType"&gt;
 *       &lt;sequence&gt;
 *         &lt;element name="book" type="{http://www.w3.org/2001/XMLSchema}string" minOccurs="0"/&gt;
 *         &lt;element name="jumlah" type="{http://www.w3.org/2001/XMLSchema}int"/&gt;
 *         &lt;element name="rekening" type="{http://www.w3.org/2001/XMLSchema}string" minOccurs="0"/&gt;
 *         &lt;element name="category" type="{http://www.w3.org/2001/XMLSchema}string" minOccurs="0"/&gt;
 *         &lt;element name="harga" type="{http://www.w3.org/2001/XMLSchema}double"/&gt;
 *       &lt;/sequence&gt;
 *     &lt;/restriction&gt;
 *   &lt;/complexContent&gt;
 * &lt;/complexType&gt;
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "orderBook", propOrder = {
    "book",
    "jumlah",
    "rekening",
    "category",
    "harga"
})
public class OrderBook {

    protected String book;
    protected int jumlah;
    protected String rekening;
    protected String category;
    protected double harga;

    /**
     * Gets the value of the book property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getBook() {
        return book;
    }

    /**
     * Sets the value of the book property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setBook(String value) {
        this.book = value;
    }

    /**
     * Gets the value of the jumlah property.
     * 
     */
    public int getJumlah() {
        return jumlah;
    }

    /**
     * Sets the value of the jumlah property.
     * 
     */
    public void setJumlah(int value) {
        this.jumlah = value;
    }

    /**
     * Gets the value of the rekening property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getRekening() {
        return rekening;
    }

    /**
     * Sets the value of the rekening property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setRekening(String value) {
        this.rekening = value;
    }

    /**
     * Gets the value of the category property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getCategory() {
        return category;
    }

    /**
     * Sets the value of the category property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setCategory(String value) {
        this.category = value;
    }

    /**
     * Gets the value of the harga property.
     * 
     */
    public double getHarga() {
        return harga;
    }

    /**
     * Sets the value of the harga property.
     * 
     */
    public void setHarga(double value) {
        this.harga = value;
    }

}
