<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Models\Gantt;
use Carbon\Carbon;

class GanttController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gantt = DB::table('gantt')->select('id', 'client', 'parts')->get()->toArray();

        return view("gantt")->with('gantt', $gantt);
    }

    public function getdata()
    {
        $gantt = DB::table('gantt')->select('id', 'name', 'start', 'end', 'progress', 'client', 'parts')->get()->toArray();

        header('Content-type: application/json');
        
        return response()->json($gantt);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'client' => 'required|string|max:255',
            'parts' => 'required|string|max:255',
        ]);
    
        
        if ($validator->fails()) {
            return redirect('/gantt')
                        ->withErrors($validator)
                        ->withInput();
        }
    

        $requestData = $request->all();
        $requestData = $request->all();
    
        $name = $requestData['name'] ?? [];
        $start = $requestData['start'] ?? [];
        $end = $requestData['end'] ?? [];
        $client = $requestData['client'] ?? [];
        $parts = $requestData['parts'] ?? [];
        $progress = 10;

        $gantt = new Gantt();
        $gantt->name = $name;
        $gantt->start = $start;
        $gantt->end = $end;
        $gantt->progress = $progress;
        $gantt->client = $client;
        $gantt->parts = $parts;

        $gantt->save();

        // will delete
        $gantt = DB::table('gantt')->select('id', 'name', 'start', 'end', 'progress', 'client', 'parts')->get()->toArray();

        // return redirect('/gantt');
        return response()->json([
            'message' => 'Gantt updated successfully',
            'gantt' => $gantt,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Gant $gant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gant $gant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
    
        $requestData = $request->all();
    if (isset($requestData['progress'])) {
        $id = $requestData['id'] ?? null;
        $progress = $requestData['progress'] ?? null;

        if ($id !== null && $progress !== null) {
            $gantt_save = Gantt::find($id);
            $gantt_save->progress = $progress;
            $gantt_save->save();

            return response()->json([
                'message' => 'Progress updated successfully',
                'gantt' => $gantt_save
            ], 200);
        } else {
            return response()->json([
                'message' => 'Invalid data provided',
            ], 400);
        }
    } else {
        $id = $requestData['id'] ?? null;
        $start = $requestData['start'] ?? null;
        $end = $requestData['end'] ?? null;

        if ($id !== null && $start !== null && $end !== null) {
            $start = substr($start, 0, 24);
            $end = substr($end, 0, 24);

            $start = date('Y-m-d H:i:s', strtotime($start));
            $end = date('Y-m-d H:i:s', strtotime($end));
            // Assuming similar logic for start and end update
            $gantt_save = Gantt::find($id);
            $gantt_save->start = $start;
            $gantt_save->end = $end;
            $gantt_save->save();

            return response()->json([
                'message' => 'Start and end dates updated successfully',
                'gantt' => $gantt_save
            ], 200);
        } else {
            return response()->json([
                'message' => 'Invalid data provided',
            ], 400);
        }
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        \Log::info('Destroy method called');
        \Log::info('Request data: ', $request->all());

        $id = $request->input('id');
        
        if (!$id) {
            return response()->json(['success' => false, 'message' => 'ID is required'], 400);
        }

        $gantt = Gantt::find($id);

        if (!$gantt) {
            return response()->json(['success' => false, 'message' => 'Gantt not found'], 404);
        }

        try {
            $gantt->delete();
            // return redirect('/gantt');
            return response()->json(['success' => true, 'message' => 'Gantt deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete Gantt', 'error' => $e->getMessage()], 500);
        }

        // return redirect('/gantt');
    }
}
