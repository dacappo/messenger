package com.example.databaseLocal;

public class Message {
	
	private String id;
	private String message;
	private String from;
	
	public Message()
	{
		
	}
	
	public Message(String id, String m, String f)
	{
		this.id = id;
		this.message = m;
		this.from = f;
	}

	public String getId() {
		return id;
	}

	public void setId(String id) {
		this.id = id;
	}

	public String getMessage() {
		return message;
	}

	public void setMessage(String message) {
		this.message = message;
	}

	public String getFrom() {
		return from;
	}

	public void setFrom(String from) {
		this.from = from;
	}
	
	

}
