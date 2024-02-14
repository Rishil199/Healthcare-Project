<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PatientDetails;
use App\Models\User;
use DataTables;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use Carbon\Carbon;
use App\Models\DoctorDetails;
use App\Models\ReceptionistDetails;
use App\Models\ClinicDetails;
use App\Models\DoctorAppointmentDetails;
use Illuminate\Support\Facades\Password;
use Spatie\Permission\Models\Role;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Auth;
use Illuminate\Support\Str;


class PatientController extends Controller
{
    /**
     * Use: Display listing of patients.
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request) {
        // dd("dd");
        $clinic_details = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
        // $patients = PatientDetails::select(array(
        //     'id','user_id','clinic_id','created_at','doctor_id'
        //     ))->latest()->with('user')->where('doctor_id',$user_id->id)->get();
            // dd($patients);
        if ($request->ajax()) {
            
            if(Auth::user()->hasRole(User::ROLE_SUPER_ADMIN)){
                $patients = PatientDetails::select(array(
                    'id','user_id','clinic_id','created_at'
                    ))->latest()->with('user')->get();  
                }
                if(Auth::user()->hasRole(User::ROLE_DOCTOR)) {
                // dd("dd");
                $user_id = DoctorDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
                // dd($user_id->id);
                $clinic_user_id = DoctorAppointmentDetails::select('id','user_id','clinic_id','doctor_id')->where('clinic_id',$user_id->clinic_id)->first();
                // dd($clinic_user_id);
                $patients = PatientDetails::select(array(
                'id','user_id','clinic_id','created_at','doctor_id'
                ))->with('user')->where('doctor_id',$user_id->id)->get();
                // $patients=Auth::user()->with('patients')->get();
                // dd($patients);
               
            }
             if(Auth::user()->hasRole(User::ROLE_RECEPTIONIST)) {
                // dd("dd");
                    $user_id = ReceptionistDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
                    $clinic_user_id = DoctorAppointmentDetails::select('id','user_id','clinic_id','doctor_id','receptionist_id')->where('clinic_id',$user_id->clinic_id)->first();
                    $patients = PatientDetails::select(array(
                    'id','user_id','clinic_id','created_at'
                 ))->latest()->with('user')->where('clinic_id',$user_id->id)->orWhere('clinic_id',$user_id->clinic_id)->get();
                    
                //  dd($patients);
                }

            if(Auth::user()->hasRole(User::ROLE_CLINIC)) {

                $user_id = ClinicDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
                // dd($user_id);
                $patients = PatientDetails::select(array(
                    'id','user_id','clinic_id','created_at'
                ))->latest()->with('user')->where('clinic_id',$clinic_details->id)->orWhere('receptionist_id',$user_id->id)->get();
              
                // dd($patients);
            }

            return Datatables::of($patients)
                ->editColumn('created_at', function($row) {
                    $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('dS F, Y h:i A');
                    return $formatedDate;
                })
                ->addColumn('fullname', function($row) {
                    return $row->user->first_name.' '.$row->user->last_name;
                })
                ->addColumn('email', function($row) {
                    return '<a href="mailto:' . $row->user->email . '?">' . $row->user->email . '</a>';
                })
                ->addColumn('action', function($row) {
                    $actionBtn =   '<div class="dropable-btn">
                                        <div class="dropdown">
                                            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                               <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                            </svg>
                                            </button>
                                            <ul class="dropdown-menu">
                                            <li>
                                               <a class="dropdown-item patient-view" href="javascript:void(0)" data-url="'. route('patients.view',$row->id) .'" data-id="'. $row->id .'" data-toggle="viewmodal" data-target="#myViewModal">
                                                  <span class="svg-icon">
                                                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"></path>
                                                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"></path>
                                                     </svg>
                                                  </span>
                                                  <span class="svg-text">View</span>
                                               </a>
                                            </li>
                                            <li>
                                               <a class="dropdown-item edit-patient" href="javascript:void(0)" data-url="'. route('patients.edit', $row->id) .'" data-id="'. $row->id .'">
                                                  <span class="svg-icon">
                                                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                                                     </svg>
                                                  </span>
                                                  <span class="svg-text">Edit</span>
                                               </a>
                                            </li>
                                            <li>
                                               <a class="dropdown-item" href="javascript:delete_record(' . $row->id . ');" class="btn btn-delete" title="Delete">
                                                      <span class="svg-icon">
                                                         <svg fill="#000000" width="16" height="16" version="1.1" id="lni_lni-trash-can" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                                                            <g>
                                                               <path d="M50.7,8.6H41V5c0-2.1-1.7-3.8-3.8-3.8H26.8C24.7,1.3,23,2.9,23,5v3.6h-9.7c-2.1,0-3.8,1.7-3.8,3.8v7.3c0,1,0.8,1.8,1.8,1.8
                                                                  h1.5v33.9c0,4.1,3.4,7.5,7.5,7.5h23.5c4.1,0,7.5-3.4,7.5-7.5V21.3h1.5c1,0,1.8-0.8,1.8-1.8v-7.3C54.4,10.2,52.8,8.6,50.7,8.6z
                                                                  M26.5,5c0-0.1,0.1-0.3,0.3-0.3h10.4c0.1,0,0.3,0.1,0.3,0.3v3.6H26.5V5z M13.1,12.3c0-0.1,0.1-0.3,0.3-0.3h11.5h14.4h11.5
                                                                  c0.1,0,0.3,0.1,0.3,0.3v5.5H13.1V12.3z M47.7,55.3c0,2.2-1.8,4-4,4H20.3c-2.2,0-4-1.8-4-4V21.3h31.5V55.3z"></path>
                                                               <path d="M32,48.3c1,0,1.8-0.8,1.8-1.8V33.4c0-1-0.8-1.8-1.8-1.8s-1.8,0.8-1.8,1.8v13.2C30.3,47.6,31,48.3,32,48.3z"></path>
                                                               <path d="M40.4,48.3c1,0,1.8-0.8,1.8-1.8V33.4c0-1-0.8-1.8-1.8-1.8s-1.8,0.8-1.8,1.8v13.2C38.7,47.6,39.5,48.3,40.4,48.3z"></path>
                                                               <path d="M23.6,48.3c1,0,1.8-0.8,1.8-1.8V33.4c0-1-0.8-1.8-1.8-1.8s-1.8,0.8-1.8,1.8v13.2C21.8,47.6,22.6,48.3,23.6,48.3z"></path>
                                                            </g>
                                                         </svg>
                                                      </span>
                                                      <span class="svg-text">Delete</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action','status','first_name','email'])
                ->make(true);
        }
    
        $this->data = array(
            'title' => 'Patients',
        );
        // dd($this->data);
        // dd($patients);

        return view('admin.patients.index', $this->data);
    }

    /**
     * Use: Insert record for patient 
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request) {

        $clinics = ClinicDetails::with('user')->select('id','user_id')->where('is_main_branch',1)->get();
        // dd($clinics->id);
        $doctors = DoctorDetails::with('user')->select('id','user_id')->get();

        if(Auth::user()->hasRole(User::ROLE_RECEPTIONIST)){    
            // dd('dd')
            
            $user_id = ReceptionistDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();

            $clinic_user_id = DoctorAppointmentDetails::select('id','user_id','clinic_id','doctor_id','receptionist_id')->where('clinic_id',$user_id->clinic_id)->first();

            $patients = PatientDetails::select(array(
            'id','user_id','clinic_id','created_at'
            ))->latest()->with('user')->where('receptionist_id',$user_id->id)->orWhere('clinic_id',$user_id->clinic_id)->get();
            
            $doctors = DoctorDetails::with('user')->select('id','user_id')->where('clinic_id',Auth::user()->id)->orWhere('clinic_id',$user_id->clinic_id)->get();
              
        }

        if(Auth::user()->hasRole(User::ROLE_CLINIC)){
            $user_id = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
            $clinics = ClinicDetails::with('user')->select('id','user_id')->where('is_main_branch',1)->first();
            $doctors = DoctorDetails::with('user')->where('clinic_id',$user_id->id)->get();
        }
        
        if ( $request->ajax() ) {
            $this->data = array(
                'title' => 'Add New patient',
                'clinics'=>$clinics,
                'doctors'=>$doctors,

            );
            $view = view('admin.patients.create', $this->data)->render();
            
            $this->data = array(
                'status' => true,
                'data' => array(
                    'view' => $view,
                    
                ),
            );
        } else {
            $this->data = array(
                'status' => false,
                'message' => 'Something went wrong. Request method is not allowed',
            );
        }
        return response()->json($this->data);
    }

    /**
     * Use: store data of patient 
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function store( StorePatientRequest $request ) {
        // dd($request);
        $role = Role::where(['name' => 'Patient'])->first();
        $post_data = $request->validated();

        $clinic_id = 0;
        $doctor_id = 0;

        $user_id = 0;
        $latitude = 0;
        $logitude = 0;

        $clinic_id = ClinicDetails::select('id','user_id')->where('user_id',$request->clinic_id)->first();
        $doctor_id = DoctorDetails::select('id','user_id')->where('user_id',$request->doctor_id)->first();

        $patient = new PatientDetails;
        $users = new User;
        $users->first_name = $post_data['first_name'];
        $users->last_name = $request['last_name'] ?? '';
        $users->email = $post_data['email'];
        $users->phone_no = $post_data['phone_no'];
        $users->name = $role->name;
        $users->assignRole(Role::findOrFail($role->id));
        $users->save();
        $patient->address = $post_data['address'];
        $patient->gender = $request['gender'];
        $patient->admit_date = @$request['admit_date'] ? Carbon::createFromFormat('d/m/Y',$request['admit_date']) : null;
        $patient->disease_name = $request['disease_name'];
        $patient->patient_number = Str::random(8);
        $patient->allergies = $request['allergies'] ?? '';
        $patient->prescription = $request['prescription'] ?? '';
        $patient->illness = $request['illness'] ?? '';
        $patient->exercise = $request['exercise'] ?? '';
        $patient->alchohol_consumption = $request['alchohol_consumption'] ?? '';
        $patient->diet = $request['diet'] ?? '';
        $patient->smoke = $request['smoke'] ?? '';
        $patient->user_id = $users['id'];
        $patient->height = $request['height'];
        $patient->weight = $request['weight'];
        $patient->blood_group = $request['blood_group'];
        $patient->blood_pressure = $request['blood_pressure'];
        $patient->is_mediclaim_available= $request['is_mediclaim_available'];
        $patient->relation = $request['relation'];
        $patient->relative_name = $request['relative_name'];
        $patient->emergency_contact = $request['emergency_contact'];
        // dd($patient);

        $patient->clinic_id = $request->clinic_id ? $clinic_id->id : Auth::user()->id;
        if(Auth::user()->hasRole(User::ROLE_RECEPTIONIST)){
            $user_id = ReceptionistDetails::select('id','user_id','clinic_id')->where('user_id',Auth::user()->id)->first();
            $patient->receptionist_id = $request->receptionist_id ?? $user_id->id;
            $patient->clinic_id = $user_id->clinic_id;
        }
        if(Auth::user()->hasRole(User::ROLE_DOCTOR)){
            $user_id = DoctorDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
            $patient->doctor_id = $request->doctor_id ?? $user_id->id;
        }
        if(Auth::user()->hasRole(User::ROLE_CLINIC)){
            // $user=Auth::user()->id;
            // dd($user);
            $user_id = ClinicDetails::select('id','user_id')->where('user_id',Auth::user()->id)->first();
            $doctor_id = DoctorDetails::select('id','user_id')->where('user_id',$request->doctor_id)->first();
            $patient->clinic_id = $request->clinic_id ?? $user_id->id;
            $patient->doctor_id = $request->doctor_id ?? Null;
        }
        if(Auth::user()->hasRole(User::ROLE_SUPER_ADMIN)) {
            $patient->doctor_id = $request->doctor_id ? $doctor_id->id : Auth::user()->id;
        }
        $patient->latitude = $request['latitude'] ? $request['latitude'] : $latitude;
        $patient->logitude = $request['logitude'] ? $request['logitude'] : $logitude;
        $patient->save();
        $token = $request->_token;

        if($users) {
            // Mail::to($users['email'])->send(new WelcomeMail($users,$request));

            Password::sendResetLink(
                $request->only('email')
            );
        
        }
        return response()->json(
            [
               'status' => true,
               'message' => 'New Patient has been created!'
            ]
        );
    }

    /**
     * Use: Display patients details 
     * By: DKP
     * @return \Illuminate\Http\Response
     */ 

    public function show(Request $request, $id) {
        // dd($id);

        $patient = PatientDetails::select('id','clinic_id','user_id','doctor_id','gender','admit_date','disease_name','prescription','allergies','illness','exercise','alchohol_consumption','diet','smoke','address','latitude','logitude',)->where('id',$id)->with('user')->first();
        // dd($patient);
        if(Auth::user()->hasRole(User::ROLE_CLINIC)){
            // dd($id);
            $user_id =PatientDetails::find($id);
            // dd($user_id);
            if($user_id){

            $patient = PatientDetails::select('clinic_id','user_id','doctor_id','gender','admit_date','disease_name','prescription','allergies','illness','exercise','alchohol_consumption','diet','smoke','address','latitude','logitude',)->where('id',$user_id->id)->with('user')->first();
            dd($patient);
            
            }
        $patient = PatientDetails::select('clinic_id','user_id','doctor_id','gender','admit_date','disease_name','prescription','allergies','illness','exercise','alchohol_consumption','diet','smoke','address','latitude','logitude',)->where('user_id',$id)->with('user')->first();
       
            
        }
        if(Auth::user()->hasRole(User::ROLE_RECEPTIONIST)){
             $patient = PatientDetails::select('clinic_id','user_id','doctor_id','gender','admit_date','disease_name','prescription','allergies','illness','exercise','alchohol_consumption','diet','smoke','address','latitude','logitude',)->where('id',$id)->with('user')->first();
             if(!$patient)
             {
                $patient = PatientDetails::select('clinic_id','user_id','doctor_id','gender','admit_date','disease_name','prescription','allergies','illness','exercise','alchohol_consumption','diet','smoke','address','latitude','logitude',)->where('user_id',$id)->with('user')->first();
                // dd($patient);
             }

        }
        if(Auth::user()->hasRole(User::ROLE_DOCTOR)){
            // $user=Auth::user();
            // dd($user);
            $user=DoctorAppointmentDetails::select('id','user_id')->where('patient_id',$id)->with('user')->first(); 
            // dd($user);
             $user_id = PatientDetails::find($id);
            //  dd($user_id);
            if ($user)
            {
        
              $patient = PatientDetails::select('clinic_id','user_id','doctor_id','gender','admit_date','disease_name','prescription','allergies','illness','exercise','alchohol_consumption','diet','smoke','address','latitude','logitude','height','weight','blood_group','blood_pressure','relation','relative_name','emergency_contact')->where('user_id',$user->user_id)->with('user')->first();
            //   dd($patient);
              
            } 
            else if ($user_id)
            {
                $patient = PatientDetails::select('clinic_id','user_id','doctor_id','gender','admit_date','disease_name','prescription','allergies','illness','exercise','alchohol_consumption','diet','smoke','address','latitude','logitude','height','weight','blood_group','blood_pressure','relation','relative_name','emergency_contact')->where('user_id',$user_id->user_id)->with('user')->first();
                // dd($patient);

            }
        }


       

        if ( $request->ajax() ) {
            $this->data = array(
                'title' => 'View Patient Details',
                'id' => $id,
                'patient' => $patient,
            );
            $view = view('admin.patients.view', $this->data)->render();
            
            $this->data = array(
                'status' => true,
                'data' => array(
                    'view' => $view,
                ),
            );
        } else {
            $this->data = array(
                'status' => false,
                'message' => 'Something went wrong. Request method is not allowed',
            );
        }
        return response()->json($this->data);
    }

    /**
     * Use: Edit form for patient's data
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function edit($id) {

        $patient = PatientDetails::with('user')->findOrFail($id);
        $clinics = ClinicDetails::with('user')->select('id','user_id')->where('is_main_branch',1)->get();
        $doctors = DoctorDetails::with('user')->select('id','user_id')->get();

        if(Auth::user()->hasRole(User::ROLE_CLINIC)) {
            $doctors = DoctorDetails::with('user')->whereIn('clinic_id', $clinics->pluck('id')->toArray())->get();
        }

        $this->data = array(
            'patient' => $patient,
            'clinics' => $clinics,
            'doctors' => $doctors,
        );

        $view = view('admin.patients.edit', $this->data)->render();
        $response = array(
            'status' => true,
            'data' => array(
                'view' => $view,
            ),
        );
        return response()->json($response);
    }

     /**
     * Use: Update patient's data
     * By: DKP
     * @return \Illuminate\Http\Response
     */

    public function update(UpdatePatientRequest $request, $id)
    {
     
        $clinic_id = 0;
        $latitude = 0;
        $logitude = 0;

        $patient = PatientDetails::with('user')->findOrFail($id);
        
        $patient->address = $request->validated()['address'];
        $patient->gender = $request['gender'];
        $patient->admit_date = Carbon::createFromFormat('d/m/Y',$request['admit_date']);;
        $patient->disease_name = $request['disease_name'];
        $patient->allergies = $request['allergies'];
        $patient->illness = $request['illness'];
        $patient->exercise = $request['exercise'];
        $patient->prescription = $request['prescription'];
        $patient->alchohol_consumption = $request['alchohol_consumption'];
        $patient->diet = $request['diet'];
        $patient->smoke = $request['smoke'];
        $patient->height = $request['height'];
        $patient->weight = $request['weight'];
        $patient->blood_group = $request['blood_group'];
        $patient->blood_pressure = $request['blood_pressure'];
        $patient->is_mediclaim_available= $request['is_mediclaim_available'];
        $patient->relation = $request['relation'];
        $patient->relative_name = $request['relative_name'];
        $patient->emergency_contact = $request['emergency_contact'];
        $patient->clinic_id = isset($request['clinic_id']) ? $request['clinic_id'] : $clinic_id;
        if(Auth::user()->hasRole(User::ROLE_RECEPTIONIST)){
            $patient->receptionist_id = isset($request['receptionist_id']) ? $request['receptionist_id'] : Auth::user()->id;
        }
        // $patient->doctor_id = isset($request['doctor_id']) ? $request['doctor_id'] : Auth::user()->id;
        $patient->latitude = $request['latitude'] ? $request['latitude'] : $latitude;
        $patient->logitude = $request['logitude'] ? $request['logitude'] : $logitude;
        $patient->save();
        $patient->user()->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'] ?: '',
            'email' => $request['email'],
            'phone_no' => $request['phone_no']],
        );
        //    dd($patient);
        return response()->json(
             [
               'status' => true,
               'message' => 'Patient has been updated.'
             ]
        );
        return response()->json($response);
        
    }

    /**
     * Use: Delete patient's record
     * By: DKP
     * @return \Illuminate\Http\Response
     */ 

    public function destroy(Request $request)
    {
        if($request->id){
            $delete_patient = PatientDetails::where('id',$request->id)->first();
        }
       
        if ($delete_patient->delete()) {
            $delete_patientuser = User::where('id',$delete_patient->user_id)->first();
            $delete_patientuser->delete();
            return response()->json([
                'status' => 'Doctor has been deleted!'
            ]);
        }
        return response()->json([
            'error' => 'Something went wrong!  Role not found!'
        ]);
  
    }

     /**
     * Use: Get the data of receptionist in CSV file
     * By: DKP
     * @return \Illuminate\Http\Response
     */
    public function exportCSV(Request $request)
    {
        $fileName = 'patients.csv';
        $patients = PatientDetails::with('user')->get();
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Id','First Name','Last Name','Gender','Email','Contact No.','Address','Admit Date','Disease Name','Prescription','Allergies','Illness','Exercise','Alcohol Consumption','Diet','Smoke');

        $callback = function() use($patients, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($patients as $patient) {
                $row['Id']  = $patient->id;
                $row['First Name']  = $patient->user->first_name;
                $row['Last Name']  = $patient->user->last_name;
                $row['Gender']  = $patient->gender;
                $row['Email']  = $patient->user->email;
                $row['Contact No.']  = $patient->user->phone_no;
                $row['Address']  = $patient->address;
                $row['Admit Date']  = $patient->admit_date;
                $row['Disease Name']  = $patient->disease_name;
                $row['Prescription']  = $patient->prescription;
                $row['Allergies']  = $patient->allergies ? $patient->allergies : 'N/A';
                $row['Illness']  = $patient->illness;
                $row['Exercise']  = $patient->exercise;
                $row['Alcohol Consumption']  = $patient->alchohol_consumption;
                $row['Diet']  = $patient->diet;
                $row['Smoke']  = $patient->smoke;
                                 

                fputcsv($file, array($row['Id'],$row['First Name'],$row['Last Name'],$row['Gender'],$row['Email'],$row['Contact No.'],$row['Address'],$row['Admit Date'],$row['Disease Name'],$row['Prescription'],$row['Allergies'],$row['Illness'],$row['Exercise'],$row['Alcohol Consumption'],$row['Diet'],$row['Smoke']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function fetchDoctors(Request $request)
    {
        $clinic_id = ClinicDetails::where('user_id',$request->clinic_id)->first();
        $data['doctors'] = DoctorDetails::where("clinic_id",$clinic_id->id)->with('user')->get();
        return response()->json($data);
    }
}
