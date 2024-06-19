<?php

namespace App\Repository\Admin;

use App\Models\Contact;

class ContactRepository{
	public function getContactList(){
		return Contact::select('id', 'name', 'email', 'mobile', 'message', 'created_at');
	}

	public function delete($id){
		$contact = Contact::find($id);

		if($contact->delete()){
			return true;
		}
	}
}