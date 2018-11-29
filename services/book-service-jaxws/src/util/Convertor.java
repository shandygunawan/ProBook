package util;

import java.sql.ResultSet;

import org.json.JSONArray;
import org.json.JSONObject;

public class Convertor {
	
	public static JSONArray	convertResultSetToJSON(ResultSet resultSet) throws Exception {
		JSONArray jsonArray = new JSONArray();
        while (resultSet.next()) {
            JSONObject obj = new JSONObject();
            obj.put("OrderId", resultSet.getInt("OrderId"));
            obj.put("BookId", resultSet.getString("BookId"));
            obj.put("UserId", resultSet.getInt("UserId"));
            obj.put("Category", resultSet.getString("Category"));
            obj.put("Amount", resultSet.getInt("Amount"));
            obj.put("OrderTime", resultSet.getString("OrderTime"));
            obj.put("Score", resultSet.getFloat("Score"));
            obj.put("Comment", resultSet.getString("Comment"));
            
            jsonArray.put(obj);
        }
        return jsonArray;
	}
}
