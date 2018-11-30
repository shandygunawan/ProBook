package model;

import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;

public class RetailPrice {
	@SerializedName("amount")
	@Expose
	private Float amount;
	
	@SerializedName("currencyCode")
	@Expose
	private String currencyCode;
	
	public Float getAmount() {
		return amount;
	}
	
	public String getCurrencyCode() {
		return currencyCode;
	}
}
