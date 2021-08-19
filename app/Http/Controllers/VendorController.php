<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $objFetch = Vendor::orderby('id', 'desc')
                ->paginate(20);

            return response()->json([
                'success' => true,
                'objects' => $objFetch
            ], 200);
        } catch (\Exception $e) {

            DevelopmentErrorLog($e->getMessage(), $e->getLine());
            return response()->json([
                'success' => false,
                'message' => 'PLEASE TRY AGAIN LATER',
            ], 500);
        }
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

            $storeObj =  Vendor::create($request->all());

            DB::commit();
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Vendor created successfully',
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
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show($vendor)
    {
        try {
            $objFetch = Vendor::where('name',  'like', '%' . $vendor . '%')
                ->orWhere('code',  'like', '%' . $vendor . '%')
                ->orWhere('contact',  'like', '%' . $vendor . '%')


                ->limit(10)->get();


            return response()->json([
                'success' => true,
                'objects' => $objFetch
            ], 200);
        } catch (\Exception $e) {
            DevelopmentErrorLog($e->getMessage(), $e->getLine());
            return response()->json([
                'success' => false,
                'message' => 'PLEASE TRY AGAIN LATER',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit($vendor)
    {
        try {
            $objFetch = Vendor::find($vendor);
            return response()->json([
                'success' => true,
                'objects' => $objFetch
            ], 200);
        } catch (\Exception $e) {
            DevelopmentErrorLog($e->getMessage(), $e->getLine());
            return response()->json([
                'success' => false,
                'message' => 'PLEASE TRY AGAIN LATER',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $vendor)
    {
        DB::beginTransaction();
        try {
            $obj = Vendor::find($vendor);
            $obj['name'] = $request->name;
            $obj['code'] = $request->code;
            $obj['email'] = $request->email;
            $obj['contact'] = $request->contact;
            $obj['address'] = $request->address;
            $obj->save();

            // $storeObj = Vendor::where('id', $vendor)
            //     ->update([
            //         'name' =>  $request->name,
            //         'code' =>  $request->code,
            //         'email' =>  $request->email,
            //         'contact' =>  $request->contact,
            //         'address' =>  $request->address,
            //     ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Vendor UPDATED SUCCESSFULLY',
                'data' => $obj,

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
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy($vendor)
    {
        DB::beginTransaction();
        try {
            $obj = Vendor::find($vendor);
            $obj->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Vendor Successfully Deleted'
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
}
