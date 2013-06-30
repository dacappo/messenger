package com.example.whatsec;

import java.util.List;

import javax.swing.text.html.HTML;

import com.example.databaseLocal.Message;


import android.content.Context;
import android.text.Html;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

public class MessageListItem  extends ArrayAdapter<Message>
{
	Context context;
	int resource;
	List<Message> list;
	String name;
	
	public MessageListItem(Context context, int resource, List<Message> objects, String name) 
	{
			super(context, resource, objects);
			this.context = context;
			this.resource = resource;
			list = objects;
			this.name = name;
	}
	
	public View getView(int position, View convertView, ViewGroup parent)
	{
		View view = convertView;
		
		if(view == null)
		 {
			 LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			 view = inflater.inflate(resource, null);
		 }
		
		 Message item = list.get(position);
		 String text = item.getMessage();
		
		 if(item != null)
		 {
			 if(item.getId().equals(item.getFrom()))
			 {	
				 TextView me = (TextView) view.findViewById(R.id.textView2);
				 String me_string = "<b>Me: </b>";
				 String text_view = me_string + text;
				 me.setText(Html.fromHtml(text_view));
				 me.setGravity(Gravity.LEFT);
			 }
			 else
			 {
				 TextView oponnent = (TextView) view.findViewById(R.id.textView3);
				 String me_string = "<b>"+ " " + name  +"</b><br>";
				 String text_view = me_string + text  ;
				 oponnent.setText(Html.fromHtml(text_view));
				 oponnent.setGravity(Gravity.RIGHT);
			 }
			
			 
			 
		 }
		 
		 return view;

		
	}

}
