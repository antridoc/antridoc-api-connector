<?php

namespace App\Http\Controllers;

use App\Doctor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hospitals = Doctor::paginate(12);
        return response($hospitals, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => ["required", "string"],
            "gender" => ["required", "string"],
            "address" => ["required", "string"],
            "phone_number" => ["required", "string"],
            "specialist" => ["required", "string"],
            "photo" => ["required", "string"],
            "hospitalId" => ["required", "integer"]
        ]);

        if ($validator->fails()) {
            return \response($validator->failed(), Response::HTTP_BAD_REQUEST);
        }

        DB::beginTransaction();
        try {
            Doctor::insert([
                "name" => $request->name,
                "gender" => $request->gender,
                "address" => $request->address,
                "phone_number" => $request->phone_number,
                "specialist" => $request->specialist,
                "photo" => $request->photo,
                "hospitalId" => $request->hospitalId
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $response["message"] = $e->getMessage();
            $response["status"] = $e->getCode();

            return \response($response, $e->getCode());
        }

        $response["message"] = "success store data";
        $response["status"] = Response::HTTP_CREATED;

        return \response($response, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $doctor = Doctor::where("id", $id)->first();

        if (!$doctor) {
            $response["message"] = "doctor not found";
            $response["status"] = Response::HTTP_NOT_FOUND;

            return \response($response, Response::HTTP_NOT_FOUND);
        }

        $response["message"] = "success retrieve doctor";
        $response["data"] = $doctor;
        $response["status"] = Response::HTTP_OK;

        return \response($response, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "name" => ["required", "string"],
            "gender" => ["required", "string"],
            "address" => ["required", "string"],
            "phone_number" => ["required", "string"],
            "specialist" => ["required", "string"],
            "photo" => ["required", "string"],
            "hospitalId" => ["required", "integer"]
        ]);

        if ($validator->fails()) {
            return \response($validator->failed(), Response::HTTP_BAD_REQUEST);
        }

        DB::beginTransaction();
        try {
            Doctor::where("id", $id)->update([
                "name" => $request->name,
                "gender" => $request->gender,
                "address" => $request->address,
                "phone_number" => $request->phone_number,
                "specialist" => $request->specialist,
                "photo" => $request->photo,
                "hospitalId" => $request->hospitalId
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $response["message"] = $e->getMessage();
            $response["status"] = $e->getCode();

            return \response($response, $e->getCode());
        }

        $response["message"] = "success update data";
        $response["status"] = Response::HTTP_OK;

        return \response($response, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Doctor::where("id", $id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $response["message"] = $e->getMessage();
            $response["status"] = $e->getCode();

            return \response($response, $e->getCode());
        }

        $response["message"] = "success delete doctor";
        $response["status"] = Response::HTTP_OK;

        return \response($response, Response::HTTP_OK);
    }
}
