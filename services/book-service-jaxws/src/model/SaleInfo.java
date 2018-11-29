package model;

import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;

public class SaleInfo {
	
	@SerializedName("country")
	@Expose
	private String country;
	
	@SerializedName("saleability")
	@Expose
	private String saleability;
	
	@SerializedName("retailPrice")
	@Expose
	private RetailPrice retailPrice;
	
	public String getCountry() {
		return country;
	}
	
	public String getSaleability() {
		return saleability;
	}
	
	public RetailPrice getRetailPrice() {
		return retailPrice;
	}
	
}
