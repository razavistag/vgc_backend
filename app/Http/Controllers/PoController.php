<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Attachment;
use App\Models\Customer;
use App\Models\Po;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $objFetch = Po::orderby('id', 'desc')->with('Attachment', "CompletedBy:id,name", "approvedBy:id,name", "RequestedBy:id,name", "Agent:id,agent_name,agent_code")
            ->paginate(20);
        $this->rePhase($objFetch);


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
        try {
            $FormObj = $this->GetForm($request);


            app()->call('App\Http\Controllers\CommentController@store');

            $poID = Po::take('1')->orderby('id', 'desc')->first();
            if ($poID) {
                $poID = $poID->id + 1;
            } else {
                $poID = 1;
            }
            if (isset($FormObj['attachment'])) {
                foreach ($FormObj['attachment'] as $k => $i) {
                    $now = Carbon::now()->timestamp;
                    $randomName  = 'Po_' . rand(10, 1000) . '_' . $now . '_' . rand(10, 1000) . '.';
                    $i->storeAs('/public/Po_attachments', $randomName . $i->getClientOriginalExtension());
                    $storeObj =  Attachment::create([
                        'file_name' => $randomName . $i->getClientOriginalExtension(),
                        'file_extention' =>  $i->getClientOriginalExtension(),
                        'file_size' =>  $i->getSize(),
                        'document_auto_id' =>  $poID,
                        'document_name' =>  'Po',
                    ]);
                }
            }
            if (isset($FormObj['receiver_default'])) {
                if ($FormObj['receiver_default'] == 0) {
                    $FormObj['receiver_auto_id'] = Auth::user()->id;
                }
            }

            $storeObj =  Po::create($FormObj);

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'PO created successfully',
                'data' => $storeObj
            ]);
        } catch (\Exception $e) {

            DB::rollBack();
            DevelopmentErrorLog($e->getMessage(), $e->getLine());

            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => 'PLEASE TRY AGAIN',
                'e' => $e->getMessage(),
            ], 500);
        }
    }

    public function getAttachments($task)
    {
        $objFetch = Attachment::where('document_auto_id', $task)->get();
        return response()->json([
            'success' => true,
            'objects' => $objFetch
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Po  $po
     * @return \Illuminate\Http\Response
     */
    public function show($po)
    {
        $objFetch = Po::where('po_number',  'like', '%' . $po . '%')
            ->orWhere('control_number',  'like', '%' . $po . '%')
            ->orWhere('completed_by',  'like', '%' . $po . '%')
            ->orWhere('receiver',  'like', '%' . $po . '%')
            ->limit(10)->get();
        $this->rePhase($objFetch);

        return response()->json([
            'success' => true,
            'objects' => $objFetch
        ], 200);
    }
    public function autoComplete($type, $find)
    {

        if ($type == 'agent') {
            $objectFind = Agent::orderby('id', 'desc')
                ->where(
                    'agent_name',
                    'like',
                    '%' . $find . '%',

                )->limit(8)->get();
        }
        if ($type == 'vendor') {
            $objectFind = Vendor::orderby('id', 'desc')
                ->where(
                    'name',
                    'like',
                    '%' . $find . '%',

                )->limit(8)->get();
        }
        if ($type == 'customer') {
            $objectFind = Customer::orderby('id', 'desc')
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
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Po  $po
     * @return \Illuminate\Http\Response
     */
    public function edit($po)
    {
        $objFetch = Po::with(
            'Customer:id,name,email',
            'Vendor:id,name,email,code',
            'Agent',
            'Attachment'
        )->find($po);

        // $this->rePhase($objFetch);


        return response()->json([
            'success' => true,
            'objects' => $objFetch
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Po  $po
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $po)
    {
        $FormObj = $this->GetForm($request);
        app()->call('App\Http\Controllers\CommentController@store');

        if (isset($FormObj['attachment'])) {
            if (isset($FormObj['attachment'][0])) {
                $checkExsist = substr($FormObj['attachment'][0], 0, 2);
                if ($checkExsist != 'Po') {
                    foreach ($FormObj['attachment'] as $k => $i) {
                        $now = Carbon::now()->timestamp;
                        $randomName  = 'Po_' . rand(10, 1000) . '_' . $now . '_' . rand(10, 1000) . '.';
                        $i->storeAs('/public/Po_attachments', $randomName . $i->getClientOriginalExtension());
                        $storeObj =  Attachment::create([
                            'file_name' => $randomName . $i->getClientOriginalExtension(),
                            'file_extention' =>  $i->getClientOriginalExtension(),
                            'file_size' =>  $i->getSize(),
                            'document_auto_id' =>  $po,
                            'document_name' =>  'Po',
                        ]);
                    }
                }
            }
        }
        unset($FormObj['attachment']);
        unset($FormObj['operation']);
        $storeObj = Po::where('id', $po)
            ->update($FormObj);


        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Order UPDATED successfully',
            'data' => $storeObj,
            'req' => $FormObj
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Po  $po
     * @return \Illuminate\Http\Response
     */
    public function destroy($po)
    {
        //
        DB::beginTransaction();
        try {
            $obj = Po::find($po);
            $obj->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'po Successfully Deleted'
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

    public function destroyAttachment($order)
    {

        DB::beginTransaction();
        try {
            $obj = Attachment::find($order);
            $obj->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Attachment Successfully Deleted'
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
    public function getStatus($po)
    {
        $objFetch = Po::select('id', 'po_date', 'completed_by', 'approved_by', 'total_value', 'season', 'status')->with("CompletedBy:id,name,email", "approvedBy:id,name,email")->where('id', $po)->get();
        return response()->json([
            'success' => true,
            'objects' => $objFetch
        ], 200);
    }

    public function updateStatus(Request $request)
    {


        $userName = Auth::user()->name;
        $userID = Auth::user()->id;
        $objFetch = Po::findOrFail($request->id);
        $objFetch->approved_by = $request->approved_by;
        $objFetch->completed_by = $request->completed_by;
        $objFetch->po_date = $request->po_date;
        $objFetch->season = $request->season;
        $objFetch->status = $request->status;
        $objFetch->total_value = $request->total_value;
        if ($request->status == 0) {
            $objFetch->receiver = Auth::user()->name;
            $objFetch->receiver_auto_id = Auth::user()->id;
        } elseif ($request->status == 1) {
            $objFetch->completed_by = $userID;
        } elseif ($request->status == 2) {
            $objFetch->completed_by = $userID;
        } elseif ($request->status == 3) {
            $objFetch->completed_by = $userID;
        } elseif ($request->status == 4) {
            $objFetch->completed_by = $userID;
        } elseif ($request->status == 5) {
            $objFetch->completed_by = $userID;
        } elseif ($request->status == 6) {
            $objFetch->completed_by = $userID;
        } elseif ($request->status == 7) {
            $objFetch->completed_by = $userID;
        } elseif ($request->status == 8) {
            $objFetch->completed_by = $userID;
        } elseif ($request->status == 9) {
            $objFetch->completed_by = $userID;
        }
        if ($request->completed_by) {
            $objFetch->completed_by = $request->completed_by;
        }


        $objFetch->save();
        app()->call('App\Http\Controllers\CommentController@update');


        return response()->json([
            'success' => true,
            'message' => 'Status updated',
            'objects' => $objFetch
        ], 200);
    }

    public function rePhase($object)
    {
        $object->each(function ($item, $key) {
            $i =  $item->po_date  = date("Y-m-d",  $item->po_date);
            $i =  $item->po_request_date  = date("Y-m-d",  $item->po_request_date);
            $i =  $item->house_date  = date("Y-m-d",  $item->house_date);
            $i =  $item->cancel_date  = date("Y-m-d",  $item->cancel_date);
            $i =  $item->ex_fty_date  = date("Y-m-d",  $item->ex_fty_date);



            if ($item->priority == 0) $i = $item->priority = 'LOW';
            if ($item->priority == 1) $i = $item->priority = 'HEIGH';
            if ($item->priority == 0) $i = $item->priority = 'LOW';
            if ($item->status == 0) $i = $item->status = 'Requested';
            if ($item->status == 1) $i = $item->status = 'Working';
            if ($item->status == 2) $i = $item->status = 'Completed';
            if ($item->status == 3) $i = $item->status = 'Reopend';
            if ($item->status == 4) $i = $item->status = 'Pending';
            if ($item->status == 5) $i = $item->status = 'Approved ord';
            if ($item->status == 6) $i = $item->status = 'Approved pro';
            if ($item->status == 7) $i = $item->status = 'Approved';
            if ($item->status == 8) $i = $item->status = 'Close';
            if ($item->status == 9) $i = $item->status = 'Canceled';
            return $i;
        });
    }

    /**
     * Request Validation
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function GetForm(Request $request)
    {
        return $this->validate(
            $request,
            [
                'po_date'  => ['bail'],
                'po_request_date'  => ['bail'],
                'vendor_auto_id' => ['bail'],
                'vendor_code' => ['bail'],
                'vendor_email' => ['bail'],
                'vendor' => ['bail'],
                'agent_auto_id' => ['bail'],
                'agent' => ['bail'],
                'agent_email' => ['bail'],
                'agent_code' => ['bail'],
                'customer_auto_id' => ['bail'],
                'customer' => ['bail'],
                'customer_email' => ['bail'],
                'receiver_auto_id' => ['bail'],
                'receiver' => ['bail'],
                'receiver_email' => ['bail'],
                'cus_po_number' => ['bail'],
                'po_number' => ['bail'],
                'qty' => ['bail'],
                'number_of_style' => ['bail'],
                'total_value' => ['bail'],
                'company_auto_id' => ['bail'],
                'company' => ['bail'],
                'cus_po_number' => ['bail'],
                'style' => ['bail'],
                'priority' => ['bail'],
                'status' => ['bail'],
                'attachment_auto_id' => ['bail'],
                'attachment' => ['bail'],
                'control_number' => ['bail'],

                'house_date' => ['bail'],
                'cancel_date' => ['bail'],
                'ex_fty_date' => ['bail'],
                'beneficiary' => ['bail'],
                'payment_term' => ['bail'],
                'load_port' => ['bail'],
                'port_of_entry' => ['bail'],
                'ship_via' => ['bail'],
                'hanger' => ['bail'],
                'instruction' => ['bail'],
                'cost_type' => ['bail'],
                'warehouse' => ['bail'],
                'hanger_cost' => ['bail'],
                "operation" => ['bail'],
                "receiver_default" => ['bail'],
            ],
        );
    }
}
