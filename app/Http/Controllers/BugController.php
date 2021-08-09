<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BugController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ELQ_GET = Bug::orderBy('id', 'desc')
        ->get();

        $QB_GET = DB::table('bugs')
        ->joinSub('select id as user_id, name as user_name, email as user_email, phone as user_phone from users', 'users', function ($q) {
            $q->on('bugs.user_id', '=', 'users.user_id');
        })
            ->get();

        return response()->json([
            'QB_GET' => $QB_GET,
            'ELQ_GET' => $ELQ_GET,

        ]);
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
            $FormObj['user_id'] = Auth::user()->id;
            $FormObj['status'] = 0;

            $img_array = [];
            $now = Carbon::now()->timestamp;
            if (isset($FormObj['images'][0]['screenShot'])) {
                $image_string = $FormObj['images'][0]['screenShot'];
                preg_match("/data:image\/(.*?);/", $image_string, $image_extension);
                $image_string = preg_replace('/data:image\/(.*?);base64,/', '', $image_string);
                $image_string = str_replace(' ', '+', $image_string);
                $image_name_string  = 'bug_screenshot' . rand(10, 1000) . '_' . $now . '_' . 'image_' . rand(10, 1000) . '.' . $image_extension[1];
                Storage::disk('public')->put($image_name_string, base64_decode($image_string));
                array_push($img_array, $image_name_string);
            }

            if (isset($FormObj['images'][0]['addedImages'])) {
                foreach ($FormObj['images'][0]['addedImages'] as $k => $i) {
                    $image_string = $i;
                    preg_match("/data:image\/(.*?);/", $image_string, $image_extension);
                    $image_string = preg_replace('/data:image\/(.*?);base64,/', '', $image_string);
                    $image_string = str_replace(' ', '+', $image_string); //
                    $image_name_string  = 'bug_added_images' . rand(10, 1000) . '_' . $now . '_' . 'image_' . rand(10, 1000) . '.' . $image_extension[1];
                    Storage::disk('public')->put($image_name_string, base64_decode($image_string));
                    array_push($img_array, $image_name_string);
                }
            }

            $FormObj['images'] = $img_array;
            $storeObj =  Bug::create($FormObj);
            DB::commit();
            return response()->json([
                'return' => $FormObj,
                'storeObj' => $storeObj,
                'image_json' => json_encode($FormObj['images'])
            ]);
        } catch (\Exception $e) {
            DevelopmentErrorLog($e->getMessage(), $e->getLine());
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Please try again later. Bug Capture not working',
                'error' => [
                    $e->getMessage(), $e->getLine()
                ],
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bug  $bug
     * @return \Illuminate\Http\Response
     */
    public function show(Bug $bug)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bug  $bug
     * @return \Illuminate\Http\Response
     */
    public function edit(Bug $bug)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bug  $bug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bug $bug)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bug  $bug
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bug $bug)
    {
        //
    }


    public function GetForm(Request $request)
    {
        return $this->validate(
            $request,
            [
                'priority' => ['required'],
                'type' =>  ['required'],
                'message' =>  ['required'],
                'images' =>  ['required'],
            ],
            [
                'priority.required' => 'priority is required',
                'type.required' => 'type is required',
                'message.required' => 'message is required',
                'images.required' => 'images are required',
            ]
        );
    }
}
