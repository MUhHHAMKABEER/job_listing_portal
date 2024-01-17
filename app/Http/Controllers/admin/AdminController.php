<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\listing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\employer_listing\EmployerListingController;
use Illuminate\Support\Facades\Crypt;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.adminprofile', [
            'admin' => Auth::user(),
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

        $old_picture_path = 'template/img/adminphotos/' . $admin->picture;

        if ($admin->picture && File::exists(public_path($old_picture_path))) {
            unlink(public_path($old_picture_path));
        }
        $new_file_name = "ACI-MAGICIANS" . microtime(true) . "." . $request->picture->getClientOriginalExtension();

        $data = [
            'picture' => $new_file_name,
        ];

        if ($request->picture->move(public_path('template/img/adminphotos/'), $new_file_name)) {
            if ($admin->update($data)) {
                return back()->with(['success' => 'Picture Successfully updated!']);
            } else {
                return back()->with(['failure' => 'Failed to update!']);
            }
        } else {
            return back()->with(['failure' => 'Magic has failed to spell!']);
        }
    }

    // AdminController.php


    // ...

    public function employers()
    {
        $employers = User::where('type', 'employer')->get(); // Fetch all employers from the database
        return view('admin.employers', ['employers' => $employers]);
    }
    // AdminController.php

    public function showemployers($id)
    {
        $employer = User::find($id);

        if ($employer && $employer->type === 'employer') {
            return view('admin.showemployers', ['employer' => $employer]);
        } else {
            return back()->with(['failure' => 'Employer not found!']);
        }
    }

    public function edit($id)
    {
        $employer = User::find($id);

        if ($employer && $employer->type === 'employer') {
            return view('admin.editemployers', ['employer' => $employer]);
        } else {
            return back()->with(['failure' => 'Employer not found!']);
        }
    }

    public function updateemployer(Request $request, $id)
    {
        $employer = User::find($id);
        $data =  $request->validate([
            'name' => ['required'],
            'email' => ['required'],
        ]);

        if ($employer->update($data)) {
            return back()->with(['success' => 'Successfully updated employer details!']);
        } else {
            return back()->with(['failure' => 'Failed to updateemployer details']);
        }
    }

    public function updatepicture(Request $request, $id)
    {
        $employer = User::find($id);
        $request->validate([
            'picture' => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:10240'],
        ]);

        $old_picture_path = 'template/img/employerphotos/' . $employer->picture;

        if ($employer->picture && File::exists(public_path($old_picture_path))) {
            unlink(public_path($old_picture_path));
        }
        $new_file_name = "ACI-MAGICIANS" . microtime(true) . "." . $request->picture->getClientOriginalExtension();

        $data = [
            'picture' => $new_file_name,
        ];

        if ($request->picture->move(public_path('template/img/employerphotos/'), $new_file_name)) {
            if ($employer->update($data)) {
                return back()->with(['success' => 'Picture Successfully updated!']);
            } else {
                return back()->with(['failure' => 'Failed to update!']);
            }
        } else {
            return back()->with(['failure' => 'Magic has failed to spell!']);
        }
    }

    public function updateemployerpassword(Request $request, $id)
    {
        $employer = User::find($id);

        $request->validate([
            'password' => ['required', 'confirmed'],
            // 'current_password' => ['required'],
        ]);

        // if (Hash::check($request->current_password, $employer->password)) {
        $data = [
            'password' => Hash::make($request->password),
        ];

        if ($employer->update($data)) {
            return back()->with(['success' => 'Employer password successfully updated!']);
        } else {
            return back()->with(['failure' => 'Failed to update employer password!']);
        }
        // } else {
        //     return back()->withErrors(['current_password' => 'Current password does not match!']);
        // }
    }

    public function createemployer()
    {
        return view('admin.createemployers');
    }

    public function addemployer(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Create the employer
        $employer = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Hash the password
            'type' => 'employer',
            // Add other fields as needed
        ]);

        return redirect()->route('create.employer')->with(['success' => 'Employer added successfully']);
    }

    public function deleteemployer(Request $request, $id)
    {
        $employer = User::find($id);

        if ($employer) {
            $employer->delete(); // This will delete the associated listings due to onDelete('cascade')

            return redirect()->route('employers')->with(['success' => 'Employer and associated listings successfully deleted!']);
        } else {
            return redirect()->route('employers')->with(['failure' => 'Employer not found!']);
        }
    }


    public function listings()
    {
        $listings = listing::all(); // Fetch all listings from the database
        return view('admin.listings', ['listings' => $listings]);
    }

    // ...
    public function showlistings($id)
    {
        $listing = Listing::find($id);

        if ($listing) {
            return view('admin.showlisting', ['listing' => $listing]);
        } else {
            return back()->with(['failure' => 'Listing not found!']);
        }
    }

    public function createlistings(){
        $employers = User::where('type', 'employer')->get();

        return view('admin.createlisting', ['employers' => $employers,]);


    }
   public function addlistings(Request $request)
{
    $request->validate([
        'employer' => ['required'],
        'company_name' => ['required'],
        'job_category' => ['required'],
        'salary' => ['required'],
        'vacancies_available' => ['required'],
        'email' => ['required', 'email'],
        'picture' => ['image', 'required', 'mimes:png,jpg,jpeg,webp'],
        'contact_no' => ['required'],
        'description' => ['required'],
        'address' => ['required'],
    ]);

    // Get the selected employer ID from the form
    $employerId = $request->employer;

    $user = User::find($employerId);

    if (!$user || $user->type !== 'employer') {
        return back()->with(['failure' => 'Invalid employer selected!']);
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
    ];

    // Create a new listing for the selected employer
    $listing = $user->listings()->create($data);

    if ($listing) {
        return back()->with(['success' => 'Listing created successfully!']);
    } else {
        return back()->with(['failure' => 'Failed to create listing!']);
    }
}



    public function editlistings($id)
    {
        $listing = Listing::find($id);

        if ($listing) {
            return view('admin.editlisting', ['listing' => $listing]);
        } else {
            return back()->with(['failure' => 'Listing not found!']);
        }
    }

    public function updateListings(Request $request, listing $listing)
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
            'picture' => $name,
            'user_id' => Auth::id(),
        ];

        // if ($listing->$request->description == "" || $listing->$request->address == "") {
            if ($listing->update($data)) {
                return back()->with(['success' => 'Successfully Updated!']);
            } else {
                return back()->with(['failure' => 'Failed to update!']);
            }

    }

    /**
     * Display the specified resource.
     */
    public function updatedec_addr(Request $request, listing $listing)
    {
        // $user = User::find(Auth::id());

        $request->validate([
            'description' => ['required'],
            'address' => ['required'],
        ]);

        $data = [
           'description' => $request->description,
           'address' => $request->address,
           'user_id' => Auth::id(),
        ];
        if ($listing->update($data)) {
            return back()->with(['success' => 'Successfully Updated!']);
        } else {
            return back()->with(['failure' => 'Failed to update!']);
        }
    }

    public function destroy(listing $listing)
    {
        if ($listing->delete()){
            return redirect()->route('listings')->with(['success' => 'Successfully deleted!']);
        } else {
            return redirect()->route('listings')->with(['failure' => 'Failed to delete!']);
        }
    }


}
