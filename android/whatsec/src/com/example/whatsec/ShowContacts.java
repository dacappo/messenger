package com.example.whatsec;

import java.io.FileNotFoundException;
import java.io.IOException;
import java.math.BigInteger;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.ArrayList;
import java.util.List;
import java.util.concurrent.ExecutionException;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import org.json.simple.parser.JSONParser;
import org.json.simple.parser.ParseException;

import com.example.databaseLocal.Contact;
import com.example.databaseLocal.ContactDatabase;

import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Bundle;
import android.provider.ContactsContract;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.database.Cursor;
import android.util.Log;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.ViewFlipper;

public class ShowContacts extends Activity {

	private ListView contactList;
	private ArrayAdapter<Contact> adapter;
	private List<Contact> contactsAll;
	private ShowContacts contacts = this;
	private List<Contact> contactsFinal = new ArrayList<Contact>();
	private List<Contact> contactsFinalMessages = new ArrayList<Contact>();
	private List<Contact> numbersBack = new ArrayList<Contact>();
	private List<String> newMessagesIndex = new ArrayList<String>();
	private String id;
	private String url = "http://paxalu-messenger.herokuapp.com/compare_contacts.php";
	private String url_new = "http://paxalu-messenger.herokuapp.com/cjlheck_new_messages.php";
	private JSONArray obj = new JSONArray();
	final ContactDatabase db = new ContactDatabase(this);
	private String number = "";
	private boolean changedOrder = false;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_show_contacts);
		
		Intent intent = getIntent();
		
		number = intent.getStringExtra("number");
		
		SharedPreferences settings = this.getSharedPreferences("Whatsec", MODE_PRIVATE);
		
		if(settings.getString("number", null) != null)
		{
				id = settings.getString("id", null);	
		}
		else
		{
				readContacts();	
				
				id = intent.getStringExtra("id");
				SharedPreferences.Editor editor = settings.edit();
				editor.putString("id", id);
				editor.putString("number", number);
				editor.commit();
		}
			
		
			contactsAll = db.getAllContacts();

			try {
				createJSON();
			} catch (JSONException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} catch (NoSuchAlgorithmException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			
			try {
				sendContacts();
			} catch (InterruptedException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} catch (ExecutionException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} catch (FileNotFoundException e) {
				// TODO Auto-generated catch block
				System.out.println("File not found");
			} catch (ParseException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			
			
		}

	
	public String joinNumber(String inputNumber)
	{
			String [] number_array = inputNumber.split(" ");
			String nummerZusam = "";
			
			for (int x = 0; x < number_array.length; x++) {
				nummerZusam = nummerZusam + number_array[x];
			}
			
			return nummerZusam;
	}
	
	public void readContacts()
	{
		String contactID;
		try {
			Cursor c = getContentResolver().query(
					ContactsContract.Contacts.CONTENT_URI, null, null, null,
					null);

			if (c.getCount() > 0) {
				while (c.moveToNext()) {
					List<Contact> contacts = db.getAllContacts();

					String name = c.getString(c.getColumnIndex(ContactsContract.Contacts.DISPLAY_NAME));
					contactID = c.getString(c.getColumnIndex(ContactsContract.Contacts._ID));

					boolean contains = false;

					for (int j = 0; j < contacts.size(); j++) {
						if (contacts.get(j).getName().equals(name)) {
							contains = true;
						}
					}

					if (!contains) {
						if (c.getColumnIndex(ContactsContract.Contacts.HAS_PHONE_NUMBER) > 0) {
							Cursor cp = getContentResolver().query(ContactsContract.CommonDataKinds.Phone.CONTENT_URI,null,
											ContactsContract.CommonDataKinds.Phone.CONTACT_ID + " = ?", new String[] { contactID }, null);
							while (cp.moveToNext()) 
							{
								if (cp.getString(cp.getColumnIndex(ContactsContract.CommonDataKinds.Phone.NUMBER)).contains("+49")
										|| cp.getString(cp.getColumnIndex(ContactsContract.CommonDataKinds.Phone.NUMBER)).contains("01")) 
								{
									String number = cp.getString(cp.getColumnIndex(ContactsContract.CommonDataKinds.Phone.NUMBER));
									number = joinNumber(number);
									String number_hash = hashing(number);
									db.addContact(new Contact(name, number_hash, number, 0));
								}
							}
							cp.close();
						}
					}

				}
				c.close();
			}
		} 
		catch (Exception e) 
		{
			// TODO: handle exception
		}
	}		
	

	
	public void createJSON() throws JSONException, NoSuchAlgorithmException, IOException
	{		
				renameNames();

				JSONObject obj2 = null;
				
				for (int i = 0; i < contactsAll.size(); i++) 
				{
					obj2 = new JSONObject();
					try {
						obj2.put("name", contactsAll.get(i).getName());
						obj2.put("number", contactsAll.get(i).getPhoneNumber());
					} catch (JSONException e) {
						// TODO Auto-generated catch block
						e.printStackTrace();
					}
					obj.put(obj2);
				}		
				
			}
			
	
	public void sendContacts() throws InterruptedException, ExecutionException, FileNotFoundException, ParseException
	{
				String contacts = null;
				
				if(isOnline())
				{
					String json = "contacts";
					String id_name = "id";
					String speicher = obj.toString();
					try {
						contacts = new HTTPPost().execute(url, json, speicher, id_name, id).get();
					} catch (InterruptedException e) {
						// TODO Auto-generated catch block
						System.out.println("Interrupt Exception");
					} catch (ExecutionException e) {
						// TODO Auto-generated catch block
						System.out.println("Execution");
					}
				}
				
				createViewWithContacts(contacts);
				
			}
		
	public void createViewWithContacts(String übergabe) throws ParseException
	{
			SharedPreferences settings = this.getSharedPreferences("Whatsec", MODE_PRIVATE);
		
			JSONParser parser = new JSONParser();
			org.json.simple.JSONArray array;
			Object obj  =  parser.parse(übergabe);
			array = (org.json.simple.JSONArray) obj;
			
			for (int i = 0; i < array.size(); i++) 
			{
				org.json.simple.JSONObject simpleObject = (org.json.simple.JSONObject) array.get(i);
				String number_rück = (String) simpleObject.get("number");
				String id_rück = (String) simpleObject.get("id");
				int contactID = Integer.parseInt(id_rück);
				numbersBack.add(new Contact("", number_rück, "" ,contactID));
			}
			
			compareLists();
			
			try {
				lookNewMessages();
			} catch (ParseException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			
			contactList = (ListView) findViewById(R.id.contactList);
			
			if(changedOrder)
			{
				for (int i = 0; i < contactsFinal.size(); i++) 
				{
					contactsFinalMessages.add(contactsFinal.get(i));
				}
				 adapter = new ContactListItem(this, R.layout.list_view_layout,
							contactsFinalMessages, contactsFinalMessages.size());
				 contactList.setAdapter(adapter);
				 
				
			}
			else
			{
				 adapter = new ContactListItem(this, R.layout.list_view_layout,
							contactsFinal, 0);
					contactList.setAdapter(adapter);
			}
	       
			
			contactList.setOnItemClickListener(new OnItemClickListener() {

				@Override
				public void onItemClick(AdapterView<?> arg0, View view,
						int position, long id) {
					// TODO Auto-generated method stub
					Intent next = new Intent(contacts, Conversation.class);
					Contact con = (Contact) contactList.getItemAtPosition(position);
					String übergabe = String.valueOf(con.get_id());
					next.putExtra("contactID", übergabe);
					next.putExtra("name", con.getName());
					contacts.startActivity(next);
				}
			});
	}
	
	private void lookNewMessages() throws ParseException
	{
		String back = "";
		String conID = "user_id";
		
		try {
			back = new HTTPPost().execute(url_new, conID, id).get();
		} catch (InterruptedException e) {
			// TODO Auto-generated catch block
			System.out.println("HTTPException");
		} catch (ExecutionException e) {
			System.out.println("HTTPException");
		}		
		
		System.out.println(back);
		
		JSONParser parser = new JSONParser();
		org.json.simple.JSONArray array;
		Object obj = parser.parse(back);
		org.json.simple.JSONObject obj_json = (org.json.simple.JSONObject) obj;
		array = (org.json.simple.JSONArray) obj_json.get("contact_IDs");
		
		
		for (int i = 0; i < array.size(); i++) 
		{
			String contact_id_back = array.get(i).toString();
			newMessagesIndex.add(contact_id_back);
			System.out.println(contact_id_back);
		}
		
		for (int i = 0; i < newMessagesIndex.size(); i++) 
		{
			String id = newMessagesIndex.get(i);
			
			for (int j = 0; j < contactsFinal.size(); j++) 
			{
				String id_op = String.valueOf(contactsFinal.get(j).get_id());
				if(id.equals(id_op))
				{
					
					contactsFinalMessages.add(new Contact(contactsFinal.get(j).getName(), contactsFinal.get(j).getPhoneNumber(), contactsFinal.get(j).get_unhashed_number(), 
							contactsFinal.get(j).get_id()));
					changedOrder = true;
					contactsFinal.remove(j);
				}
				
			}
		}
		
		for (int i = 0; i < contactsFinal.size(); i++) 
		{
			System.out.println(contactsFinal.get(i).getName());
		}
		
	}
	
	public void compareLists()
	{
		for (int i = 0; i < contactsAll.size(); i++) 
		{
			for (int j = 0; j < numbersBack.size(); j++) 
			{
				if(contactsAll.get(i).getPhoneNumber().equals(numbersBack.get(j).getPhoneNumber()))
				{
					contactsFinal.add(new Contact(contactsAll.get(i).getName(), contactsAll.get(i).getPhoneNumber(), contactsAll.get(i).get_unhashed_number() , numbersBack.get(j).get_id()));
				}
			}
			
		}
	}
	
	public void renameNames()
	{
		for (int i = 0; i < contactsAll.size(); i++) 
		{
			String name = contactsAll.get(i).getName();
			name = name.replace("ä", "&auml");
			name = name.replace("ä", "&Auml");
			name = name.replace("ö", "&ouml");
			name = name.replace("ö", "&Ouml");
			name = name.replace("ü", "&uuml");
			name = name.replace("ü", "&Uuml");
			name = name.replace("ß", "&szlig");
			contactsAll.get(i).setName(name);
		}
	}
	
	public String hashing(String number)
	{
		String rückgabe = "";
		
				MessageDigest md = null;
				try {
					md = MessageDigest.getInstance("SHA-256");
				} catch (NoSuchAlgorithmException e) {
					// TODO Auto-generated catch block
					System.out.println("Hashing Exception");
				}
				md.update(number.getBytes());
				//Hash
				byte [] digest =  md.digest();
				BigInteger bigInt = new BigInteger(1, digest);
				String number_output = bigInt.toString(16);
				rückgabe = number_output;
				 
		
		
		return rückgabe;
		
	}
	
	
	@Override
	public boolean onKeyDown(int keyCode, KeyEvent event)
	{
		if(keyCode == KeyEvent.KEYCODE_BACK)
		{
			return true;
		}
		
		return super.onKeyDown(keyCode, event);
	}
	
	
	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.show_contacts, menu);
		return true;
	}
	
//	public boolean isRunning()
//	{
//		return running;
//	}
	
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

}
