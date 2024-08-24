<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\Notification;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Login Page";
        $auth = Auth::user();

        return view("auth.login", compact("title", 'auth'));
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        } else {
            return back()->withErrors(['error' => 'Invalid credentials']);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Register Page";
        $auth = Auth::user();
        $registrationPrice = rand(100000, 125000);

        return view('auth.register', compact('title', 'auth', 'registrationPrice'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'unique:users'],
            'email' => ['required', 'unique:users'],
            'password' => ['required'],
            'gender' => ['required'],
            'phone' => ['required'],
            'linkedin_url' => ['required'],
            'profile_url' => ['required', 'file', 'max:2048'],
            'balance' => ['required'],
            'field_of_work' => ['required', 'array', 'min:3'],
        ]);

        if ($validator->fails()) {
            // Return with validation errors
            return redirect()->back()->withErrors($validator)->withInput();
        }


        // Store the uploaded file and get the path
        $path = Storage::putFile('profiles', $request->file('profile_url'));

        // Create the user
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'gender' => $request->gender,
            'phone' => $request->phone,
            'linkedin_url' => "https://www.linkedin.com/in/{$request->linkedin_url}",
            'profile_url' => $path,
            'coin_amount' => $request->balance,
        ]);

        foreach ($request->field_of_work as $work) {
            DB::table('users_works')->insert([
                'user_id' => $user->id,
                'work_id' => $work,
            ]);
        }

        // Log the user in
        Auth::login($user);

        // Regenerate the session to prevent session fixation attacks
        $request->session()->regenerate();

        // Redirect to the intended page
        return redirect()->intended('/');
    }
    /**
     * Display the specified resource.
     */
    public function show()
    {
        $title = "Profile Page";
        $auth = Auth::user();
        $friends = $auth->friends;

        $friendList = [];
        foreach ($friends as $friend) {
            $friendList[] = User::where('id', $friend->id)->first();
        }

        return view('profile.show', compact('title', 'auth', 'friendList'));
    }

    public function notifications()
    {
        $title = "Notifications Page";
        $auth = Auth::user();
        $notifications = Notification::where('user_id', $auth->id)->where('is_read', false)->get();

        return view('notifications.index', compact('title', 'auth', 'notifications'));
    }

    public function markAsRead(string $id)
    {
        Notification::where('id', $id)->update([
            'is_read' => true
        ]);

        return redirect()->intended('/notifications');
    }

    public function paymentForm()
    {
        $title = 'Payment Page';
        $auth = Auth::user();

        return view('payment.index', compact('title', 'auth'));
    }

    public function payment()
    {
        $authId = Auth::user()->id;

        $user = User::where('id', $authId)->first();

        User::where('id', $authId)->update([
            'coin_amount' => $user->coin_amount + 100
        ]);

        return redirect()->intended('/payment');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }

    public function language($locale)
    {
        if (!in_array($locale, ['en', 'id'])) {
            abort(400);
        }
        Session::put('locale', $locale);

        // Debugging: Check if the session is started and the locale is set
        if (Session::has('locale')) {
            $currentLocale = Session::get('locale');
            // dd('Session is started. Current locale: ' . $currentLocale);
        } else {
            // dd('Session is not started or locale is not set.');
        }

        return redirect()->intended('/');
    }
}
