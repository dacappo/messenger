package com.example.databaseLocal;

public class Contact {
    
    //private variables
    
    String _name;
    String _phone_number;
    private String _unhashed_number;
    private int _id;
    
     
    // Empty constructor
    public Contact()
    {
    }
    
    // constructor
    public Contact(String name, String _phone_number, String uhn, int id)
    {
        this._name = name;
        this._phone_number = _phone_number;
        this._unhashed_number = uhn;
        this._id = id;
    }
     
    // getting name
    public String getName(){
        return this._name;
    }
     
    // setting name
    public void setName(String name){
        this._name = name;
    }
    
    // getting phone number
    public String getPhoneNumber(){
        return this._phone_number;
    }
     
    // setting phone number
    public void setPhoneNumber(String phone_number){
        this._phone_number = phone_number;
    }
	public int get_id() {
		return _id;
	}
	public void set_id(int _id) {
		this._id = _id;
	}
	public String get_unhashed_number() {
		return _unhashed_number;
	}
	public void set_unhashed_number(String _unhashed_number) {
		this._unhashed_number = _unhashed_number;
	}
}
