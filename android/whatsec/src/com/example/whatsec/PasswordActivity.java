package com.example.whatsec;

import java.math.BigInteger;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.concurrent.ExecutionException;

import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Bundle;
import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

public class PasswordActivity extends Activity {

	private Button next;
	private PasswordActivity regi = this;
	private TextView text, text_repeat;
	private EditText pw1, pw2;
	
	final Context context = this;
	
	private String number;
	
	
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_password);
		
		Intent intent = getIntent();
		text = (TextView) findViewById(R.id.password_text);
		pw1 = (EditText) findViewById(R.id.password_eingabe);
		text_repeat = (TextView) findViewById(R.id.repeat_password_text);
		pw2 = (EditText) findViewById(R.id.repeat_password_eingabe);
		
		number = intent.getStringExtra("number");
		
	}

	public void weiter_password(View view) throws NoSuchAlgorithmException
	{
		String password = pw1.getText().toString();
		String password_check = pw2.getText().toString();
		
		if(password.equals(password_check))
		{
			String numberName = "mobileNumber";
			String passwordName = "password";
			String url = "http://paxalu-messenger.herokuapp.com/create_user.php";

			//Hashing
			MessageDigest md = MessageDigest.getInstance("SHA-256");
			md.update(password.getBytes());
			
			//Hash Passwort
			byte [] digest =  md.digest();
			BigInteger bigInt = new BigInteger(1, digest);
			String pw_output = bigInt.toString(16);
			
			//Hash Nummer
			md.update(number.getBytes());
			digest = md.digest();
			bigInt = new BigInteger(1, digest);
			String number_out = bigInt.toString(16);
			
			String request = "";
			
			
			
			if(isOnline())
			{
				try {
					request = new HTTPPost().execute(url, numberName, number_out, passwordName, pw_output).get();
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
			
			String check = request.substring(0,3);
			String id = request.substring(5);
			System.out.println(check.length());

			if(check.equalsIgnoreCase("OK "))
			{
				AlertDialog.Builder builder = new AlertDialog.Builder(context);
				builder.setTitle("User");
				builder.setMessage("User wurde in der Datenbank angelegt");
				builder.setPositiveButton("OK", null);
				AlertDialog dialog = builder.create();
				dialog.show();
				
				SharedPreferences settings = this.getSharedPreferences("Whatsec", MODE_PRIVATE);
				SharedPreferences.Editor editor = settings.edit();
//				editor.putString("Number", null);
				editor.commit();
				Intent next = new Intent(regi, ShowContacts.class);
				next.putExtra("id", id);
				next.putExtra("number", number);
				regi.startActivity(next);
			}
			else
			{
				System.out.println("Fehler");
			}
			
			
			
			
		}
		else
		{
			AlertDialog.Builder builder = new AlertDialog.Builder(context);
			builder.setTitle("Passwort");
			builder.setMessage("Passwörter stimmen nicht überein");
			builder.setPositiveButton("OK", null);
			AlertDialog dialog = builder.create();
			dialog.show();
			
			pw1.setText("");
			pw2.setText("");
		}
		
	}
	
	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.password, menu);
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
