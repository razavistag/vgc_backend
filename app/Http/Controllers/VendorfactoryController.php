<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Vendorfactory;
use Database\Factories\VendorFactory as FactoriesVendorFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorfactoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $objFetch = Vendorfactory::orderby('id', 'desc')
                ->with('user:id,name,email')
                // ->groupby('vendor_auto_id')
                ->distinct('vendor_auto_id')
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

            $storeObj =  Vendorfactory::create($request->all());

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
     * @param  \App\Models\Vendorfactory  $vendorfactory
     * @return \Illuminate\Http\Response
     */
    public function show($vendorfactory)
    {
        try {
            $objFetch = Vendorfactory::where('factory_name',  'like', '%' . $vendorfactory . '%')
                ->orWhere('factory_code',  'like', '%' . $vendorfactory . '%')
                ->orWhere('factory_mobile',  'like', '%' . $vendorfactory . '%')
                ->orWhere('factory_email',  'like', '%' . $vendorfactory . '%')
                ->orWhere('vendor_name',  'like', '%' . $vendorfactory . '%')

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
     * @param  \App\Models\Vendorfactory  $vendorfactory
     * @return \Illuminate\Http\Response
     */
    public function edit($vendorfactory)
    {
        try {
            $objFetch = Vendorfactory::where('id', $vendorfactory)->with('user:id,name,email')->first();
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

    public function autoComplete($type, $find)
    {
        try {

            if ($type == 'vendor') {
                $objectFind = Vendor::orderby('id', 'desc')
                    ->where(
                        'name',
                        'like',
                        '%' . $find . '%',

                    )->limit(8)->get();
            }


            return response()->json([
                'success' => true,
                'object' => $objectFind
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
     * @param  \App\Models\Vendorfactory  $vendorfactory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $vendorfactory)
    {
        DB::beginTransaction();
        try {
            $storeObj = Vendorfactory::where('id', $vendorfactory)
                ->update([
                    'factory_name' =>  $request->factory_name,
                    'factory_code' =>  $request->factory_code,
                    'factory_mobile' =>  $request->factory_mobile,
                    'factory_email' =>  $request->factory_email,
                    'factory_address' =>  $request->factory_address,
                    'vendor_auto_id' =>  $request->vendor_auto_id,
                    'vendor_name' =>  $request->vendor_name,
                ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'FACTORY UPDATED SUCCESSFULLY',
                'data' => $storeObj,

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
     * @param  \App\Models\Vendorfactory  $vendorfactory
     * @return \Illuminate\Http\Response
     */
    public function destroy($vendorfactory)
    {
        DB::beginTransaction();
        try {
            $obj = Vendorfactory::find($vendorfactory);
            $obj->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Factory Successfully Deleted'
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
