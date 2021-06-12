<section id="Personal" class="body tabcontent" style="display:block">
    <form action="{{url('employee/update-personal-info/'.$employee->id)}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}

        @php 
            $datepicker_format = datepicker_format();
            $date_format = 'd-m-Y';

            if($datepicker_format == "MM-DD-YYYY") {
                $date_format = 'm-d-Y';
            }else if($datepicker_format == "YYYY/MM/DD") {
                $date_format = 'Y/m/d';
            }else if($datepicker_format == "DD-MMM-YY") {
                $date_format = 'd-M-y';
            }
        @endphp
        <div>
            @if($employee->employee_photo != "")
                <img src="{{ asset('storage/'.$employee->employee_photo) }}" class="pointer" style="margin-bottom:10px;border-radius:50%;" height="80" id="avatar" width="80" alt="employee" onclick="document.getElementById('imgInp').click()"/>
            @else
                <img class="pointer" style="margin-bottom:10px;" id="avatar" src="{{ asset('assets/img/users.png') }}" width="80" alt="employee" onclick="document.getElementById('imgInp').click()"/>
            @endif
                <input class="collapse" type="file" name="employee_photo" id="imgInp" onchange="preview_image(event)" />
        </div>
        <div class="row row-xs">
            <div class="col-md-3 pd-t-10">
                <label for="employee_id" style="font-weight:bold;" class="col-form-label">Employee ID:</label>
                <input type="text" name="employee_id" placeholder="Employee ID*" value="{{$employee->employee_id}}" class="form-control">
            </div>

            <div class="col-md-9 pd-t-10">
                <label for="employee_name" style="font-weight:bold;" class="col-form-label">Employee Name*:</label>
                <input type="text" name="name" placeholder="Employee Name*" value="{{$employee->name}}" class="form-control" required>
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="fathers_name" style="font-weight:bold;" class="col-form-label">Father's Name:</label>
                <input type="text" name="fathers_name" placeholder="Father Name" value="{{$employee->fathers_name}}" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="mothers_name" style="font-weight:bold;" class="col-form-label">Mother's Name:</label>
                <input type="text" name="mothers_name" placeholder="Mother Name" value="{{$employee->mothers_name}}" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="marital_status" style="font-weight:bold;" class="col-form-label">Marital Status:</label>
                <select class="form-control" name="marital_status">
                    <option value="Unmarried" @if($employee->marital_status == "Unmarried") selected @endif>Unmarried</option>
                    <option value="Married" @if($employee->marital_status == "Married") selected @endif>Married</option>
                    <option value="Divorced" @if($employee->marital_status == "Divorced") selected @endif>Divorced</option>
                    <option value="Widowed" @if($employee->marital_status == "Widowed") selected @endif>Widowed</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="spouse_name" style="font-weight:bold;" class="col-form-label">Spouse Name:</label>
                <input type="text" name="spouse_name" placeholder="Spouse Name" value="{{$employee->spouse_name}}" class="form-control">
            </div>

            <div class="col-md-6 pd-t-10">
                <label for="present_address" style="font-weight:bold;" class="col-form-label">Present Address:</label>
                <input type="text" name="present_address" placeholder="Present Address" value="{{$employee->present_address}}" class="form-control">
            </div>

            <div class="col-md-6 pd-t-10">
                <label for="permanent_address" style="font-weight:bold;" class="col-form-label">Permanent Address:</label>
                <input type="text" name="permanent_address" placeholder="Permanent Address" value="{{$employee->permanent_address}}" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="date_of_birth" style="font-weight:bold;" class="col-form-label">Date of Birth:</label>
                <input type="text" name="date_of_birth" placeholder="Date of Birth" @if($employee->date_of_birth != ""&& $employee->date_of_birth != "1970-01-01") value="{{ date($date_format,strtotime($employee->date_of_birth))}}" @endif class="form-control dtpicker" autocomplete="off" required/>
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="gender" style="font-weight:bold;" class="col-form-label">Gender:</label>
                <select class="form-control" name="gender" required>
                    <option value="" label>Select Gender</option>
                    <option value="Male" @if($employee->gender == "Male") selected @endif>Male</option>
                    <option value="Female" @if($employee->gender == "Female") selected @endif>Female</option>
                    <option value="Others" @if($employee->gender == "Others") selected @endif>Others</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="religion" style="font-weight:bold;" class="col-form-label">Religion*:</label>
                <select class="form-control" name="religion" required>
                    <option value="" label>Select Religion*</option>
                    <option value="Islam" @if($employee->religion == "Islam") selected @endif>Islam</option>
                    <option value="Christianity" @if($employee->religion == "Christianity") selected @endif>Christianity</option>
                    <option value="Hinduism" @if($employee->religion == "Hinduism") selected @endif>Hinduism</option>
                    <option value="Buddhism" @if($employee->religion == "Buddhism") selected @endif>Buddhism</option>
                    <option value="Others" @if($employee->religion == "Others") selected @endif>Others</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="blood_group" style="font-weight:bold;" class="col-form-label">Blood Group:</label>
                <select class="form-control" name="blood_group">
                    <option value="" label>Select Blood Group</option>
                    <option value="A+" @if($employee->blood_group == "A+") selected @endif>A+</option>
                    <option value="A-" @if($employee->blood_group == "A-") selected @endif>A-</option>
                    <option value="B+" @if($employee->blood_group == "B+") selected @endif>B+</option>
                    <option value="B-" @if($employee->blood_group == "B-") selected @endif>B-</option>
                    <option value="O+" @if($employee->blood_group == "O+") selected @endif>O+</option>
                    <option value="O-" @if($employee->blood_group == "O-") selected @endif>O-</option>
                    <option value="AB+" @if($employee->blood_group == "AB+") selected @endif>AB+</option>
                    <option value="AB-" @if($employee->blood_group == "AB-") selected @endif>AB-</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="nationality" style="font-weight:bold;" class="col-form-label">Nationality:</label>
                <input type="text" name="nationality" placeholder="Nationality" value="{{$employee->nationality}}" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="nid_number" style="font-weight:bold;" class="col-form-label">NID Number:</label>
                <input type="text" name="nid_number" placeholder="NID Number" value="{{$employee->nid_number}}" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="passport_number" style="font-weight:bold;" class="col-form-label">Passport Number:</label>
                <input type="text" name="passport_number" placeholder="Passport Number" value="{{$employee->passport_number}}" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="tin_no" style="font-weight:bold;" class="col-form-label">TIN Number:</label>
                <input type="text" name="tin_no" placeholder="TIN Number" value="{{$employee->tin_no}}" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="phone_1" style="font-weight:bold;" class="col-form-label">Phone Number 1*:</label>
                <input type="text" name="phone_1" placeholder="Phone Number 1*" value="{{$employee->phone_1}}" class="form-control" required>
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="phone_2" style="font-weight:bold;" class="col-form-label">Phone Number 2:</label>
                <input type="text" name="phone_2" placeholder="Phone Number 2" value="{{$employee->phone_2}}" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="emergency_contact_person" style="font-weight:bold;" class="col-form-label">Emergency Contact Person:</label>
                <input type="text" name="emergency_contact_person" placeholder="Emergency Contact Person" value="{{$employee->emergency_contact_person}}" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <label for="emergency_phone_number" style="font-weight:bold;" class="col-form-label">Emergency Phone Number:</label>
                <input type="text" name="emergency_phone_number" placeholder="Emergency Phone Number" value="{{$employee->emergency_phone_number}}" class="form-control">
            </div>

            @if($employee->employee_cv != "")
            
            <div class="col-md-12">
                <div class="row">
                    @foreach(json_decode($employee->employee_cv) as $cv)
                    <div class="col-md-1" style="padding-top:20px;padding-bottom:15px;text-align:center">
                        <a href="{{ asset('storage/employees/'.$cv) }}" target="_blank"><img src="{{asset('assets/img/document.png')}}" height="100" title="document"/></a><br><br>
                        <a href="{{url('employee/cv-delete/'.$employee->id.'/'.$cv)}}" style="font-size: 15px;" class="btn btn-danger btn-sm" >Delete</a>
                    </div>
                    <br>
                    @endforeach
                    
                </div>
            </div>
            @endif

            @if(document_upload_facility(Auth::user()->company_id) == 1)
            <div class="col-md-2 pd-t-20 text-left">
                Upload More (File size max 2MB)
            </div>
            <div class="col-md-10 pd-t-10">
                <input class="form-control" name="employee_cv[]" type="file" multiple="multiple">
            </div>
            @else
            <div class="col-md-12"></div>
            @endif

            <div class="col-md-12 pd-t-10">
                <label for="email" style="font-weight:bold;" class="col-form-label">Email*:</label><br>
                <input type="email" name="email_address" placeholder="Email Address*" value="{{$employee->email_address}}" class="form-control" required>
            </div>

            <div class="col-md-6 pd-t-10">
                <label for="reference_1" style="font-weight:bold;" class="col-form-label">Reference 1:</label>
                <textarea class="form-control" name="reference_1" style="height:100px" placeholder="Reference 1">{{$employee->reference_1}}</textarea>
            </div>
            <div class="col-md-6 pd-t-10">
                <label for="reference_2" style="font-weight:bold;" class="col-form-label">Reference 2:</label>
                <textarea class="form-control" name="reference_2" style="height:100px" placeholder="Reference 2">{{$employee->reference_2}}</textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 pd-t-10 text-right">
                <input type="submit" value="Update & Next" class="btn btn-primary"/>
            </div>
        </div>

    </form>
</section>