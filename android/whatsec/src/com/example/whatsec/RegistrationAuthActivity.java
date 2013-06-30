package com.example.whatsec;

import java.util.TreeMap;
import java.util.concurrent.ExecutionException;

import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Bundle;
import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.Intent;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

public class RegistrationAuthActivity extends Activity {

	private Button next;
	private RegistrationAuthActivity auth = this;
	String status;
	String number;
	EditText authCode;
	String authentifikation;
	final Context context = this;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		
		setContentView(R.layout.activity_registration_auth);
		Intent intent = getIntent();
		
		authCode = (EditText) findViewById(R.id.auth_eingabe);
		
		status = intent.getStringExtra("status");	
		number = intent.getStringExtra("number");
	}

	public void weiter_password(View view) throws InterruptedException, ExecutionException
	{
		
		String code = authCode.getText().toString();
		String url = "http://paxalu-messenger.herokuapp.com/check_ver.php";
		String codeName = "verCode";
		String numberName = "mobileNumber";
		
		if(isOnline())
		{
			authentifikation = new HTTPPost().execute(url, numberName, number, codeName, code ).get();
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
			
		String check = authentifikation.substring(0,2);

		if(check.equalsIgnoreCase("OK"))
		{
			Intent next = new Intent(auth, PasswordActivity.class);
			next.putExtra("number", number);
			auth.startActivity(next);
		}
		else
		{
			AlertDialog.Builder builder = new AlertDialog.Builder(context);
			builder.setTitle("Authentifizierng");
			builder.setMessage("Ihr Authentifizierungscode war falsch");
			builder.setPositiveButton("Ok", null);
			AlertDialog dialog = builder.create();
			dialog.show();
		}
		
	}
	
	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.registration_auth, menu);
		return true;
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
