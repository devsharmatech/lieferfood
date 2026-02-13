<?php

namespace App\Http\Controllers;

use App\Models\country;
use App\Models\courier_job_application;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class CourierServiceController extends Controller
{
    //
    public function index()
    {
        return view('external.courier-home');
    }
    public function applyCourier()
    {
        return view('external.apply-courier-man');
    }
    public function store(Request $request)
    {
        // Define validation rules
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:courier_job_applications,email',
            'phone' => 'required|regex:/^[\d+]{10,15}$/',
            'dob' => 'required|date',
            'address' => 'required|string|max:500',
            'vehicleType' => 'required|string',
            'licenseNumber' => 'required|string|max:255',
            'licenseIssueDate' => 'required|date|before_or_equal:today',
            'nationalId' => 'required|string|max:255',
            'days' => 'required|array',
            'days.*' => 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'startTime' => 'required|array',
            'endTime' => 'required|array',
            'experience' => 'nullable|string|max:1000',
            'reference' => 'nullable|string|max:255',
            'referenceContact' => 'nullable|string|max:255',
            'profilePicture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'resume' => 'nullable|mimes:pdf,doc,docx|max:5120',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // dd($validator->errors());
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withInput($request->all())->withErrors($validator->errors());
        } else {
            $applicant = new courier_job_application();
            $applicant->firstName = $request->first_name;
            $applicant->lastName = $request->last_name;
            $applicant->email = $request->email;
            $applicant->phone = $request->phone;
            $applicant->dob = $request->dob;
            $applicant->address = $request->address;
            $applicant->vehicleType = $request->vehicleType;
            $applicant->licenseNumber = $request->licenseNumber;
            $applicant->licenseIssue = $request->licenseIssueDate;
            $applicant->nationalId = $request->nationalId;
            $startTimes=$request->startTime;
            $endTimes=$request->endTime;
            $workDays=[];
            foreach($request->days as $key=>$day){
              $workDays[]=['day'=>$day,'start_time'=>(isset($startTimes[$key]))?$startTimes[$key]:"",'end_time'=>(isset($endTimes[$key]))?$endTimes[$key]:""];
            }

            $applicant->workingDays = json_encode($workDays);
            $applicant->experience = $request->experience;
            $applicant->reference = $request->reference;
            $applicant->referenceContact = $request->referenceContact;
            // Handle file uploads
            if ($request->hasFile('profilePicture')) {
                $file = $request->file('profilePicture');
                $manager = new ImageManager(Driver::class);
                $image = $manager->read($file);
                $filename = uniqid('profile_') . '.' . $file->getClientOriginalExtension();
                $image->resize(400, 400)->save(public_path('uploads/profile_picture/' . $filename));
                $applicant->profilePicture = $filename;
            }
            if ($request->hasFile('resume')) {
                $file = $request->file('resume');
                $filename = uniqid('resume_') . '.' . $file->getClientOriginalExtension();
                $image->save(public_path('uploads/resumes/' . $filename));
                $applicant->resume = $filename;
            }
            $applicant->save();

            return redirect()->route('courier-service')->with(['alert-type' => 'success', 'message' => 'Your application has been submitted successfully.']);
        }
    }

    public function allCouriersApplications(){
        $users = courier_job_application::latest()->get();
        return view('admin.courier-partners.all-courier-applications', compact('users'));
    }
    public function viewCourierApplication($id){
        $user = courier_job_application::find($id);
        if($user){
            return view('admin.courier-partners.application-detail',compact('user'));
        }else{
            return back()->with(['alert-type' => 'error', 'message' => 'Application not found']);
        }
    }
    public function deleteCourierApplication($id){
        $user = courier_job_application::find($id);
        if($user){
            if(isset($user->resume) && !empty($user->resume)){
                $oldPathPdf=public_path('uploads/resumes/'.$user->resume);
                if(File::exists($oldPathPdf)){
                    File::delete($oldPathPdf);
                }
            }
            if(isset($user->profilePicture) && !empty($user->profilePicture)){
                $oldPathProfile=public_path('uploads/profile_picture/'.$user->profilePicture);
                if(File::exists($oldPathProfile)){
                    File::delete($oldPathProfile);
                }
            }
            $user->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'Application deleted successfully']);
        }else{
            return back()->with(['alert-type' => 'error', 'message' => 'Application not found']);
        }
    }

    public function allPartners(){
        $users=User::where('role','delivery_person')->latest()->get();
        return view('admin.courier-partners.all-courier-partners',compact('users'));
    }
    public function addPartner(){
        $countries = country::orderBy('name','ASC')->get();
        return view('admin.courier-partners.add-new-courier-partner',compact('countries'));
    }
}
