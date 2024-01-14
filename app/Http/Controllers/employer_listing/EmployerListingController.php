<?php

namespace App\Http\Controllers\employer_listing;

use App\Models\User;
use App\Models\listing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\employer\EmployerController;
// use App\Http\Controllers\employer_listing\EmployerListingController;


class EmployerListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $listings = $user->listings;

        return view('employer.job_listings.show', [
            'listings' => $listings,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $data = [
        //     'listings' => listing::all(),
        //     'listing' => $listing,
        // ];

        return view('employer.job_listings.create', [
            'listings' => listing::where('user_id', '=' , Auth::id())->get(),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'company_name' => ['required'],
            'job_category' => ['required'],
            'salary' => ['required'],
            'vacancies_available' => ['required'],
            'email' => ['required'],
            'picture' => ['image', 'mimes:png,jpg,jpeg,webp'],
            'contact_no' => ['required'],
            'description' => ['required'],
            'address' => ['required'],
        ]);

        if ($request->picture) {
            $name = microtime(true) . $request->picture->hashName();
            $request->picture->move(public_path('template/img/company_photos'), $name);
        } else {
            $name = null;
        }

        $data = [
            'company_name' => $request->company_name,
            'job_category' => $request->job_category,
            'salary' => $request->salary,
            'vacancies_available' => $request->vacancies_available,
            'email' => $request->email,
            'contact_no' => $request->contact_no,
            'description' => $request->description,
            'address' => $request->address,
            'picture' => $name,
            'user_id' => Auth::id(),
        ];

        if (listing::create($data)) {
            return back()->with(['success' => 'Magic has been spelled!']);
        } else {
            return back()->with(['failure' => 'Magic has failed to spell!']);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(listing $listing)
    {
        return view('employer.job_listings.index', [
            'listing' => $listing,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(listing $listing)
    {
        return view('employer.job_listings.edit', [
            'listing' => $listing,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, listing $listing)
    {


        $request->validate([
            'company_name' => ['required'],
            'job_category' => ['required'],
            'salary' => ['required'],
            'vacancies_available' => ['required'],
            'email' => ['required'],
            'picture' => ['image', 'mimes:png,jpg,jpeg,webp'],
            'contact_no' => ['required'],

        ]);

        $data = [
            'company_name' => $request->company_name,
            'job_category' => $request->job_category,
            'salary' => $request->salary,
            'vacancies_available' => $request->vacancies_available,
            'email' => $request->email,
            'contact_no' => $request->contact_no,
            'user_id' => Auth::id(),
        ];

        // if ($listing->$request->description == "" || $listing->$request->address == "") {
            if ($listing->update($data)) {
                return back()->with(['success' => 'Successfully Updated!']);
            } else {
                return back()->with(['failure' => 'Failed to update!']);
            }
        // }

    }

    public function add_desc(Request $request, listing $listing)
    {
        // $user = User::find(Auth::id());

        $request->validate([
            'description' => ['required'],
            'address' => ['required'],
        ]);

        $data = [
           'description' => $request->description,
           'address' => $request->address,
        //    'user_id' => Auth::id(),
        ];
        if ($listing->update($data)) {
            return back()->with(['success' => 'Successfully Updated!']);
        } else {
            return back()->with(['failure' => 'Failed to update!']);
        }
    }

    public function password(Request $request)
    {
        $user = User::find(Auth::id());
        $request->validate([
            'password' => ['required', 'confirmed'],
            'current_password' => ['required'],
        ]);

        if (Hash::check($request->current_password, $user->password)) {
            $data = [
                'password' => Hash::make($request->password),
            ];

            if ($user->update($data)) {
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
        $user = User::find(Auth::id());
        $request->validate([
            'picture' => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:10240'],
        ]);

        $old_picture_path = 'template/img/employerphotos/' . $user->picture;

        if ($user->picture && File::exists(public_path($old_picture_path))) {
            unlink(public_path($old_picture_path));
        }
        $new_file_name = "ACI-MAGICIANS" . microtime(true) . "." . $request->picture->getClientOriginalExtension();

        $data = [
            'picture' => $new_file_name,
        ];

        if ($request->picture->move(public_path('template/img/employerphotos/'), $new_file_name)) {
            if ($user->update($data)) {
                return back()->with(['success' => 'Picture Successfully updated!']);
            } else {
                return back()->with(['failure' => 'Failed to update!']);
            }
        } else {
            return back()->with(['failure' => 'Magic has failed to spell!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(listing $listing)
    {
        if ($listing->delete()){
            return redirect()->route('showlisting')->with(['success' => 'Successfully deleted!']);
        } else {
            return redirect()->route('showlisting')->with(['failure' => 'Failed to delete!']);
        }
    }
}
