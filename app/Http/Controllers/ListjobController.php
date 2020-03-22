<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Listjob;

class ListjobController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('note::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('note::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show(Request $request)
    {
        if($request->ajax())
        {
            if($request->job_id == 0){
                $job=Listjob::create([
                    'job'=>$request->job,
                    'checklist_id'=>$request->checklist_id,
                ]);
                return response()->json([
                    'job'=>$job
                ]);
            } else {
                //update
                $job = Listjob::find($request->job_id);
                if($request->status == 1)
                    $job->is_done = 1;
                else if($request->is_done == 0)
                    $job->is_done = 0;
                if($request->job != null)
                    $job->job = $request->job;
                $job->update();
                return response()->json([
                    'job'=>$job
                ]);
            }
            return;
        }
        return view('note::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('note::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
