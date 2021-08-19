<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $objFetch = Agent::orderby('id', 'desc')
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

            $storeObj =  Agent::create($request->all());

            DB::commit();
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'AGENT created successfully',
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
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function show($agent)
    {
        try {
            $objFetch = Agent::where('agent_name',  'like', '%' . $agent . '%')
                ->orWhere('agent_code',  'like', '%' . $agent . '%')
                ->orWhere('agent_email',  'like', '%' . $agent . '%')
                ->orWhere('agent_mobile',  'like', '%' . $agent . '%')

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
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function edit($agent)
    {
        try {
            $objFetch = Agent::find($agent);
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
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $agent)
    {
        DB::beginTransaction();
        try {
            $obj = Agent::find($agent);
            $obj['agent_name'] =  $request->agent_name;
            $obj['agent_code'] = $request->agent_code;
            $obj['agent_email'] = $request->agent_email;
            $obj['agent_mobile'] = $request->agent_mobile;
            $obj['agent_address'] = $request->agent_address;
            $obj->save();
            // $storeObj = Agent::where('id', $agent)
            //     ->update([
            //         'agent_name' =>  $request->agent_name,
            //         'agent_code' =>  $request->agent_code,
            //         'agent_email' =>  $request->agent_email,
            //         'agent_mobile' =>  $request->agent_mobile,
            //         'agent_address' =>  $request->agent_address,
            //     ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'AGENT UPDATED SUCCESSFULLY',
                // 'data' => $storeObj,
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
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function destroy($agent)
    {
        DB::beginTransaction();
        try {
            $obj = Agent::find($agent);
            $obj->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Agent Successfully Deleted'
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
