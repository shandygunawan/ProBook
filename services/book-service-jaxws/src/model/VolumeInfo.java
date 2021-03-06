package model;

import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;

public class VolumeInfo {
	
	@SerializedName("title")
	@Expose
	private String title;
	
	@SerializedName("authors")
	@Expose
	private String[] authors;
	
	@SerializedName("description")
	@Expose
	private String description;
	
	@SerializedName("imageLinks")
	@Expose
	private ImageLinks imageLinks;
	
	@SerializedName("categories")
	@Expose
	private String[] categories;
	
	@SerializedName("averageRating")
	@Expose
	private Float averageRating;
	
	@SerializedName("reviewCount")
	@Expose
	private Integer reviewCount;
	
	public String getTitle() {
		return title;
	}
	
	public String[] getAuthors() {
		return authors;
	}
	
	public String getDescription() {
		return description;
	}
	
	public String getImageLinks() {
		return imageLinks.getThumbnail();
	}
	
	public String[] getCategories() {
		return categories;
	}
	
	public Float getAverageRating() {
		return averageRating;
	}
	
	public void setAverageRating(Float rating) {
		averageRating = rating;
	}
	
	public Integer getReviewCount() {
		return reviewCount;
	}
	
	public void setReviewCount(Integer count) {
		reviewCount = count;
	}
}
