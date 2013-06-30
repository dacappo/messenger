package com.example.databaseLocal;


import java.util.ArrayList;
import java.util.List;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteDatabase.CursorFactory;
import android.database.sqlite.SQLiteOpenHelper;

public class ContactDatabase extends SQLiteOpenHelper{

	 // All Static variables
    // Database Version
    private static final int DATABASE_VERSION = 1;
 
    // Database Name
    private static final String DATABASE_NAME = "contactsManager";
 
    // Contacts table name
    public static final String TABLE_CONTACTS = "contacts";
 
    // Contacts Table Columns names
    
    public static final String KEY_NAME = "Name";
    public static final String KEY_PH_NO = "phone_number";
    public static final String KEY_UNHASHED = "unhashed_Number";
    public static final String KEY_ID = "id";
	
	public ContactDatabase(Context context) {
		super(context, DATABASE_NAME, null, DATABASE_VERSION);
		// TODO Auto-generated constructor stub
	}

	@Override
	public void onCreate(SQLiteDatabase db) {
		// TODO Auto-generated method stub
		String CREATE_CONTACTS_TABLE = "CREATE TABLE " + TABLE_CONTACTS + "("
                 + KEY_NAME + " TEXT," + KEY_PH_NO + " TEXT PRIMARY KEY," + KEY_UNHASHED + " TEXT," + KEY_ID + " TEXT" + ")";
        db.execSQL(CREATE_CONTACTS_TABLE);
	}

	@Override
	public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
		// TODO Auto-generated method stub
		// Drop older table if existed
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_CONTACTS);
 
        // Create tables again
        onCreate(db);
	}

	// Adding new contact
	public void addContact(Contact contact) 
	{
		SQLiteDatabase db = this.getWritableDatabase();
		 
	    ContentValues values = new ContentValues();
	    values.put(KEY_NAME, contact.getName()); // Contact Name
	    values.put(KEY_PH_NO, contact.getPhoneNumber()); // Contact Phone Number
	    values.put(KEY_UNHASHED, contact.get_unhashed_number());
	    values.put(KEY_ID, contact.get_id());
	 
	    // Inserting Row
	    try {
	    	db.insertOrThrow(TABLE_CONTACTS, null, values);
		} catch (Exception e) {
			System.out.println(e.getMessage());
		}
	    
	    db.close(); // Closing database connection
	}
	 
	// Getting single contact
	public Contact getContact(String n)
	{
		SQLiteDatabase db = this.getWritableDatabase();
		 
		 Cursor cursor = db.query(TABLE_CONTACTS, new String[] { KEY_ID,
		            KEY_NAME, KEY_UNHASHED, KEY_PH_NO }, KEY_ID + "=?",
		            new String[] { String.valueOf(n) }, null, null, null, null);
		    if (cursor != null)
		        cursor.moveToFirst();
		 
		    Contact contact = new Contact(cursor.getString(0), cursor.getString(1), cursor.getString(1),  cursor.getInt(2));
		    // return contact
		    return contact;
	}
	 
	// Getting All Contacts
	public List<Contact> getAllContacts() 
	{
		 List<Contact> contactList = new ArrayList<Contact>();
		    // Select All Query
		    String selectQuery = "SELECT  * FROM " + TABLE_CONTACTS;
		 
		    SQLiteDatabase db = this.getWritableDatabase();
		    Cursor cursor = db.rawQuery(selectQuery, null);
		 
		    // looping through all rows and adding to list
		    if (cursor.moveToFirst()) {
		        do {
		            Contact contact = new Contact();
		            contact.setName(cursor.getString(0));
		            contact.setPhoneNumber(cursor.getString(1));
		            contact.set_unhashed_number(cursor.getString(2));
		            contact.set_id(cursor.getInt(0));
		            // Adding contact to list
		            contactList.add(contact);
		        } while (cursor.moveToNext());
		    }
		 
		    // return contact list
		    return contactList;
	}
	 
	// Getting contacts Count
	public int getContactsCount() 
	{
		 String countQuery = "SELECT  * FROM " + TABLE_CONTACTS;
	        SQLiteDatabase db = this.getReadableDatabase();
	        Cursor cursor = db.rawQuery(countQuery, null);
	        cursor.close();
	 
	        // return count
	        return cursor.getCount();
		
	}
	// Updating single contact
	public int updateContact(Contact contact)
	{
		 SQLiteDatabase db = this.getWritableDatabase();
		 
		    ContentValues values = new ContentValues();
		    values.put(KEY_NAME, contact.getName());
		    values.put(KEY_PH_NO, contact.getPhoneNumber());
		    values.put(KEY_UNHASHED, contact.get_unhashed_number());
		    values.put(KEY_ID, contact.get_id());
		 
		    // updating row
		    return db.update(TABLE_CONTACTS, values, KEY_PH_NO + " = ?",
		            new String[] { String.valueOf(contact.getPhoneNumber()) });
	}
	 
	// Deleting single contact
	public void deleteContact(Contact contact)
	{
		SQLiteDatabase db = this.getWritableDatabase();
	    db.delete(TABLE_CONTACTS, KEY_PH_NO + " = ?",
	            new String[] { String.valueOf(contact.getPhoneNumber()) });
	    db.close();
	}
	
	
	

	
}
