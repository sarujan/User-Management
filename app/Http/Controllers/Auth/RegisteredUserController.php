<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Validator;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'contact' => ['string'],
            'address' => ['string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function getAllUsers(Request $request)
    {
        $searchParam = $request->search;

        $user = null;
        if(empty($searchParam)){
            $user = DB::table('users')->paginate(5);
        }else{
            $user = User::where('email', 'like', '%' . $searchParam . '%')->paginate(5);
        }
        return $user;
    }

    public function createUser(Request $request)
    {
        $validator = Validator::make(
            array(
                'name' => $request->name,
                'email' => $request->email,
                'contact' => $request->contact,
                'address' => $request->address,
                'password' => $request->password
            ),
            array(
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
                'contact' => ['string'],
                'address' => ['string'],
                'password' => ['required',  Rules\Password::defaults()],
            )
        );

        if ($validator->fails())
        {
            $messages = $validator->messages();
            return response()->json([
                'status' => false,
                'messages'=>$messages
            ], 406); 
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);
        
        return response()->json(['status' => true], 201); 
    }
    
    public function updateUser(Request $request)
    {
        $id=$request->id;

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->contact = $request->contact;
        $user->save();
        
        return response()->json(['status' => true], 201); 
    }
    
    public function deleteUser(Request $request)
    {
        $id=$request->id;

        User::where('id', $id)->delete();

        return response()->json(['status' => true], 201); 
    }

    
}
