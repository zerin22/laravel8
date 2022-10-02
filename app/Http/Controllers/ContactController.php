<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactForm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ContactController extends Controller
{

    public function AdminContact()
    {
        $contacts = Contact::all();
        return view('admin.contact.index', compact('contacts'));
    }

    public function AdminAddContact()
    {
        return view('admin.contact.create');
    }

    public function AdminStoreContact(Request $request)
    {
        Contact::insert([
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Contact Inserted Successfully',
            'alert-type' => 'success'
         );

        return Redirect()->route('admin.contact')->with($notification);
    }

    public function AdminEditContact(Request $request, $id)
    {
        $contacts = Contact::find($id);
        return view('admin.contact.edit',compact('contacts'));
    }

    public function AdminUpdateContact(Request $request, $id)
    {
        Contact::find($id)->update([
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Contact Updated Successfully',
            'alert-type' => 'success'
         );

        return Redirect()->route('admin.contact')->with($notification);
    }

    public function AdminDeleteContact($id)
    {
        Contact::find($id)->Delete();

        $notification = array(
            'message' => 'Contact Deleted Successfully',
            'alert-type' => 'warning'
         );

        return Redirect()->back()->with($notification);

    }

    public function Contact()
    {
        $contacts = DB::table('contacts')->get()->first();
        // $contacts = Contact::find(1);
        return view('pages.contact', compact('contacts'));
    }

    public function Contactform(Request $request)
    {
        ContactForm::insert([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Your Message Send Successfully',
            'alert-type' => 'success'
         );

        return Redirect()->route('contact')->with($notification);
    }

    public function AdminMessage()
    {
        $messages = ContactForm::all();
        return view('admin.contact.message',compact('messages'));
    }

    public function AdminMessageDelete($id)
    {
        ContactForm::find($id)->Delete();

        $notification = array(
            'message' => 'Contact Deleted Successfully',
            'alert-type' => 'warning'
         );

        return Redirect()->back()->with($notification);

    }

}
