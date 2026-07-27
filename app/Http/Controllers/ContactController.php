<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $contacts = Contact::latest()->paginate(15);

    return view(
        'contacts.index',
        compact('contacts')
    );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:contacts'

        ]);


        Contact::create([

            'name'=>$request->name,

            'email'=>$request->email

        ]);


        return redirect('/contacts');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:contacts,email,' . $contact->id,
            'subscribed' => 'nullable|boolean',
        ]);

        $contact->update([
            'name' => $request->name,
            'email' => $request->email,
            'subscribed' => (bool) $request->input('subscribed', false),
        ]);

        return redirect()->route('contacts.index')
            ->with('success', 'Contact updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
         $contact->delete();

        return redirect('/contacts');
    }

    public function import()
{
    return view('contacts.import');
}

public function importStore(Request $request)
{

    $request->validate([
        'file' => 'required|file|mimes:csv,txt'
    ]);


    $file = fopen(
        $request->file('file')->getRealPath(),
        'r'
    );


    // Παράλειψη πρώτης γραμμής (headers)
    fgetcsv($file);


    while (($row = fgetcsv($file)) !== false) {


        $name = $row[0] ?? null;

        $email = $row[1] ?? null;


        if(!$email){
            continue;
        }


        Contact::firstOrCreate(

            [
                'email' => $email
            ],

            [
                'name' => $name,
                'subscribed' => true
            ]

        );

    }


    fclose($file);


    return redirect('/contacts')
        ->with('success','Contacts imported successfully');

}
}
