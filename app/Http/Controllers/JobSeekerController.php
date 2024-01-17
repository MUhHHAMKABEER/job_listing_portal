<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\listing;
use Illuminate\Http\Request;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class JobSeekerController extends Controller
{
    public function index()
    {
        return view('jobseeker.index');
    }

    public function profile()
    {
        return view('jobseeker.jsprofile', [
            'user' => Auth::user(),
        ]);
    }
    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
        ]);

        $admin = User::find(Auth::id());

        if ($admin->update($data)) {
            return back()->with(['success' => 'Successfully updated!']);
        } else {
            return back()->with(['failure' => 'Failed to update!']);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function password(Request $request)
    {
        $admin = User::find(Auth::id());
        $request->validate([
            'password' => ['required', 'confirmed'],
            'current_password' => ['required'],
        ]);

        if (Hash::check($request->current_password, $admin->password)) {
            $data = [
                'password' => Hash::make($request->password),
            ];

            if ($admin->update($data)) {
                return back()->with(['success' => 'Password Successfully Updated!']);
            } else {
                return back()->with(['failure' => 'Failed to update password!']);
            }
        } else {
            return back()->withErrors(['current_password' => 'Current password does not match!']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function picture(Request $request)
    {
        $admin = User::find(Auth::id());
        $request->validate([
            'picture' => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:10240'],
        ]);

        $old_picture_path = 'template/img/jsphotos/' . $admin->picture;

        if ($admin->picture && File::exists(public_path($old_picture_path))) {
            unlink(public_path($old_picture_path));
        }
        $new_file_name = "ACI-MAGICIANS" . microtime(true) . "." . $request->picture->getClientOriginalExtension();

        $data = [
            'picture' => $new_file_name,
        ];

        if ($request->picture->move(public_path('template/img/jsphotos/'), $new_file_name)) {
            if ($admin->update($data)) {
                return back()->with(['success' => 'Picture Successfully updated!']);
            } else {
                return back()->with(['failure' => 'Failed to update!']);
            }
        } else {
            return back()->with(['failure' => 'Magic has failed to spell!']);
        }
    }

    public function showjslistings(){
        // return view('jobseeker.listings.jslisting');

        $listings = listing::all();

        return view('jobseeker.listings.jslisting', ['listings' => $listings]);
    }



}
