package com.example.databaseLocal;

import java.util.ArrayList;
import java.util.List;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

public class MessageDatabase  extends SQLiteOpenHelper
{
	 // All Static variables
    // Database Version
    private static final int DATABASE_VERSION = 1;
 
    // Database Name
    private static final String DATABASE_NAME = "messages";
 
    // Contacts table name
    public static final String TABLE_CONTACTS = "messages";
 
    // Contacts Table Columns names
    
    public static final String KEY_MESSAGE = "message";
    public static final String KEY_CONTACT_ID = "contactId";
    public static final String KEY_FROM = "von";
    
    public MessageDatabase(Context context) {
		super(context, DATABASE_NAME, null, DATABASE_VERSION);
	}

	@Override
	public void onCreate(SQLiteDatabase db) {
		String query = "CREATE TABLE " + TABLE_CONTACTS + "("
                + KEY_CONTACT_ID + " TEXT PRIMARY KEY," + KEY_MESSAGE + " TEXT,"  + KEY_FROM + "TEXT" + ")";
       db.execSQL(query);
		
	}

	@Override
	public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
	}
	
	public void addMessage(Message message) 
	{
		SQLiteDatabase db = this.getWritableDatabase();
		 
	    ContentValues values = new ContentValues();
	    values.put(KEY_CONTACT_ID, message.getId()); 
	    values.put(KEY_MESSAGE, message.getMessage()); 
	    values.put(KEY_FROM, message.getFrom());
	    System.out.println("Message angelegt");
	    // Inserting Row
	    try {
	    	db.insertOrThrow(TABLE_CONTACTS, null, values);
		} catch (Exception e) {
			System.out.println(e.getMessage());
		}
	    
	    db.close(); // Closing database connection
	}
	
	public List<Message> getAllMessages(String id) 
	{
		 List<Message> messageList = new ArrayList<Message>();
		    // Select All Query
		    String selectQuery = "SELECT  * FROM " + TABLE_CONTACTS;
		 
		    SQLiteDatabase db = this.getWritableDatabase();
		    
		    Cursor cursor = db.rawQuery(selectQuery, null);
		 
		    // looping through all rows and adding to list
		    if (cursor.moveToFirst()) {
		        do {
		            Message m = new Message();
		            m.setId(cursor.getString(0));
		            m.setMessage(cursor.getString(1));
		            System.out.println(m.getMessage() + " !!!!!!!");
		            m.setFrom(cursor.getString(2));
		            messageList.add(m);
		        } while (cursor.moveToNext());
		    }
		 
		    // return contact list
		    return messageList;
	}
}
