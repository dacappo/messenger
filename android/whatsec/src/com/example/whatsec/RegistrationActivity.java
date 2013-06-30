package com.example.whatsec;


import java.util.concurrent.ExecutionException;

import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Bundle;
import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.view.Menu;
import android.view.View;
import android.widget.EditText;

public class RegistrationActivity extends Activity{

	private RegistrationActivity regi = this;
	private EditText inputNumber;
	String code;
	boolean noNumber = false;
	final Context context = this;
	
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		
		SharedPreferences settings = this.getSharedPreferences("Whatsec", MODE_PRIVATE);
		
		if(settings.getString("number", null) == null)
		{
			registration();
		}
		else
		{
			Intent main = new Intent(regi, ShowContacts.class);
			regi.startActivity(main);
		}
	}

	public void registration()
	{
		setContentView(R.layout.activity_registration);
		inputNumber = (EditText) findViewById(R.id.HNrEingabe);
	}
	
	public void weiter(View view)
	{
		//Nummer einlesen
		String number = inputNumber.getText().toString();
		
		try {
			long speicher = Long.parseLong(number);
		} catch (NumberFormatException e) {
			noNumber = true;
		}
		
		if(noNumber)
		{
			AlertDialog.Builder builder = new AlertDialog.Builder(context);
			builder.setTitle("Nummer");
			builder.setMessage("Bitte geben Sie eine gültige Handynummer ein");
			builder.setPositiveButton("Ja", null);
			AlertDialog dialog = builder.create();
			dialog.show();
			
			inputNumber.setText("");
			noNumber = false;
			return;
			
		}
			
		String url = "http://paxalu-messenger.herokuapp.com/register.php";
		String paraName = "mobileNumber";
		
		if(isOnline())
		{
			try {
				code = new HTTPPost().execute(url, paraName, number).get();
				System.out.println("rückgabe: " + code);
			} catch (InterruptedException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} catch (ExecutionException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
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
			return;
		}
		
		if(code.equalsIgnoreCase("OK"))
		{
			Intent next = new Intent(regi, RegistrationAuthActivity.class);
			next.putExtra("number", number);
			regi.startActivity(next);
		}
		else
		{
			AlertDialog.Builder builder = new AlertDialog.Builder(context);
			builder.setTitle("Fehler");
			builder.setMessage("Nummer existiert bereits oder Servererror");
			builder.setPositiveButton("Ja", null);
			AlertDialog dialog = builder.create();
			dialog.show();
		}
		
		
	}
	
	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.start, menu);
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

}
