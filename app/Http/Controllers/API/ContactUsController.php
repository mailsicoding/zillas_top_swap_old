<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Http\Requests\ContactUsRequest;
use App\Mail\ContactUsMail;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contact = ContactUs::all();
        return response()->json([
            'success' => true,
            'contact' => $contact
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactUsRequest $request)
    {
        $inputs = $request->validated();

        if ($inputs == true) {
            $contact = ContactUs::create($inputs);
            Mail::to($inputs['email'])->send(new ContactUsMail($inputs['message']));
            return response()->json([
                'success' => true,
                'contact' => $contact,
                'message' => 'contact has been sent via email'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => "there's an error in validation",
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContactUs  $contactUs
     * @return \Illuminate\Http\Response
     */
    public function show(ContactUs $contactUs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContactUs  $contactUs
     * @return \Illuminate\Http\Response
     */
    public function update(ContactUsRequest $request, ContactUs $contactUs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContactUs  $contactUs
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactUs $contactUs, $id)
    {
        $contact = ContactUs::find($id)->delete();
        if($contact == true){
            return response()->json([
                'success' => true,
                'message' => 'Mail has been deleted',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'error while deleting',
            ]);
        }
    }
}
