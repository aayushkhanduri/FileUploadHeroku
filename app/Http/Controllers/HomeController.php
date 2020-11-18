<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /* public function index()
    {
        return view('home');
    } */
    public function uploadfile()
    {
        return view('uploadfile');
    }

    /** Example of File Upload */
    public function uploadFilePost(Request $request){
        $request->validate([
            'fileToUpload' => 'required|file|max:2048',
        ]);

        $fileName = "fileName".time().'.'.request()->fileToUpload->getClientOriginalExtension();

        $request->fileToUpload->store('files/'.$request->user()->id,'ftp');
        

        return back()
            ->with('success','You have successfully uploaded the file.');

    }


    public function index(Request $request) {
        $files = Storage::disk('ftp')->files('files/'.$request->user()->id,'ftp');
        return view('home', ['files'=> $files]);
        return $files;
    }

}
