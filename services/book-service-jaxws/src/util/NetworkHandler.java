package util;

import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.InputStreamReader; 
import java.net.HttpURLConnection;
import java.net.URL;

import org.json.JSONObject;

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
	
	public static String httpConPost(String url, String body) throws Exception {
		URL link = new URL(url);
        HttpURLConnection connection =  (HttpURLConnection) link.openConnection();
        connection.setRequestMethod("POST");
        connection.setDoOutput(true);
        DataOutputStream wr = new DataOutputStream(connection.getOutputStream());
        wr.writeBytes(body);
        wr.flush();
        wr.close();
        BufferedReader in = new BufferedReader(new InputStreamReader(connection.getInputStream()));
        String input;
        StringBuffer response = new StringBuffer();
        
        while ((input = in.readLine()) != null){
            response.append(input);
        }
        in.close();
        JSONObject data = new JSONObject(response.toString());
              
        return data.getString("response");
	}
}
