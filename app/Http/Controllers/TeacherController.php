<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacher = Teacher::all();
        return response()->json([
            'status' => 'success',
            'teacher' => $teacher
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeacherRequest $request)
    {


        try{
            DB::beginTransaction();
            $teacher =Teacher::create([
                'name'=>$request->name,
                'age'=>$request->age,
                'address'=>$request->address
            ]);
            return response()->json([
                'status'=>'success',
                'teacher'=>$teacher
            ]);
            DB::commit();
        }
        catch(Throwable $th){
            Log::error($th);
            return response()->json([
                'status'=>'error',
            ]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $teacher = Teacher::find($id);
        return response()->json([
            'status'=>'success',
            'teacher'=>$teacher
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {

        $newData=[];
        if(isset($request->name)){
            $newData['name']=$request->name;
        };
        if(isset($request->age)){
            $newData['age']=$request->age;
        };
        if(isset($request->address)){
            $newData['address']=$request->address;
        };
        $teacher ->update($newData);
        return response()->json([
            'status'=>'success',
            'teacher'=>$teacher
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return response()->json([
            'status'=>'success'
        ]);
    }
}
