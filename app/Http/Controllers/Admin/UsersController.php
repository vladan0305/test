<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersController extends Controller
{

    public function __construct() {
        $this->middleware('auth')->except(['login', 'register']);
        $this->middleware('isadmin')->only(['index', 'create', 'store', 'changestatus', 'delete']);
        $this->middleware('guest')->only(['login', 'register']);
    }

    /**
     * Returns a table with all active users
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        $users = User::notdeleted()->get();

        return view('admin.users.index', compact('users'));
    }

    public function login(){

        if(request()->isMethod('post')){
            // validacija forme
            request()->validate([
                'email' => 'required|string|email',
                'password' => 'required'
            ]);
            // proba logovanja
            if(Auth::attempt([
                'email' => request('email'),
                'password' => request('password'),
                'active' => 1,
                'deleted' => 0
            ])){
                // TRUE - redirect na welcome ili tamo gde je hteo da ode ranije
                return redirect()->intended( route('users.welcome') );
            }else{
                // FALSE - redirect back sa greskom da je los email ili lozinka
                return redirect( route('users.login') )
                    ->withErrors(['email' => trans('auth.failed')])
                    ->withInput(['email' => request('email')]);
            }
        }
        return view('admin.users.login');
    }

    public function welcome(){

        return view('admin.users.welcome');
    }

    /**
     * Returns view form for creating a new user.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){

        return view('admin.users.create');
    }

    /**
     * Saves user to database
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(){
        //validacija
        $data = request()->validate([
            'firstName' => 'required|string|min:3|max:191',
            'lastName' => 'required|string|min:5|max:191',
            'email' => 'required|string|email|unique:users|max:191',
            'password' => 'required|string|min:5|max:191|confirmed',
            'role' => 'required|string|in:administrator,staff',
            'phone' => 'required|string|min:5|max:191'
        ]);

        // dopuna $data
        $data['active'] = 1;
        $data['password'] = Hash::make($data['password']);

        User::create($data);


        session()->flash('message-type', 'success');
        session()->flash('message-text', 'Successfully created user!!!');

        return redirect()->route('users.index');
    }

    /**
     * Returns view for user update
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user){
        $this->chechPrivilegies($user);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * First checks if user has privileges to change user data and then
     * saves changest to database.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(User $user){
        $this->chechPrivilegies($user);

        //validacija
        request()->validate([
            'firstName' => 'required|string|min:3|max:191',
            'lastName' => 'required|string|min:3|max:191',
            'role' => 'required|string|in:administrator,staff',
            'phone' => 'required|string|min:5|max:191'
        ]);

        $user->firstName = request()->firstName;
        $user->lastName = request()->lastName;
        $user->phone = request()->phone;

        if(auth()->user()->role == User::ADMINISTRATOR){
            $user->role = request()->role;
        }

        $user->save();

        if(auth()->user()->role == User::ADMINISTRATOR){
            return redirect()->route('users.index');
        } else {
            return redirect()->route('users.welcome');
        }
    }

    /**
     * Changes user status in users table.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changestatus(User $user){
        if($user->active == 1){
            $user->active = 0;
        } else {
            $user->active = 1;
        }

        $user->save();

        session()->flash('message-type', 'success');
        session()->flash('message-text', 'Successfully changed status for user ' . $user->firstName . '!!!');

        return redirect()->route('users.index');

    }

    /**
     * Checking if user has privileges to change password and then validates and
     *change password.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function changepassword(User $user){
        $this->chechPrivilegies($user);

        if(request()->isMethod('post')){
            // only on form submit
            request()->validate([
                'password' => 'required|string|min:5|max:191|confirmed'
            ]);

            $user->password = Hash::make(request('password'));

            $user->save();

            session()->flash('message-type', 'success');
            session()->flash('message-text', 'Successfully changed password!!!');


            if(auth()->user()->role == User::ADMINISTRATOR){
                return redirect()->route('users.index');
            } else {
                return back();
            }

        }

        return view('admin.users.changepassword', compact('user'));
    }


    /**
     * Soft delete user
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(User $user){

        // hard delete
        //$user->delete();

        // soft delete
        $user->deleted = 1;
        $user->deleted_by = auth()->user()->id;
        $user->save();

        return redirect()->route('users.index');
    }

    /**
     * Logout and redirect to login page
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(){
        // uradi logout
        Auth::logout();

        // nakon toga uradi redirect tamo gde zeli vlasnik portala
        return redirect()->route('users.login')->withErrors(['message' => 'Thank you, come again!!!']);
    }

    /**
     * Function that check if user has privileges to perform certain action
     *
     * @param User $user
     */
    protected function chechPrivilegies(User $user){
        if(auth()->user()->role == User::STAFF  && auth()->id() != $user->id){
            abort(403, 'Unauthorized action.');
        }
    }

    public function register() {
        if(request()->isMethod('post')){
            // validacija forme
            $data = request()->validate([
                'firstName' => 'required|string|min:3|max:191',
                'lastName' => 'required|string|min:5|max:191',
                'email' => 'required|string|email|unique:users|max:191',
                'password' => 'required|string|min:5|max:191|confirmed',
                'phone' => 'required|string|min:5|max:191'
            ]);
            $data['password'] = Hash::make(request('password'));
            $data['role'] = "student";
            User::create($data);

            return redirect()->route('users.login');

        }
        return view('admin.users.register');
    }
}
