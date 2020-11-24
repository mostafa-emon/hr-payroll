<section id="Personal" class="body tabcontent" style="display:block">
    <form action="{{url('employee/update-personal-info/'.$employee->id)}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
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
                <input type="text" name="employee_id" placeholder="Employee ID" value="{{$employee->employee_id}}" class="form-control">
            </div>

            <div class="col-md-9 pd-t-10">
                <input type="text" name="name" placeholder="Employee Name*" value="{{$employee->name}}" class="form-control" required>
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="fathers_name" placeholder="Father Name" value="{{$employee->fathers_name}}" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="mothers_name" placeholder="Mother Name" value="{{$employee->mothers_name}}" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <select class="form-control" name="marital_status">
                    <option value="Unmarried" @if($employee->marital_status == "Unmarried") selected @endif>Unmarried</option>
                    <option value="Married" @if($employee->marital_status == "Married") selected @endif>Married</option>
                    <option value="Divorced" @if($employee->marital_status == "Divorced") selected @endif>Divorced</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="spouse_name" placeholder="Spouse Name" value="{{$employee->spouse_name}}" class="form-control">
            </div>

            <div class="col-md-6 pd-t-10">
            <input type="text" name="present_address" placeholder="Present Address" value="{{$employee->present_address}}" class="form-control">
            </div>

            <div class="col-md-6 pd-t-10">
                <input type="text" name="permanent_address" placeholder="Permanent Address" value="{{$employee->permanent_address}}" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="date_of_birth" placeholder="Date of Birth" @if($employee->date_of_birth != ""&& $employee->date_of_birth != "1970-01-01") value="{{ date('d-m-Y',strtotime($employee->date_of_birth))}}" @endif class="form-control dtpicker" autocomplete="off"/>
            </div>

            <div class="col-md-3 pd-t-10">
                <select class="form-control" name="gender">
                    <option value="" label>gender</option>
                    <option value="Male" @if($employee->gender == "Male") selected @endif>Male</option>
                    <option value="Female" @if($employee->gender == "Female") selected @endif>Female</option>
                    <option value="Others" @if($employee->gender == "Others") selected @endif>Others</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <select class="form-control" name="religion">
                    <option value="" label>religion</option>
                    <option value="Islam" @if($employee->religion == "Islam") selected @endif>Islam</option>
                    <option value="Christianity" @if($employee->religion == "Christianity") selected @endif>Christianity</option>
                    <option value="Hinduism" @if($employee->religion == "Hinduism") selected @endif>Hinduism</option>
                    <option value="Buddhism" @if($employee->religion == "Buddhism") selected @endif>Buddhism</option>
                    <option value="Others" @if($employee->religion == "Others") selected @endif>Others</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <select class="form-control" name="blood_group">
                    <option value="" label>blood group</option>
                    <option value="A+" @if($employee->religion == "A+") selected @endif>A+</option>
                    <option value="A-" @if($employee->religion == "A-") selected @endif>A-</option>
                    <option value="B+" @if($employee->religion == "B+") selected @endif>B+</option>
                    <option value="B-" @if($employee->religion == "B-") selected @endif>B-</option>
                    <option value="O+" @if($employee->religion == "O+") selected @endif>O+</option>
                    <option value="O-" @if($employee->religion == "O-") selected @endif>O-</option>
                    <option value="AB+" @if($employee->religion == "AB+") selected @endif>AB+</option>
                    <option value="AB-" @if($employee->religion == "AB-") selected @endif>AB-</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="nationality" placeholder="Nationality" value="{{$employee->nationality}}" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="nid_number" placeholder="NID Number" value="{{$employee->nid_number}}" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="passport_number" placeholder="Passport Number" value="{{$employee->passport_number}}" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="tin_no" placeholder="TIN Number" value="{{$employee->tin_no}}" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="phone_1" placeholder="Phone Number 1*" value="{{$employee->phone_1}}" class="form-control" required>
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="phone_2" placeholder="Phone Number 2" value="{{$employee->phone_2}}" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="emergency_contact_person" placeholder="Emergency Contact Person" value="{{$employee->emergency_contact_person}}" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="emergency_phone_number" placeholder="Emergency Phone Number" value="{{$employee->emergency_phone_number}}" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="email" name="email_address" placeholder="Email Address" value="{{$employee->email_address}}" class="form-control">
            </div>

            @if(document_upload_facility(Auth::user()->company_id) == 1)
            <div class="col-md-3 pd-t-20 text-right">
                Upload CV
            </div>
            <div class="col-md-6 pd-t-10">
                <input class="form-control" name="employee_cv" type="file">
            </div>
            @else
            <div class="col-md-9"></div>
            @endif

            <div class="col-md-6 pd-t-10">
                <textarea class="form-control" name="reference_1" style="height:100px" placeholder="Reference 1">{{$employee->reference_1}}</textarea>
            </div>
            <div class="col-md-6 pd-t-10">
                <textarea class="form-control" name="reference_2" style="height:100px" placeholder="Reference 2">{{$employee->reference_2}}</textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 pd-t-10">
                <input type="submit" value="Update & Next" class="btn btn-primary"/>
            </div>

            <div class="col-md-6 pd-t-10 text-right"> 
                <a href="{{url('employee/update/employment/'.$employee->id)}}" style="font-size: 15px;" class="btn btn-primary">Next</a>
            </div>
        </div>

    </form>
</section>