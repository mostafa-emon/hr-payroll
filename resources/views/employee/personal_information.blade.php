<section id="Personal" class="body tabcontent" style="display:block">
    <form action="{{url('employee/add-personal-info')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div>
            <img class="pointer" style="margin-bottom:10px" id="avatar" src="{{ asset('assets/img/users.png') }}" width="80" alt="employee" onclick="document.getElementById('imgInp').click()"/>
            <input class="collapse" type="file" name="employee_photo" id="imgInp" onchange="preview_image(event)" />
        </div>
        <div class="row row-xs">
            <div class="col-md-3 pd-t-10">
            <input type="text" name="employee_id" placeholder="Employee ID" class="form-control">
            </div>

            <div class="col-md-9 pd-t-10">
                <input type="text" name="name" placeholder="Employee Name*" class="form-control" required>
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="fathers_name" placeholder="Father Name" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="mothers_name" placeholder="Mother Name" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <select class="form-control" name="marital_status">
                    <option value="Unmarried">Unmarried</option>
                    <option value="Married">Married</option>
                    <option value="Divorced">Divorced</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="spouse_name" placeholder="Spouse Name" class="form-control">
            </div>

            <div class="col-md-6 pd-t-10">
            <input type="text" name="present_address" placeholder="Present Address" class="form-control">
            </div>

            <div class="col-md-6 pd-t-10">
                <input type="text" name="permanent_address" placeholder="Permanent Address" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="date_of_birth" placeholder="Date of Birth" class="form-control dtpicker" autocomplete="off"/>
            </div>

            <div class="col-md-3 pd-t-10">
                <select class="form-control" name="gender">
                    <option value="" label>gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Others">Others</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <select class="form-control" name="religion">
                    <option value="" label>religion</option>
                    <option value="Islam">Islam</option>
                    <option value="Christianity">Christianity</option>
                    <option value="Hinduism">Hinduism</option>
                    <option value="Buddhism">Buddhism</option>
                    <option value="Others">Others</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <select class="form-control" name="blood_group">
                    <option value="" label>blood group</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                </select>
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="nationality" placeholder="Nationality" value="Bangladeshi" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="nid_number" placeholder="NID Number" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="passport_number" placeholder="Passport Number" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="tin_no" placeholder="TIN Number" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="phone_1" placeholder="Phone Number 1*" class="form-control" required>
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="phone_2" placeholder="Phone Number 2" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="emergency_contact_person" placeholder="Emergency Contact Person" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="text" name="emergency_phone_number" placeholder="Emergency Phone Number" class="form-control">
            </div>

            <div class="col-md-3 pd-t-10">
                <input type="email" name="email_address" placeholder="Email Address" class="form-control">
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
                <textarea class="form-control" name="reference_1" style="height:100px" placeholder="Reference 1"></textarea>
            </div>
            <div class="col-md-6 pd-t-10">
                <textarea class="form-control" name="reference_2" style="height:100px" placeholder="Reference 2"></textarea>
            </div>
        </div>
        <div class="col-md-12 pd-t-10" style="margin-left:-12px">
            <input type="submit" value="Submit" class="btn btn-primary"/>
        </div>
    </form>
</section>