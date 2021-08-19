<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Receivinglogentery;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceivinglogenteryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $document_type = 'receivinglogentries';
            $objFetch = Receivinglogentery::orderby('id', 'desc')
                ->with(
                    [
                        'Attachment' => function ($q) use ($document_type) {
                            $q->where('document_name', 'receivinglogentries');
                        },
                        'Vendor:id,name'
                    ]
                )
                ->paginate(20);
            $this->rePhaseToDate($objFetch);
            $this->rePhaseToDevition($objFetch);


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
    public function create(Request $request)
    {
        // return $request->id_onUpdate;
        DB::beginTransaction();
        try {
            $FormObj = $this->GetForm($request);
            // return $FormObj['attachment'];
            $LastID = Receivinglogentery::take('1')->orderby('id', 'desc')->first();
            // return $LastID;
            // $LastID = DB::table('audits')
            //     ->where(
            //         [
            //             ['auditable_type', 'App\Models\Receivinglogentery'],
            //             ['event', 'created']
            //         ]
            //     )
            //     ->select('auditable_id')
            //     ->orderBy('id', 'desc')
            //     ->take(1)
            //     ->get();

            if ($LastID) {
                // return $LastID;
                $LastID = $LastID->id + 1;
                // $LastID = $LastID[0]->auditable_id + 1;
                // $LastID = 10 + 1;
            } else {
                $LastID = 1;
            }
            if (isset($FormObj['attachment'])) {
                // return 1;
                foreach ($FormObj['attachment'] as $k => $i) {
                    $now = Carbon::now()->timestamp;
                    $randomName  = 'RLOGENTRY_' . rand(10, 1000) . '_' . $now . '_' . rand(10, 1000) . '.';
                    $i->storeAs('/public/receivinglogentries_attachments', $randomName . $i->getClientOriginalExtension());
                    if ($request->id_onUpdate == 'undefined') {
                        $storeObj =  Attachment::create([
                            'file_name' => $randomName . $i->getClientOriginalExtension(),
                            'file_extention' =>  $i->getClientOriginalExtension(),
                            'file_size' =>  $i->getSize(),
                            'document_auto_id' =>  $LastID,
                            'document_name' =>  'receivinglogentries',
                        ]);
                    } else {
                        $storeObj =  Attachment::create([
                            'file_name' => $randomName . $i->getClientOriginalExtension(),
                            'file_extention' =>  $i->getClientOriginalExtension(),
                            'file_size' =>  $i->getSize(),
                            'document_auto_id' =>  $request->id_onUpdate,
                            'document_name' =>  'receivinglogentries',
                        ]);
                    }
                }
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'LOG ENTERY attachment uploaded successfully',

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
            $storeObj =  Receivinglogentery::create($FormObj);
            DB::commit();
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'LOG ENTERY created successfully',
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
     * @param  \App\Models\Receivinglogentery  $receivinglogentery
     * @return \Illuminate\Http\Response
     */
    public function show($receivinglogentery)
    {
        try {
            $objFetch = Receivinglogentery::where('po',  'like', '%' . $receivinglogentery . '%')
                ->orWhere('amt_shipment',  'like', '%' . $receivinglogentery . '%')
                ->orWhere('appointment_no',  'like', '%' . $receivinglogentery . '%')
                ->orWhere('container',  'like', '%' . $receivinglogentery . '%')
                ->with('Attachment', 'Vendor:id,name')
                ->limit(10)->get();
            $this->rePhaseToDate($objFetch);
            $this->rePhaseToDevition($objFetch);

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
     * @param  \App\Models\Receivinglogentery  $receivinglogentery
     * @return \Illuminate\Http\Response
     */
    public function edit($receivinglogentery)
    {
        DB::beginTransaction();
        try {
            $document_type = 'receivinglogentries';
            $objFetch = Receivinglogentery::with(
                [
                    'Vendor:id,name,email,code',
                    'Attachment' => function ($q) use ($document_type) {
                        $q->where('document_name', $document_type);
                    }

                ]
            )->find($receivinglogentery);
            DB::commit();
            return response()->json([
                'success' => true,
                'objects' => $objFetch
            ], 200);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Receivinglogentery  $receivinglogentery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $receivinglogentery)
    {
        DB::beginTransaction();
        try {
            $FormObj = $this->GetForm($request);

            $obj = Receivinglogentery::find($receivinglogentery);
            $obj['division'] =  $FormObj['division'];
            $obj['vendor'] =  $FormObj['vendor'];
            $obj['amt_shipment'] =   $FormObj['amt_shipment'];
            $obj['container'] =  $FormObj['container'];
            $obj['po'] =  $FormObj['po'];
            $obj['etd_date'] =   $FormObj['etd_date'];
            $obj['eta_date'] =  $FormObj['eta_date'];
            $obj['est_eta_war_date'] =  $FormObj['est_eta_war_date'];
            $obj['actual_eta_war_date'] =  $FormObj['actual_eta_war_date'];
            $obj['tally_date'] =  $FormObj['tally_date'];
            $obj['sys_rec_date'] =   $FormObj['sys_rec_date'];
            $obj['appointment_no'] =   $FormObj['appointment_no'];
            $obj['trucker'] =  $FormObj['trucker'];
            $obj['carton'] =  $FormObj['carton'];
            $obj['wh_charge'] =   $FormObj['wh_charge'];
            $obj['miss'] =   $FormObj['miss'];
            $obj['pcs'] =  $FormObj['pcs'];
            $obj['status'] =  $FormObj['status'];
            $obj['current_note'] =  $FormObj['current_note'];
            $obj['status_note'] =   $FormObj['status_note'];
            $obj->save();


            // $storeObj = Receivinglogentery::where('id', $receivinglogentery)
            //     ->update($FormObj);

            DB::commit();
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'LOG ENTRY UPDATED SUCCESSFULLY',
                'data' => $obj,
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
     * @param  \App\Models\Receivinglogentery  $receivinglogentery
     * @return \Illuminate\Http\Response
     */
    public function destroy($receivinglogentery)
    {
        //
        DB::beginTransaction();
        try {
            $obj = Receivinglogentery::find($receivinglogentery);
            $obj->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Log Entry Successfully Deleted'
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

    public function getAttachments($id)
    {
        try {
            $objFetch = Attachment::where([
                ['document_auto_id', $id],
                ['document_name', '=', 'receivinglogentries']
            ])->get();
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

    public function rePhaseToDate($object)
    {
        $object->each(function ($item, $key) {
            $i =  $item->etd_date  = date("Y-m-d",  $item->etd_date);
            $i =  $item->eta_date  = date("Y-m-d",  $item->eta_date);
            $i =  $item->est_eta_war_date  = date("Y-m-d",  $item->est_eta_war_date);
            $i =  $item->actual_eta_war_date  = date("Y-m-d",  $item->actual_eta_war_date);
            $i =  $item->tally_date  = date("Y-m-d",  $item->tally_date);
            $i =  $item->sys_rec_date  = date("Y-m-d",  $item->sys_rec_date);
            return $i;
        });
    }

    public function rePhaseToDevition($object)
    {
        $object->each(function ($item, $key) {
            if ($item->division == 0) $i = $item->division = 'Pink rose';
            if ($item->division == 1) $i = $item->division = 'Olive & oak';
            if ($item->division == 2) $i = $item->division = 'Sage global';
            if ($item->division == 3) $i = $item->division = 'Hippie rose';

            return $i;
        });
    }

    public function GetForm(Request $request)
    {
        return $this->validate(
            $request,
            [
                'division'  => ['bail'],
                'vendor'  => ['bail'],
                'amt_shipment'  => ['bail'],
                'container'  => ['bail'],
                'po'  => ['bail'],
                'etd_date'  => ['bail'],
                'eta_date'  => ['bail'],
                'est_eta_war_date'  => ['bail'],
                'actual_eta_war_date'  => ['bail'],
                'tally_date'  => ['bail'],
                'sys_rec_date'  => ['bail'],
                'appointment_no'  => ['bail'],
                'trucker'  => ['bail'],
                'carton'  => ['bail'],
                'wh_charge'  => ['bail'],
                'miss'  => ['bail'],
                'pcs'  => ['bail'],
                'status'  => ['bail'],
                'current_note'  => ['bail'],
                'status_note'  => ['bail'],
                'attachment'  => ['bail'],
            ],
        );
    }
}
