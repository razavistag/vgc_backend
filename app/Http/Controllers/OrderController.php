<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CommentController;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objFetch = Order::orderby('id', 'desc')->with('Attachment')->paginate(20);

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

        $FormObj = $this->GetForm($request);
        app()->call('App\Http\Controllers\CommentController@store');
        $OrderID = Order::take('1')->orderby('id', 'desc')->first();
        if ($OrderID) {
            $OrderID = $OrderID->id + 1;
        } else {
            $OrderID = 1;
        }
        if (isset($FormObj['attachment'])) {
            foreach ($FormObj['attachment'] as $k => $i) {
                $now = Carbon::now()->timestamp;
                $randomName  = 'Order_' . rand(10, 1000) . '_' . $now . '_' . rand(10, 1000) . '.';
                $i->storeAs('/public/Order_attachments', $randomName . $i->getClientOriginalExtension());
                $storeObj =  Attachment::create([
                    'file_name' => $randomName . $i->getClientOriginalExtension(),
                    'file_extention' =>  $i->getClientOriginalExtension(),
                    'file_size' =>  $i->getSize(),
                    'document_auto_id' =>  $OrderID,
                    'document_name' =>  'Order',
                ]);
            }
        }
        $storeObj =  Order::create($FormObj);

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Order created successfully',
            'data' => $storeObj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($order)
    {
        $objFetch = Order::where('po_number',  'like', '%' . $order . '%')
            ->orWhere('control_number',  'like', '%' . $order . '%')
            ->orWhere('completed_by',  'like', '%' . $order . '%')
            ->orWhere('receiver',  'like', '%' . $order . '%')
            ->with('Attachment')->limit(10)->get();
        return response()->json([
            'success' => true,
            'objects' => $objFetch
        ], 200);
    }

    public function getStatus($order)
    {
        $objFetch = Order::select('id', 'is_immediate', 'status', 'price_ticket', 'total_value', 'upc_status')->where('id', $order)->get();
        return response()->json([
            'success' => true,
            'objects' => $objFetch
        ], 200);
    }

    public function updateStatus(Request $request)
    {

    //    return app()->call('App\Http\Controllers\CommentController@update');

        $userName = Auth::user()->name;
        $userID = Auth::user()->id;
        $objFetch = Order::findOrFail($request->id);
        $objFetch->upc_status = $request->input('upc_status');
        $objFetch->is_immediate = $request->input('is_immediate');
        $objFetch->total_value = $request->input('total_value');
        $objFetch->price_ticket = $request->input('price_ticket');
        $objFetch->status = $request->input('status');
        if ($request->status == 0) {
            $objFetch->receiver = $userName;
            $objFetch->receiver_auto_id = $userID;
        } elseif ($request->status == 2) {
            $objFetch->completed_by = $userName;
            $objFetch->completed_auto_id = $userID;
        } elseif ($request->status == 3) {
            $objFetch->approved_by = $userName;
            $objFetch->approved_auto_by = $userID;
        }
        $objFetch->save();
        app()->call('App\Http\Controllers\CommentController@update');


        return response()->json([
            'success' => true,
            'message' => 'Status updated',
            'objects' => $objFetch
        ], 200);
    }

    public function getAttachments($task)
    {
        $objFetch = Attachment::where('document_auto_id', $task)->get();
        return response()->json([
            'success' => true,
            'objects' => $objFetch
        ], 200);
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
    /**
     * Display the specified resource for auto complete.
     *
     */
    public function autoComplete($type, $find)
    {

        if ($type == 'customer') {
            $objectFind = User::orderby('id', 'desc')
                ->where(
                    'name',
                    'like',
                    '%' . $find . '%',

                )->where('status', '=',  1)
                // ->where('user_type', '=',  1)
                ->limit(8)->get();
        }
        if ($type == 'salesrep') {
            $objectFind = User::orderby('id', 'desc')
                ->where(
                    'name',
                    'like',
                    '%' . $find . '%',

                )->where('status', '=',  1)
                ->where('role', '=',  5)
                ->limit(8)->get();
        }

        if ($type == 'production') {
            $objectFind = User::orderby('id', 'desc')
                ->where(
                    'name',
                    'like',
                    '%' . $find . '%',

                )->where('status', '=',  1)
                ->limit(8)->get();
        }
        if ($type == 'company') {
            $objectFind = User::orderby('id', 'desc')
                ->where(
                    'company',
                    'like',
                    '%' . $find . '%',
                )
                ->get();
        }

        return response()->json([
            'success' => true,
            'object' => $objectFind
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit($order)
    {
        //

        $objFetch = Order::with(
            'customer:id,name',
            'salesrap:id,name',
            'production:id,name',
            'Attachment'
        )->find($order);


        return response()->json([
            'success' => true,
            'objects' => $objFetch
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $order)
    {
        //

        $FormObj = $this->GetForm($request);
        if (isset($FormObj['attachment'])) {
            if (isset($FormObj['attachment'][0])) {

                $checkExsist = substr($FormObj['attachment'][0], 0, 5);
                // return  $checkExsist;

                if ($checkExsist != 'Order') {
                    foreach ($FormObj['attachment'] as $k => $i) {
                        $now = Carbon::now()->timestamp;
                        $randomName  = 'Order_' . rand(10, 1000) . '_' . $now . '_' . rand(10, 1000) . '.';
                        $i->storeAs('/public/Order_attachments', $randomName . $i->getClientOriginalExtension());
                        $storeObj =  Attachment::create([
                            'file_name' => $randomName . $i->getClientOriginalExtension(),
                            'file_extention' =>  $i->getClientOriginalExtension(),
                            'file_size' =>  $i->getSize(),
                            'document_auto_id' =>  $order,
                            'document_name' =>  'Order',
                        ]);
                    }
                }
            }
        }

        unset($FormObj['attachment']);
        unset($FormObj['operation']);
        $storeObj = Order::where('id', $order)
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
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($order)
    {
        //
        DB::beginTransaction();
        try {
            $obj = Order::find($order);
            $obj->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order Successfully Deleted'
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
                "id" => ['bail'],
                "order_date" => ['bail'],
                "cancel_date" => ['bail'],
                "order_type" => ['bail'],
                "edi_status" => ['bail'],
                "upc_status" => ['bail'],
                "price_ticket" => ['bail'],
                "po_number" => ['bail'],
                "control_number" => ['bail'],
                "customer_auto_id" => ['bail'],
                "customer" => ['bail'],
                "customer_email" => ['bail'],
                "sales_rep_auto_id" => ['bail'],
                "sales_rep" => ['bail'],
                "sales_rep_email" => ['bail'],
                "production_by" => ['bail'],
                "production_auto_id" => ['bail'],
                "production_email" => ['bail'],
                "company_auto_id" => ['bail'],
                "or_style" => ['bail'],
                "re_style" => ['bail'],
                "total_value" => ['bail'],
                "number_of_style" => ['bail'],
                "status" => ['bail'],
                "attachment" => ['bail'],
                "eta" => ['bail'],
                "is_immediate" => ['bail'],
                "receiver_auto_id" => ['bail'],
                "receiver" => ['bail'],
                "operation" => ['bail'],
            ],

        );
    }
}
