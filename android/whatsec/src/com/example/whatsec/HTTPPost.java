package com.example.whatsec;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.List;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;

import android.content.Context;
import android.net.ConnectivityManager;
import android.os.AsyncTask;

public class HTTPPost extends AsyncTask<String, Void, String>
{

	@Override
	protected String doInBackground(String... params) {
		// TODO Auto-generated method stub
		String url = params[0];
		
		HttpClient client = new DefaultHttpClient();
		HttpPost post = new HttpPost(url);
		
		StringBuffer stringBuffer = null;
		
		List<NameValuePair> parameters = new ArrayList<NameValuePair>(params.length);
		
		for (int i = 1; i < params.length; i = i+2)
		{
			String paraName = params[i];
			String para = params[i+1];
			
			parameters.add(new BasicNameValuePair(paraName, para));
		}
		
		try {
			post.setEntity(new UrlEncodedFormEntity(parameters));
		
			
			HttpResponse response = null;
			response = client.execute(post);
		
			BufferedReader bufferedReader = null;
			bufferedReader = new BufferedReader(
			           new InputStreamReader(response.getEntity().getContent()));
		
			
			stringBuffer = new StringBuffer("");
			String line = "";
		  
			while ((line = bufferedReader.readLine()) != null) {
			    stringBuffer.append(line); 
			    
			    bufferedReader.close();
			}
		}
		 catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		return stringBuffer.toString();
	}

}
