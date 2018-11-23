package util;

import java.io.BufferedReader; 
import java.io.InputStreamReader; 
import java.net.HttpURLConnection;
import java.net.URL;

public class NetworkHandler {
	public static String httpConGet(String url_string) throws Exception {
		
		URL url = new URL(url_string);
		HttpURLConnection httpcon = (HttpURLConnection) url.openConnection();
		
		// Set the request method and properties
		httpcon.setRequestMethod("GET");
		httpcon.setRequestProperty("accept", "application/json");
		
		if(httpcon.getResponseCode() != 200) {
			throw new RuntimeException("Error in HTTPURLConnection. Response code: " + httpcon.getResponseCode());
		}
		
		System.out.println("Response Code: " + httpcon.getResponseCode());
		System.out.println("Response Message: " + httpcon.getResponseMessage());
		
		BufferedReader reader = new BufferedReader(new InputStreamReader(httpcon.getInputStream()));
		
		String str_buffer = null;
		StringBuilder str_return = new StringBuilder();
		
		while ((str_buffer = reader.readLine()) != null) {
			str_return.append(str_buffer);
		}
		
		return str_return.toString();
	}
}
