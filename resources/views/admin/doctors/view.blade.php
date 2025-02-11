<div class="modal-content">
    <div class="modal-header">
        <div class="title">
            <strong>View Doctor Detail</strong>
        </div>
    </div>
    <div class="modal-body mx-5">
        <div class="view-block">
            <div class="row">
                <div class="col-md-7">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="firstName">Name</label>
                        <div class="theme-form-input">
                            <span>{{ $doctor->user->first_name }} {{ $doctor->user->last_name }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="email">Email</label>
                        <div class="theme-form-input">
                         <span>{{ $doctor->user->email }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="status">Status</label>
                        <div class="theme-form-input">
                            <span>{{ $doctor->status==0 ? "Deactive" : "Active" }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="phone_no">Phone No</label>
                        <div class="theme-form-input">
                            <span>{{ $doctor->user->phone_no }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="address">Address</label>
                        <div class="theme-form-input">
                            <span>{{ $doctor->address }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="birth_date">Birth Date</label>
                        <div class="theme-form-input">
                           <span>{{ date('d/m/Y', strtotime($doctor->birth_date)) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="gender">Gender</label>
                        <div class="theme-form-input">
                            <span>{{ $doctor->gender }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="degree">Degree</label>
                        <div class="theme-form-input">
                           <span>{{ $doctor->degree }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="experience">Experience</label>
                        <div class="theme-form-input">
                            <span>{{ $doctor->experience }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="theme-form-group mb-3">
                        <label class="theme-label" for="expertice">Expertise</label>
                        <div class="theme-form-input">
                            <span>{{ $doctor->expertice }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-end">
            <button  type="button" class="btn btn-dark mt-0  mx-3" data-bs-dismiss="modal">  
                Back 
            </button>
        </div>
    </div>
</div>
