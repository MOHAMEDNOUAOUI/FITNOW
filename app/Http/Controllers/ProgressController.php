<?php

namespace App\Http\Controllers;

use App\Models\Progress;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use PhpParser\Builder\Use_;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpKernel\Profiler\Profile;

use function Laravel\Prompts\progress;

class ProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $userId = $request->user()->id;
        $progress = Progress::create([
            'user_id' => $userId,
            'weight' => $request->input('weight'),
            'hips' => $request->input('hips'),
            'chest' => $request->input('chest'),
            'waist' => $request->input('waist'),
            'performance' => $request->input('performance'),
        ]);

        return response()->json($progress, 201);
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
    public function show(Request $request)
    {
        try {
            $userId = $request->user()->id;
            $user = Progress::where('user_id' , $userId)->get();
            return response()->json($user);
        }
        catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Progress $progress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $userId = $request->user()->id;

        $progress = Progress::where('user_id', $request->user()->id)
        ->where('id', $request->input('progress_id'))
        ->firstOrFail();

        if ($request->has('weight')) {
            $progress->weight = $request->weight;
        }
        if ($request->has('chest')) {
            $progress->chest = $request->chest;
        }

        if ($request->has('waist')) {
            $progress->waist = $request->waist;
        }

        if ($request->has('hips')) {
            $progress->hips = $request->hips;
        }


        if($request->has('status')){
            $progress = Progress::where('user_id', $request->user()->id)
            ->where('id', $request->input('progress_id'))
            ->firstOrFail();
    
            $progress->status = "Terminé";
            $progress->save();
    
            return response()->json(['message' => "Status has being updated succefully"]);
        }


        $progress->save();

        return response()->json($progress);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $progress = Progress::where('user_id', $request->user()->id)
        ->where('id', $request->input('progress_id'))
        ->firstOrFail();

        $progress->delete();
        return response()->json(['message' => 'Progress data deleted successfully'], 200);
    }


}
