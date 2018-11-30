package model;

import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;

public class ImageLinks {
	@SerializedName("thumbnail")
	@Expose
	private String thumbnail;
	
	public String getThumbnail() {
		return thumbnail;
	}
}
