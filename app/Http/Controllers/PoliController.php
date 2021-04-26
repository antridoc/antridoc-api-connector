<?php

namespace App\Http\Controllers;

use App\Poli;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PoliController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $polis = Poli::paginate(12);
        return response($polis, Response::HTTP_OK);
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
            "hospitalId" => ["required", "integer"]
        ]);

        if ($validator->fails()) {
            return \response($validator->failed(), Response::HTTP_BAD_REQUEST);
        }

        DB::beginTransaction();
        try {
            $poli = Poli::insert([
               "name" => $request->name,
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
     * @param  \App\Poli  $poli
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $poli = Poli::where("id", $id)->first();

        if (!$poli) {
            $response["message"] = "Poli not found";
            $response["status"] = Response::HTTP_NOT_FOUNDK;

            return \response($response, Response::HTTP_NOT_FOUND);
        }

        $response["message"] = "success retrieve poli";
        $response["data"] = $poli;
        $response["status"] = Response::HTTP_OK;

        return \response($response, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Poli  $poli
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "name" => ["required", "string"],
            "hospitalId" => ["required", "integer"]
        ]);

        if ($validator->fails()) {
            return \response($validator->failed(), Response::HTTP_BAD_REQUEST);
        }

        DB::beginTransaction();
        try {
            $poli = Poli::where("id", $id)->update([
                "name" => $request->name,
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
     * @param  \App\Poli  $poli
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Poli::where("id", $id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $response["message"] = $e->getMessage();
            $response["status"] = $e->getCode();
            return \response($response, $e->getCode());
        }

        $response["message"] = "success delete";
        $response["status"] = Response::HTTP_OK;

        return \response($response, Response::HTTP_OK);
    }
}
