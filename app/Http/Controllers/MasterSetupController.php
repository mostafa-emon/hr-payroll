<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Designation;
use App\Department;
use App\project;
use App\Branch;
use Auth;

class MasterSetupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function department_index() {
        $departments = Department::where('company_id',Auth::user()->company_id)->orderBy('name','asc')->paginate(10);
        return view('master_setup.departments',compact('departments'));
    }

    public function department_add(Request $request) {
        $department = new Department;
        $department->company_id     = Auth::user()->company_id;
        $department->name           = $request->name;
        $department->department_id  = $request->department_id;
        $department->save();
        return redirect('departments')->with('message','Department Added Successfully!');
    }

    public function department_get($id) {
        $department = Department::where('id',$id)->first();
        echo $department;
    }

    public function department_update(Request $request,$id) {
        $department = Department::where('id',$id)->first();
        $department->name           = $request->name;
        $department->department_id  = $request->department_id;
        $department->save();
        return redirect('departments')->with('message','Department Updated Successfully!');
    }

    public function department_delete($id) {
        $department = Department::find($id);
        $department->delete();
        return redirect('departments')->with('message','Department Deleted Successfully!');
    }

    public function designation_index() {
        $designations = Designation::where('company_id',Auth::user()->company_id)->orderBy('name','asc')->paginate(10);
        return view('master_setup.designations',compact('designations'));
    }

    public function designation_add(Request $request) {
        $designation = new Designation;
        $designation->company_id     = Auth::user()->company_id;
        $designation->name           = $request->name;
        $designation->designation_id = $request->designation_id;
        $designation->save();
        return redirect('designations')->with('message','Designation Added Successfully!');
    }

    public function designation_get($id) {
        $designation = Designation::where('id',$id)->first();
        echo $designation;
    }

    public function designation_update(Request $request,$id) {
        $designation = Designation::where('id',$id)->first();
        $designation->name           = $request->name;
        $designation->designation_id = $request->designation_id;
        $designation->save();
        return redirect('designations')->with('message','Designation Updated Successfully!');
    }

    public function designation_delete($id) {
        $designation = Designation::find($id);
        $designation->delete();
        return redirect('designations')->with('message','Designation Deleted Successfully!');
    }


    public function project_index() {
        $projects = Project::where('company_id',Auth::user()->company_id)->orderBy('name','asc')->paginate(10);
        return view('master_setup.projects',compact('projects'));
    }

    public function project_add(Request $request) {
        $project = new Project;
        $project->company_id    = Auth::user()->company_id;
        $project->name          = $request->name;
        $project->project_id    = $request->project_id;
        $project->address       = $request->address;
        $project->save();
        return redirect('projects')->with('message','Project Added Successfully!');
    }

    public function project_get($id) {
        $project = Project::where('id',$id)->first();
        echo $project;
    }

    public function project_update(Request $request,$id) {
        $project = Project::where('id',$id)->first();
        $project->name          = $request->name;
        $project->project_id    = $request->project_id;
        $project->address       = $request->address;
        $project->save();
        return redirect('projects')->with('message','Project Updated Successfully!');
    }

    public function project_delete($id) {
        $project = Project::find($id);
        $project->delete();
        return redirect('projects')->with('message','Project Deleted Successfully!');
    }


    public function branch_index() {
        $branches = Branch::where('company_id',Auth::user()->company_id)->orderBy('name','asc')->paginate(10);
        return view('master_setup.branches',compact('branches'));
    }

    public function branch_add(Request $request) {
        $branch = new Branch;
        $branch->company_id = Auth::user()->company_id;
        $branch->name       = $request->name;
        $branch->branch_id  = $request->branch_id;
        $branch->address    = $request->address;
        $branch->save();
        return redirect('branches')->with('message','Branch Added Successfully!');
    }

    public function branch_get($id) {
        $branch = Branch::where('id',$id)->first();
        echo $branch;
    }

    public function branch_update(Request $request,$id) {
        $branch = Branch::where('id',$id)->first();
        $branch->name       = $request->name;
        $branch->branch_id  = $request->branch_id;
        $branch->address    = $request->address;
        $branch->save();
        return redirect('branches')->with('message','Branch Updated Successfully!');
    }

    public function branch_delete($id) {
        $branch = Branch::find($id);
        if($branch->company_id == Auth::user()->company_id){
            $branch->delete();
            return redirect('branches')->with('message','Branch Deleted Successfully!');
        }else{
            return redirect('branches')->with('message','Do not try to be too smart!');
        }
    }
}
