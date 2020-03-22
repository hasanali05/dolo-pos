<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Checklist;
use App\User;
use DB;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $lists = Checklist::all();
        $users = User::all();
        return view('admin.note.checklists.index')->with(compact('lists', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('admin.note.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $checklist = Checklist::create([
            'name'=>$request->name
        ]);
        return back();
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show(Request $request)
    {
        return view('admin.note.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('admin.note.edit');
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
    public function assignUser(Request $request)
    {
        DB::table('checklist_user')->insert([
            'checklist_id' => $request->checklist_id, 
            'user_id' => $request->user_id
        ]);
        return back()->with('success', 'assigned successfully!');
    }
    public function removeUser(Request $request)
    {
        DB::table('checklist_user')->where('checklist_id', $request->checklist_id)->where('user_id', $request->user_id)->delete();
        return back()->with('success', 'remove successfully!');
    }
}
