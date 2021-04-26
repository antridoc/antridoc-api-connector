<?php

namespace App\Http\Controllers;

use App\Hospital;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use \Mockery\Exception;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hospitals = Hospital::paginate(12);
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
            "phone_number" => ["required", "string"],
            "address_line_1" => ["required", "string"],
            "address_line_2" => ["string"],
            "province" => ["required", "string"],
            "regency" => ["required", "string"],
            "longitude" => ["required", "integer"],
            "latitude" => ["required", "integer"],
            "zip" => ["required", "integer"],
            "description" => ["required", "string"],
            "photo" => ["required", "string"],
            "web_app_tag" => ["required", "string"],
            "ownerId" => ["integer"]
        ]);

        if ($validator->fails()) {
            return \response($validator->failed(), Response::HTTP_BAD_REQUEST);
        }

        DB::beginTransaction();
        try {
            Hospital::insert([
                "name" => $request->name,
                "phone_number" => $request->phone_number,
                "address_line_1" => $request->address_line_1,
                "address_line_2" => $request->address_line_2,
                "province" => $request->province,
                "regency" => $request->regency,
                "logitude" => $request->longitude,
                "latitude" => $request->latitude,
                "zip" => $request->zip,
                "description" => $request->description,
                "photo" => $request->photo,
                "web_app_tag" => $request->web_app_tag,
                "ownerId" => $request->ownerId
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $response["messaage"] = $e->getMessage();
            $response["status"] = $e->getCode();

            return \response($response, $e->getCode());
        }

        $response["message"] = "success store data";
        $response["status"] = Response::HTTP_CREATED;

        return response($response, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hospital = Hospital::where("id", $id)->with("user")->first();

        if (!$hospital) {
            $response["message"] = "Hospital not found";
            $response["status"] = Response::HTTP_NOT_FOUND;

            return \response($response, Response::HTTP_NOT_FOUND);
        }

        $response["message"] = "success retrieve hospital";
        $response["status"] = Response::HTTP_OK;
        $response["data"] = $hospital;

        return response($response, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "name" => ["required", "string"],
            "phone_number" => ["required", "string"],
            "address_line_1" => ["required", "string"],
            "address_line_2" => ["string"],
            "province" => ["required", "string"],
            "regency" => ["required", "string"],
            "longitude" => ["required", "integer"],
            "latitude" => ["required", "integer"],
            "zip" => ["required", "integer"],
            "description" => ["required", "string"],
            "photo" => ["required", "string"],
            "web_app_tag" => ["required", "string"],
            "ownerId" => ["integer"]
        ]);

        if ($validator->fails()) {
            return \response($validator->failed(), Response::HTTP_BAD_REQUEST);
        }

        DB::beginTransaction();
        try {
            Hospital::where("id", $id)->update([
                "name" => $request->name,
                "phone_number" => $request->phone_number,
                "address_line_1" => $request->address_line_1,
                "address_line_2" => $request->address_line_2,
                "province" => $request->province,
                "regency" => $request->regency,
                "logitude" => $request->longitude,
                "latitude" => $request->latitude,
                "zip" => $request->zip,
                "description" => $request->description,
                "photo" => $request->photo,
                "web_app_tag" => $request->web_app_tag,
                "ownerId" => $request->ownerId
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $response["messaage"] = $e->getMessage();
            $response["status"] = $e->getCode();

            return \response($e->getMessage(), $e->getCode());
        }

        $response["message"] = "success update data";
        $response["status"] = Response::HTTP_OK;

        return response($response, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Hospital::where("id", $id)->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $response["message"] = $e->getMessage();
            $response["status"] = $e->getCode();

            return \response($response, $e->getCode());
        }

        $response["message"] = "Success Delete";
        $response["status"] = Response::HTTP_OK;

        return \response($response, Response::HTTP_OK);
    }
}
