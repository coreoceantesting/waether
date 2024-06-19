<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Admin\ContactRepository;
use Yajra\Datatables\Datatables;
use App\Mail\SendContactMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    protected $contactRepository;

    public function __construct(ContactRepository $contactRepository){
        parent::__construct();
        $this->contactRepository = $contactRepository;
    }

    public function list(Request $req){
        if($req->ajax())
        {
            $contacts = $this->contactRepository->getContactList($req->location);

            return DataTables::of($contacts)
                    ->addIndexColumn()
                    ->editColumn('date', function ($data) {
                        return date('d-m-Y', strtotime($data->created_at));
                    })
                    ->toJson();
        }

        return view('admin.contacts.list');
    }

    public function delete(Request $req){
        $contact = $this->contactRepository->delete($req->id);

        if($contact){
            return redirect('/admin/contact/list')->with(['status' => "Contact Details removed successfully"]);
        }
    }

    public function sendMessage(){
        return view('admin.contacts.send-message');
    }

    public function sendContactMessage(Request $req){
        $contacts = $this->contactRepository->getContactList()->get();

        $data = [
            'subject' => $req->subject,
            'message' => $req->message
        ];

        foreach($contacts as $contact)
        {
            Mail::to($contact->email)->send(new SendContactMail($data));

            return redirect('admin/contact/send-message')->with(['status' => 'Email Send Successfully']);
        }
    }
}
