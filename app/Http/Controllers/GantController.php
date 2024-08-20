<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Models\Gant;
use Carbon\Carbon;


class GantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gantt = DB::table('gantt')->select('id', 'name', 'description', 'start', 'end', 'progress')->get()->toArray();

        // dump($gantt);

        return view("gantt");
    }

    public function getdata()
    {
        $gantt = DB::table('gantt')->select('id', 'name', 'description', 'start', 'end', 'progress')->get()->toArray();

        header('Content-type: application/json');
        
        return response()->json($gantt);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        // $validated = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'description' => 'required|string|max:255',
        //     'start' => 'required|date',
        //     'end' => 'required|date',
        //     'progress' => 'required|integer|min:0|max:100',
        // ]);

        // $gantt = Gant::create($validated);

        // return response()->json($gantt, 200);

        // Log::info('Update method called', [
        //     'request' => $request->all(),
        //     'gantt' => $gantt
        // ]);
    
        $requestData = $request->all();
    
        $id = $requestData['id'] ?? [];
        $start = $requestData['start'] ?? [];
        $end = $requestData['end'] ?? [];
        // // $tasks = json_decode($tasks, true);

        $start = substr($start, 0, 24);
        $end = substr($end, 0, 24);

        $start = Carbon::parse($start)->format('Y-m-d H:i:s');
        $end = Carbon::parse($end)->format('Y-m-d H:i:s');

        // Loop through the tasks and update the Gantt chart
            // $gantt = DB::table('gantt')->find($tasks['id']);
            

            $gantt_save = Gant::find($id);
            $gantt_save->start = $start;
            $gantt_save->end = $end;

            $gantt_save->save();

        //     $gantt->update([
        //         'start' => $tasks->start,
        //         'end' => $tasks->end,
        //      ]
        //   );

            $gantt = DB::table('gantt')->select('id', 'name', 'description', 'start', 'end', 'progress')->get()->toArray();
    
            return response()->json([
                'message' => 'Gantt updated successfully',
                // 'request' => $request->all(),
                'gantt' => $gantt,
                'gantt_save' => $gantt_save,
                // 'tasks' => $tasks
            ], 200);
    

        // Return a JSON response to confirm the request
        // return response()->json([
        //     'message' => 'Update method reached',
        //     'request' => $tasks,
        //     'gantt' => $gantt
        // ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gant $gant)
    {
        //
    }
}
