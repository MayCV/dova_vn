<?php

namespace App\Http\Controllers\Backend;
use App\Project;
use App\Branch;
use Carbon\Carbon;
use DB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function index(){
        $branch = Branch::all();
        $project = Project::all();
        $ongoing = Project::where('status', 1)->get();
        $complete = Project::where('status', 2)->get();
        $unexecuted = Project::where('status', 0)->get();
        return view('backend.project.project-home',
        [
         'branch'=>$branch,
         'project'=>$project,
         'ongoing'=>$ongoing,
         'complete'=>$complete,
         'unexecuted'=>$unexecuted
        ]);
    }
    public function getList() {
        $branch = Branch::all();
        $project = Project::all()->reverse();
        return view('backend.project.project',['project'=>$project, 'branch'=>$branch]);
    }

    public function store(Request $request) {
        
        if($request->hasFile('image')){
            $img=$request->image;
            $img->move(base_path('/public/public/upload'),$img->getClientOriginalname());
            $image=$img->getClientOriginalname();
        }
        else{
            $image='noimageavailable.jpg';
        }

        $branch = new Branch;
        $project = new Project;
        $project->name = $request->name;
        $project->image = $image;
        $project->content = $request->content;
        $project->time_start = $request->time_start;
        $project->deadline = $request->deadline;
        $project->status = $request->status;
        $project->rate = $request->rate;
        $project->branch_id = $request->branch;
        $project->note = $request->note;
        $project->save();


        return redirect('project/listProject');
    }

    public function create(){
        return view('backend.project.project');
    }

    
    public function ongoingList() {
        $branch = Branch::all();
        $ongoing = Project::where('status', 1)->get()->reverse();
        return view('backend.project.ongoing-project',compact('ongoing','branch'));
    }

    public function completeList() {
        $branch = Branch::all();
        $complete = Project::where('status', 2)->get()->reverse();
        return view('backend.project.complete-project',compact('complete','branch'));
    }

    public function unexecutedList(){
        $branch = Branch::all();
        $unexecuted = Project::where('status', 0)->get()->reverse();
        return view('backend.project.unexecuted-project', compact('unexecuted', 'branch'));
    }

    public function search(Request $request) {
        $result = Project::where('name','like','%'.$request->key.'%')->get();
        return view('backend.project.project-search-result',compact('result'));
    }

    public function detail($id){

        $project = Project::where('id', '=', $id)->select('*')->first();
        $branch = Branch::where('id', '=', $project->branch_id)->select('*')->first();
        // $project = DB::table('project')->join('branch', 'branch.id', '=', 'project.branch_id')
        //                                ->select('project.*', 'branch.name')->get();
        return view('backend.project.project-detail', compact('project','branch'));
    }
    
}
