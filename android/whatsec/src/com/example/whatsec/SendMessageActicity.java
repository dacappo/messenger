package com.example.whatsec;

import java.util.ArrayList;



import android.os.Bundle;
import android.app.Activity;
import android.app.ListActivity;
import android.view.Menu;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.ListAdapter;
import android.widget.ListView;

public class SendMessageActicity extends Activity {
	
	private ArrayList<String> eintraege = new ArrayList<String>();
	private EditText text;
	private ListView mainList;
	private ArrayAdapter<String> adapter;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_send_message_acticity);
		
		
		text = (EditText) findViewById(R.id.messageText);
		mainList = (ListView) findViewById(R.id.listViewMessages);
		adapter = new ArrayAdapter<String>(this,R.layout.item_row ,eintraege);
		mainList.setAdapter(adapter);
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.send_message_acticity, menu);
		return true;
	}
	
	
	
}
