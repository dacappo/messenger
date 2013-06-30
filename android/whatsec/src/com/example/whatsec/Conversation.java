package com.example.whatsec;

import java.util.ArrayList;
import java.util.List;
import java.util.concurrent.ExecutionException;

import org.json.simple.JSONArray;
import org.json.simple.JSONObject;
import org.json.simple.parser.JSONParser;
import org.json.simple.parser.ParseException;

import com.example.databaseLocal.Message;
import com.example.databaseLocal.MessageDatabase;

import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Bundle;
import android.os.Handler;
import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.Intent;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.ListView;

public class Conversation extends Activity {

	private EditText text;
	private ListView mainList;
	private ArrayAdapter<Message> adapter;
	String contactID;
	String name;
	String contactIdent = "contact_id";
	private String url = "http://paxalu-messenger.herokuapp.com/send_message.php";
	private String url_receive = "http://paxalu-messenger.herokuapp.com/receive_messages.php";
//	private MessageDatabase md = new MessageDatabase(this);
	private List<Message> messages = new ArrayList<Message>();
	String oldMessages = "";
	private boolean open = true;
	private Thread myThread;
	
	private Handler handler;
	
	final Context context= this;
	
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_send_message_acticity);
		
		Intent intent = getIntent();
		contactID = intent.getStringExtra("contactID");
		name = intent.getStringExtra("name");
		setTitle(name);
		
		try {
			oldMessages = new HTTPPost().execute(url_receive, contactIdent,
					contactID, "all", "1").get();
		} catch (Exception e) {
		}

		try {
			decodeJSON(oldMessages);
		} catch (ParseException e) {
			// TODO Auto-generated catch block
			System.out.println("ParserException  hier ist sie "
					+ e.getErrorType());
		}
		
		handler = new Handler();
		
		myThread = new Thread(new Runnable() {
			
			@Override
			public void run() {
				// TODO Auto-generated method stub
				
				while(open)
				{
					try {
						Thread.sleep(1000);
						try {
							oldMessages = new HTTPPost().execute(url_receive, contactIdent,
									contactID).get();
						} catch (Exception e) {
						}

						try {
							decodeJSON(oldMessages);
						} catch (ParseException e) {
							// TODO Auto-generated catch block
							System.out.println("ParserException  hier ist sie "
									+ e.getErrorType());
						}
						
						handler.post(new Runnable() {
							
							@Override
							public void run() {
								// TODO Auto-generated method stub
							
								mainList.setAdapter(adapter);
								System.out.println("Adapter Count: " + adapter.getCount());
								mainList.setSelection(adapter.getCount() - 1);
								
							}
						});
					} catch (Exception e) {
						// TODO: handle exception
					}
					
				}
				
			}
		});
		myThread.start();
		
		text = (EditText) findViewById(R.id.messageText);
		mainList = (ListView) findViewById(R.id.listViewMessages);
		
		adapter = new MessageListItem(this,R.layout.item_row , messages, name);
		mainList.setAdapter(adapter);
		
		
	}
	
	public void decodeJSON(String json) throws ParseException
	{
		System.out.println("JSON Message: " + json);
		JSONParser parser = new JSONParser();
		JSONArray array;
		Object obj = parser.parse(json);
		JSONObject obj_json = (JSONObject) obj;
		array = (JSONArray) obj_json.get("messages");
		
		for (int i = 0; i < array.size(); i++) 
		{
			JSONObject simpleObject = (JSONObject) array.get(i);
			String id = (String) simpleObject.get("id");
			String message = (String) simpleObject.get("content");
			messages.add(new Message(id, message, contactID));
			System.out.println(id + "   " +  message + "   "  + contactID);
		}
		
		System.out.println("Message Size:" + messages.size());
		
	}
	
	public void send(View view)
	{
		String neuerText = text.getText().toString();
		messages.add(new Message(contactID, neuerText, contactID));
		adapter.notifyDataSetChanged();
		text.setText("");
		
		String content = "body";
		String rückgabewert = "";
		
		if(isOnline())
		{
			//HTTPost
			try {
				rückgabewert = new HTTPPost().execute(url, contactIdent, contactID, content, neuerText).get();
				System.out.println(rückgabewert);
			} catch (Exception e) {
				System.out.println("Fehler beim Senden der Nachricht");
			}
			
			
		}
		else
		{
			AlertDialog.Builder builder = new AlertDialog.Builder(context);
			builder.setTitle("Internetverbindung");
			builder.setMessage("Es besteht keine Internetverbindung, bitte versuchen Sie es erneut");
			builder.setPositiveButton("OK", null);
			AlertDialog dialog = builder.create();
			dialog.show();
		}
				
	}
	
	public void writeMessageToDatabase(String message)
	{
//		md.addMessage(new Message(contactID, message, "1"));
	}
	
	

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.start_conversation, menu);
		return true;
	}
	
	public boolean isOnline()
	{
		 ConnectivityManager cm = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
	
		 NetworkInfo netInfo = cm.getActiveNetworkInfo();
		 
		 if (netInfo != null && netInfo.isConnectedOrConnecting())
		 {
			 return true;
		 }
		 else
		 {
			 return false;
		 }
		 
	}
	
	@Override
	public boolean onKeyDown(int keyCode, KeyEvent event)
	{
		if(keyCode == KeyEvent.KEYCODE_BACK)
		{
			open = false;
			
			
		}
		
		return super.onKeyDown(keyCode, event);
	}

}
