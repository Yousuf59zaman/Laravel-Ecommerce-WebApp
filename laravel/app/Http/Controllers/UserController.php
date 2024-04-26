<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserController extends Controller
{
    // Show the registration form
    public function showRegistrationForm()
    {
        return view('register');
    }

    //Handle Registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:1',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
 // Log in the newly registered user. 
 //This is needed because the `create` method only creates the user in the 
 //database, but does not log in the user. Calling `Auth::login($user)` 
 //logs in the user, and also sets the authenticated user in the session, 
 //so that Laravel can keep track of the currently authenticated user for 
 //the rest of the session. This is necessary to allow the user to access 
 //protected routes and perform actions that require authentication.
        Auth::login($user);
        return redirect()->route('login'); // Assume 'home' is the route name for your homepage
    }


    // Show the login form
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        /*
        If `Auth::attempt($credentials)` returns `true`, it means the
        provided credentials are correct, and the user is authenticated.

        `session()->regenerate()` is then called to regenerate the session
        ID, which helps prevent session fixation attacks. This is a common
        security measure to prevent users from hijacking sessions.

        `intended()` is a method provided by Laravel, which redirects the
        user to the intended destination, if it exists (otherwise, it
        redirects to the '/' which is home page route). The intended destination is
        stored in the session data, and it's used to help the user
        navigate back to the page they were trying to access before being
        redirected to the login page.

        It's important to regenerate the session ID and use `intended()`
        to prevent session fixation attacks and to provide a better user
        experience.
        */
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

              // Check if the authenticated user is an admin
        if (Auth::user()->is_admin == 1) {
            return redirect()->route('admin.dashboard'); // Redirect to the admin dashboard
        }

            return redirect()->intended('/'); // Redirects to the home page
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

     // Show user profile
     public function showProfile()
     {
        /*
        This line of code is returning a view named 'profile'.
        The view 'profile' is a blade template file located in resources/views.
        The template is given a variable named 'user' which contains the currently authenticated user.
        The `Auth::user()` method retrieves the currently authenticated user from the session.
        */
     // explanation: 
        // Return a view named 'profile'
        // The first argument is the name of the blade template file to render.
        // The blade template file is located in resources/views directory and named 'profile.blade.php'.
        // The second argument is an associative array.
        // The key is 'user' and the value is `Auth::user()`.
        // The `Auth::user()` method retrieves the currently authenticated user from the session.
        // The authenticated user is then passed to the 'profile.blade.php' template file.
        // The template file can then access the authenticated user through the 'user' variable.
        return view('profile', ['user' => Auth::user()]);
     }

     // Update user profile
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function index()
{
    $users = User::all(); // Fetch all users
    return view('admin.users', compact('users')); // Pass users to the view
}

}
