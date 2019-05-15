<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admission;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdmissionsController extends Controller
{

    public function __construct() {
        $this->middleware('isadmin');
    }

    public function index(){
        $admissions = Admission::all();

        return view('admin.admissions.index', compact('admissions'));
    }

    public function create(){

        return view('admin.admissions.create');
    }

    public function store(){
        //validacija
        $data = request()->validate([
            'name' => 'required|string|min:3|max:191',
            'description' => 'required|string|min:5|max:65000',
            'status' => 'required|boolean'
        ]);

        Admission::create($data);


        session()->flash('message-type', 'success');
        session()->flash('message-text', 'Successfully created admission!!!');

        return redirect()->route('admissions.index');
    }

    public function changestatus(Admission $admission){
        if($admission->status == true){
            $admission->status = false;
        } else {
            $admission->status = true;
        }

        $admission->save();

        session()->flash('message-type', 'success');
        session()->flash('message-text', 'Successfully changed status for admission ' . $admission->name . '!!!');

        return redirect()->route('admissions.index');

    }

    public function delete(Admission $admission){

        // hard delete
        $admission->delete();

        return redirect()->route('admissions.index');
    }

    public function edit(Admission $admission){
        $this->chechPrivilegies(auth()->user());

        return view('admin.admissions.edit', compact('admission'));
    }

    public function update(Admission $admission){
        $this->chechPrivilegies(auth()->user());

        //validacija
        request()->validate([
            'name' => 'required|string|min:3|max:191',
            'description' => 'required|string|min:3|max:65000',
            'status' => 'required|boolean'
        ]);

        $admission->name = request()->name;
        $admission->description = request()->description;
        $admission->status = request()->status;

        $admission->save();

        return redirect()->route('admissions.index');

    }

    protected function chechPrivilegies(User $user){
        if(auth()->user()->role == User::STAFF  && auth()->id() != $user->id){
            abort(403, 'Unauthorized action.');
        }
    }
}
