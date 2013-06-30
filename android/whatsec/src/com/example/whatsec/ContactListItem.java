package com.example.whatsec;

import java.util.List;

import com.example.databaseLocal.Contact;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;


public class ContactListItem extends ArrayAdapter<Contact>
{
	Context context;
	int layoutResId;
	List<Contact> data;
	int index;
	int i = 0;
	
	
	public ContactListItem(Context context, int layoutResourceId, List<Contact> data, int newContacts)
	{
		super(context, layoutResourceId, data);
		this.context = context;
		this.layoutResId = layoutResourceId;
		this.data = data;
		this.index = newContacts;
	}
	
	 public View getView(int position, View convertView, ViewGroup parent) 
	 {
		 View view = convertView;
		 if(view == null)
		 {
			 LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			 view = inflater.inflate(layoutResId, null);
		 }
		 
		 Contact item = data.get(position);
		 if(item != null)
		 {
				 TextView itemView1 = (TextView) view.findViewById(R.id.list_view_item1);
				 itemView1.setText(item.getName());
				 
				 TextView itemView2 = (TextView) view.findViewById(R.id.list_view_item2);
				 itemView2.setText(item.get_unhashed_number());
			
		 }
		
		 return view;
		 
	 }
	       
	
}
