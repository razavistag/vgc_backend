<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objFetch = Location::orderby('id', 'desc')
            ->paginate(20);



        return response()->json([
            'success' => true,
            'objects' => $objFetch
        ], 200);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $FormObj = $this->GetForm($request);
            $storeObj =  Location::create($FormObj);



            DB::commit();
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'LOCATION created successfully',
                'data' => $storeObj
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            DevelopmentErrorLog($e->getMessage(), $e->getLine());

            return response()->json([
                'success' => false,
                'message' => 'PLEASE TRY AGAIN LATER',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show($location)
    {
        $objFetch = Location::where('location_name',  'like', '%' . $location . '%')
            ->orWhere('location_city',  'like', '%' . $location . '%')
            ->orWhere('location_zip_code',  'like', '%' . $location . '%')
            ->orWhere('location_country',  'like', '%' . $location . '%')
            ->orWhere('location_phone',  'like', '%' . $location . '%')
            ->orWhere('location_address',  'like', '%' . $location . '%')
            ->limit(10)->get();


        return response()->json([
            'success' => true,
            'objects' => $objFetch
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit($location)
    {

        $objFetch = Location::find($location);
        return response()->json([
            'success' => true,
            'objects' => $objFetch
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $location)
    {
        DB::beginTransaction();
        try {
            $FormObj = $this->GetForm($request);

            $storeObj = Location::where('id', $location)
                ->update([
                    'location_name' =>  $FormObj["location_name"],
                    'location_address' =>  $FormObj["location_address"],
                    'location_city' =>  $FormObj["location_city"],
                    'location_zip_code' =>  $FormObj["location_zip_code"],
                    'location_country' =>  $FormObj["location_country"],
                    'location_phone' =>  $FormObj["location_phone"],
                    'location_phone' =>  $FormObj["location_phone"],
                    'location_status' =>  $FormObj["location_status"],
                ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'LOCATION UPDATED SUCCESSFULLY',
                'data' => $storeObj,
                'req' => $FormObj
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            DevelopmentErrorLog($e->getMessage(), $e->getLine());

            return response()->json([
                'success' => false,
                'message' => 'PLEASE TRY AGAIN LATER',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy($location)
    {
        DB::beginTransaction();
        try {
            $obj = Location::find($location);
            $obj->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Location Successfully Deleted'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            DevelopmentErrorLog($e->getMessage(), $e->getLine());

            return response()->json([
                'success' => false,
                'message' => 'PLEASE TRY AGAIN LATER',
            ], 500);
        }
    }

    public function GetForm(Request $request)
    {
        return $this->validate(
            $request,
            [
                'location_name'  => ['bail'],
                'location_address'  => ['bail'],
                'location_city'  => ['bail'],
                'location_zip_code'  => ['bail'],
                'location_country'  => ['bail'],
                'location_phone'  => ['bail'],
                'location_status'  => ['bail'],

            ],
        );
    }
}
