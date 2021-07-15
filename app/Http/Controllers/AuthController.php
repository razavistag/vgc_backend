<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Customer;
use App\Models\Location;
use App\Models\Order;
use App\Models\Po;
use App\Models\User;
use App\Models\UserInformation;
use App\Models\Vendor;
use Carbon\Carbon;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function index()
    {

        try {
            // $objUser = User::with('AdditionalInformation')->orderby('id', 'desc')->paginate(20);
            $objUser = User::orderby('id', 'desc')->paginate(20);
            $this->rePhaseRole($objUser);


            return response()->json([
                'success' => true,
                'users' => $objUser
            ], 200);
        } catch (\Exception $e) {
            DevelopmentErrorLog($e->getMessage(), $e->getLine());
            return response()->json([
                'success' => false,
                'message' => 'PLEASE TRY AGAIN LATER',
            ], 500);
        }
    }
    public function dashboardStatment()
    {
        try {
            // ORDER RECEVIED
            $recevied = Order::select('status', 'order_type', DB::raw('COUNT(id) as order_count'))->where('status', 0)
                ->groupBy('order_type')
                ->get();

            $receviedBulk = $receviedRelase = $receviedDistiribute = 0;
            foreach ($recevied as $rec) {
                if ($rec->order_type == 1) $receviedRelase = $rec->order_count;
                elseif ($rec->order_type == 2) $receviedBulk = $rec->order_count;
                elseif ($rec->order_type == 3) $receviedDistiribute = $rec->order_count;
            }

            // ORDER WORKING
            $working = Order::select('status', 'order_type', DB::raw('COUNT(id) as order_count'))->where('status', 1)
                ->groupBy('order_type')
                ->get();

            $workingBulk = $workingRelase = $workingDistiribute = 0;
            foreach ($working as $rec) {
                if ($rec->order_type == 1) $workingRelase = $rec->order_count;
                elseif ($rec->order_type == 2) $workingBulk = $rec->order_count;
                elseif ($rec->order_type == 3) $workingDistiribute = $rec->order_count;
            }

            // ORDER COMPLETED
            $completed = Order::select('status', 'order_type', DB::raw('COUNT(id) as order_count'))->where('status', 2)
                ->groupBy('order_type')
                ->get();

            $completedBulk = $completedRelase = $completedDistiribute = 0;
            foreach ($completed as $rec) {
                if ($rec->order_type == 1) $completedRelase = $rec->order_count;
                elseif ($rec->order_type == 2) $completedBulk = $rec->order_count;
                elseif ($rec->order_type == 3) $completedDistiribute = $rec->order_count;
            }

            // ORDER REOPENED
            $reopened = Order::select('status', 'order_type', DB::raw('COUNT(id) as order_count'))->where('status', 4)
                ->groupBy('order_type')
                ->get();
            $reopenedBulk = $reopenedRelase = $reopenedDistiribute = 0;
            foreach ($reopened as $rec) {
                if ($rec->order_type == 1) $reopenedRelase = $rec->order_count;
                elseif ($rec->order_type == 2) $reopenedBulk = $rec->order_count;
                elseif ($rec->order_type == 3) $reopenedDistiribute = $rec->order_count;
            }

            // ORDER PENDING
            $pending = Order::select('status', 'order_type', DB::raw('COUNT(id) as order_count'))->where('status', 5)
                ->groupBy('order_type')
                ->get();
            $pendingBulk = $pendingRelase = $pendingDistiribute = 0;
            foreach ($pending as $rec) {
                if ($rec->order_type == 1) $pendingRelase = $rec->order_count;
                elseif ($rec->order_type == 2) $pendingBulk = $rec->order_count;
                elseif ($rec->order_type == 3) $pendingDistiribute = $rec->order_count;
            }

            // ORDER NEEDREVISED
            $needrevised = Order::select('status', 'order_type', DB::raw('COUNT(id) as order_count'))->where('status', 7)
                ->groupBy('order_type')
                ->get();
            $needrevisedBulk = $needrevisedRelase = $needrevisedDistiribute = 0;
            foreach ($needrevised as $rec) {
                if ($rec->order_type == 1) $needrevisedRelase = $rec->order_count;
                elseif ($rec->order_type == 2) $needrevisedBulk = $rec->order_count;
                elseif ($rec->order_type == 3) $needrevisedDistiribute = $rec->order_count;
            }

            // PO -----------------------------------------------------------------------------------------

            // PO REQUESTED
            $requested = Po::select('status', 'priority', DB::raw('COUNT(id) as order_count'))->where('status', 0)
                ->groupBy('priority')
                ->get();

            $requestedHigh = $requestedLow  = 0;
            foreach ($requested as $rec) {
                if ($rec->priority == 0) $requestedHigh = $rec->order_count;
                elseif ($rec->priority == 1) $requestedLow = $rec->order_count;
            }

            // PO WORKING
            $poWorking = Po::select('status', 'priority', DB::raw('COUNT(id) as order_count'))->where('status', 1)
                ->groupBy('priority')
                ->get();

            $poWorkingHigh = $poWorkingLow  = 0;
            foreach ($poWorking as $rec) {
                if ($rec->priority == 0) $poWorkingHigh = $rec->order_count;
                elseif ($rec->priority == 1) $poWorkingLow = $rec->order_count;
            }

            // PO COMPLETED
            $poCompleted = Po::select('status', 'priority', DB::raw('COUNT(id) as order_count'))->where('status', 2)
                ->groupBy('priority')
                ->get();

            $poCompletedHigh = $poCompletedLow  = 0;
            foreach ($poCompleted as $rec) {
                if ($rec->priority == 0) $poCompletedHigh = $rec->order_count;
                elseif ($rec->priority == 1) $poCompletedLow = $rec->order_count;
            }

            // PO REOPENED
            $poReopened = Po::select('status', 'priority', DB::raw('COUNT(id) as order_count'))->where('status', 3)
                ->groupBy('priority')
                ->get();

            $poReopeneddHigh = $poReopenedLow  = 0;
            foreach ($poReopened as $rec) {
                if ($rec->priority == 0) $poReopenedHigh = $rec->order_count;
                elseif ($rec->priority == 1) $poReopenedLow = $rec->order_count;
            }

            // PO PENDING
            $poPending = Po::select('status', 'priority', DB::raw('COUNT(id) as order_count'))->where('status', 4)
                ->groupBy('priority')
                ->get();

            $poPendingHigh = $poPendingLow  = 0;
            foreach ($poPending as $rec) {
                if ($rec->priority == 0) $poPendingHigh = $rec->order_count;
                elseif (
                    $rec->priority == 1
                ) $poPendingLow = $rec->order_count;
            }

            // PO APPROVED
            $poApproved = Po::select('status', 'priority', DB::raw('COUNT(id) as order_count'))->where('status', 7)
                ->groupBy('priority')
                ->get();

            $poApprovedHigh = $poApprovedLow  = 0;
            foreach ($poApproved as $rec) {
                if ($rec->priority == 0) $poApprovedHigh = $rec->order_count;
                elseif (
                    $rec->priority == 1
                ) $poApprovedLow = $rec->order_count;
            }


            return response()->json([
                'success' => true,
                'message' => 'Statement Updated',
                'orderStatment' =>  [
                    'recevied' => [
                        'Bulk' => $receviedBulk,
                        'Relase' => $receviedRelase,
                        'Distiribute' => $receviedDistiribute
                    ],
                    'working' => [
                        'Bulk' => $workingBulk,
                        'Relase' => $workingRelase,
                        'Distiribute' => $workingDistiribute
                    ],
                    'completed' => [
                        'Bulk' => $completedBulk,
                        'Relase' => $completedRelase,
                        'Distiribute' => $completedDistiribute
                    ],
                    'reopened' => [
                        'Bulk' => $reopenedBulk,
                        'Relase' => $reopenedRelase,
                        'Distiribute' => $reopenedDistiribute
                    ],
                    'pending' => [
                        'Bulk' => $pendingBulk,
                        'Relase' => $pendingRelase,
                        'Distiribute' => $pendingDistiribute
                    ],
                    'needrevised' => [
                        'Bulk' => $needrevisedBulk,
                        'Relase' => $needrevisedRelase,
                        'Distiribute' => $needrevisedDistiribute
                    ],
                ],
                'poStatment' => [
                    'requested' => [
                        'high' => $requestedHigh,
                        'low' => $requestedLow,
                    ],
                    'working' => [
                        'high' =>  $poWorkingHigh,
                        'low' => $poWorkingLow,
                    ],
                    'completed' => [
                        'high' => $poCompletedHigh,
                        'low' => $poCompletedLow,
                    ],
                    'reopened' => [
                        'high' => $poReopeneddHigh,
                        'low' => $poReopenedLow,
                    ],
                    'pending' => [
                        'high' => $poPendingHigh,
                        'low' => $poPendingLow,
                    ],
                    'approved' => [
                        'high' => $poApprovedHigh,
                        'low' => $poApprovedLow,

                    ],
                ]
            ], 200);
        } catch (\Exception $e) {
            DevelopmentErrorLog($e->getMessage(), $e->getLine());
            return response()->json([
                'success' => false,
                'message' => 'PLEASE TRY AGAIN LATER',
            ], 500);
        }
    }

    public function orderStatment()
    {
        try {
            // ORDER RECEVIED
            $recevied = Order::select('status', 'order_type', DB::raw('COUNT(id) as order_count'))->where('status', 0)
                ->groupBy('order_type')
                ->get();

            $receviedBulk = $receviedRelase = $receviedDistiribute = 0;
            foreach ($recevied as $rec) {
                if ($rec->order_type == 1) $receviedRelase = $rec->order_count;
                elseif ($rec->order_type == 2) $receviedBulk = $rec->order_count;
                elseif ($rec->order_type == 3) $receviedDistiribute = $rec->order_count;
            }

            // ORDER WORKING
            $working = Order::select('status', 'order_type', DB::raw('COUNT(id) as order_count'))->where('status', 1)
                ->groupBy('order_type')
                ->get();

            $workingBulk = $workingRelase = $workingDistiribute = 0;
            foreach ($working as $rec) {
                if ($rec->order_type == 1) $workingRelase = $rec->order_count;
                elseif ($rec->order_type == 2) $workingBulk = $rec->order_count;
                elseif ($rec->order_type == 3) $workingDistiribute = $rec->order_count;
            }

            // ORDER COMPLETED
            $completed = Order::select('status', 'order_type', DB::raw('COUNT(id) as order_count'))->where('status', 2)
                ->groupBy('order_type')
                ->get();

            $completedBulk = $completedRelase = $completedDistiribute = 0;
            foreach ($completed as $rec) {
                if ($rec->order_type == 1) $completedRelase = $rec->order_count;
                elseif ($rec->order_type == 2) $completedBulk = $rec->order_count;
                elseif ($rec->order_type == 3) $completedDistiribute = $rec->order_count;
            }

            // ORDER REOPENED
            $reopened = Order::select('status', 'order_type', DB::raw('COUNT(id) as order_count'))->where('status', 4)
                ->groupBy('order_type')
                ->get();
            $reopenedBulk = $reopenedRelase = $reopenedDistiribute = 0;
            foreach ($reopened as $rec) {
                if ($rec->order_type == 1) $reopenedRelase = $rec->order_count;
                elseif ($rec->order_type == 2) $reopenedBulk = $rec->order_count;
                elseif ($rec->order_type == 3) $reopenedDistiribute = $rec->order_count;
            }

            // ORDER PENDING
            $pending = Order::select('status', 'order_type', DB::raw('COUNT(id) as order_count'))->where('status', 5)
                ->groupBy('order_type')
                ->get();
            $pendingBulk = $pendingRelase = $pendingDistiribute = 0;
            foreach ($pending as $rec) {
                if ($rec->order_type == 1) $pendingRelase = $rec->order_count;
                elseif ($rec->order_type == 2) $pendingBulk = $rec->order_count;
                elseif ($rec->order_type == 3) $pendingDistiribute = $rec->order_count;
            }

            // ORDER NEEDREVISED
            $needrevised = Order::select('status', 'order_type', DB::raw('COUNT(id) as order_count'))->where('status', 7)
                ->groupBy('order_type')
                ->get();
            $needrevisedBulk = $needrevisedRelase = $needrevisedDistiribute = 0;
            foreach ($needrevised as $rec) {
                if ($rec->order_type == 1) $needrevisedRelase = $rec->order_count;
                elseif ($rec->order_type == 2) $needrevisedBulk = $rec->order_count;
                elseif ($rec->order_type == 3) $needrevisedDistiribute = $rec->order_count;
            }



            return response()->json([
                'success' => true,
                'message' => 'Statement Updated',
                'orderStatment' =>  [
                    'recevied' => [
                        'Bulk' => $receviedBulk,
                        'Relase' => $receviedRelase,
                        'Distiribute' => $receviedDistiribute
                    ],
                    'working' => [
                        'Bulk' => $workingBulk,
                        'Relase' => $workingRelase,
                        'Distiribute' => $workingDistiribute
                    ],
                    'completed' => [
                        'Bulk' => $completedBulk,
                        'Relase' => $completedRelase,
                        'Distiribute' => $completedDistiribute
                    ],
                    'reopened' => [
                        'Bulk' => $reopenedBulk,
                        'Relase' => $reopenedRelase,
                        'Distiribute' => $reopenedDistiribute
                    ],
                    'pending' => [
                        'Bulk' => $pendingBulk,
                        'Relase' => $pendingRelase,
                        'Distiribute' => $pendingDistiribute
                    ],
                    'needrevised' => [
                        'Bulk' => $needrevisedBulk,
                        'Relase' => $needrevisedRelase,
                        'Distiribute' => $needrevisedDistiribute
                    ],
                ],

            ], 200);
        } catch (\Exception $e) {

            DevelopmentErrorLog($e->getMessage(), $e->getLine());
            return response()->json([
                'success' => false,
                'message' => 'PLEASE TRY AGAIN LATER',
            ], 500);
        }
    }
    public function poStatment()
    {
        try {
            // PO REQUESTED
            $requested = Po::select('status', 'priority', DB::raw('COUNT(id) as order_count'))->where('status', 0)
                ->groupBy('priority')
                ->get();

            $requestedHigh = $requestedLow  = 0;
            foreach ($requested as $rec) {
                if ($rec->priority == 0) $requestedHigh = $rec->order_count;
                elseif ($rec->priority == 1) $requestedLow = $rec->order_count;
            }

            // PO WORKING
            $poWorking = Po::select('status', 'priority', DB::raw('COUNT(id) as order_count'))->where('status', 1)
                ->groupBy('priority')
                ->get();

            $poWorkingHigh = $poWorkingLow  = 0;
            foreach ($poWorking as $rec) {
                if ($rec->priority == 0) $poWorkingHigh = $rec->order_count;
                elseif ($rec->priority == 1) $poWorkingLow = $rec->order_count;
            }

            // PO COMPLETED
            $poCompleted = Po::select('status', 'priority', DB::raw('COUNT(id) as order_count'))->where('status', 2)
                ->groupBy('priority')
                ->get();

            $poCompletedHigh = $poCompletedLow  = 0;
            foreach ($poCompleted as $rec) {
                if ($rec->priority == 0) $poCompletedHigh = $rec->order_count;
                elseif ($rec->priority == 1) $poCompletedLow = $rec->order_count;
            }

            // PO REOPENED
            $poReopened = Po::select('status', 'priority', DB::raw('COUNT(id) as order_count'))->where('status', 3)
                ->groupBy('priority')
                ->get();

            $poReopeneddHigh = $poReopenedLow  = 0;
            foreach ($poReopened as $rec) {
                if ($rec->priority == 0) $poReopenedHigh = $rec->order_count;
                elseif ($rec->priority == 1) $poReopenedLow = $rec->order_count;
            }

            // PO PENDING
            $poPending = Po::select('status', 'priority', DB::raw('COUNT(id) as order_count'))->where('status', 4)
                ->groupBy('priority')
                ->get();

            $poPendingHigh = $poPendingLow  = 0;
            foreach ($poPending as $rec) {
                if ($rec->priority == 0) $poPendingHigh = $rec->order_count;
                elseif (
                    $rec->priority == 1
                ) $poPendingLow = $rec->order_count;
            }

            // PO APPROVED
            $poApproved = Po::select('status', 'priority', DB::raw('COUNT(id) as order_count'))->where('status', 7)
                ->groupBy('priority')
                ->get();

            $poApprovedHigh = $poApprovedLow  = 0;
            foreach ($poApproved as $rec) {
                if ($rec->priority == 0) $poApprovedHigh = $rec->order_count;
                elseif (
                    $rec->priority == 1
                ) $poApprovedLow = $rec->order_count;
            }


            return response()->json([
                'success' => true,
                'message' => 'Statement Updated',
                'poStatment' => [
                    'requested' => [
                        'high' => $requestedHigh,
                        'low' => $requestedLow,
                    ],
                    'working' => [
                        'high' =>  $poWorkingHigh,
                        'low' => $poWorkingLow,
                    ],
                    'completed' => [
                        'high' => $poCompletedHigh,
                        'low' => $poCompletedLow,
                    ],
                    'reopened' => [
                        'high' => $poReopeneddHigh,
                        'low' => $poReopenedLow,
                    ],
                    'pending' => [
                        'high' => $poPendingHigh,
                        'low' => $poPendingLow,
                    ],
                    'approved' => [
                        'high' => $poApprovedHigh,
                        'low' => $poApprovedLow,

                    ],
                ],

            ], 200);
        } catch (\Exception $e) {
            DevelopmentErrorLog($e->getMessage(), $e->getLine());
            return response()->json([
                'success' => false,
                'message' => 'PLEASE TRY AGAIN LATER',
            ], 500);
        }
    }

    public function mailList()
    {
        try {
            // $objects = User::select('id', 'name', 'email')->where(function ($query) {
            //     $query->where('user_type', '!=', 1); // NOT CUSTOMER
            //     $query->where('user_type', '!=', 2); // NOT VENDOR
            //     $query->where('user_type', '!=', 3); // NOT SUPPLIER
            // })->get();

            $objects = User::select('id', 'name', 'email')->get();
            return response()->json([
                'success' => true,
                'objects' => $objects
            ]);
        } catch (\Exception $e) {
            DevelopmentErrorLog($e->getMessage(), $e->getLine());

            return response()->json([
                'success' => false,
                'message' => 'PLEASE TRY AGAIN LATER',
            ], 500);
        }
    }
    public function gustRegister(Request $request)
    {
        DB::beginTransaction();
        try {
            $FormObj = $this->GetForm($request);
            $FormObj['password'] = bcrypt($FormObj['password']);
            $FormObj['access'] = json_encode($FormObj['access']);
            $storeObj =  User::create($FormObj);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'req' =>
                $FormObj,
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
    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            $FormObj = $this->GetForm($request);

            // CUSTOMER
            if ($FormObj['user_type'] == 1) {
                Customer::create(
                    [
                        'name' => $FormObj['name'],
                        'email' => $FormObj['email'],
                        'phone' => $FormObj['phone'],
                        'address' => $FormObj['address'],
                    ]
                );
            }
            // VENDOR
            if ($FormObj['user_type'] == 2) {
                $getLastID = User::take('1')->orderby('id', 'desc')->first();
                Vendor::create(
                    [
                        'address' => $FormObj['name'],
                        'code' => 'VE/' . $getLastID['id'],
                        'contact' => $FormObj['phone'],
                        'email' => $FormObj['email'],
                        'name' => $FormObj['name'],
                        'agent_auto_id' => $getLastID['id'],
                    ]
                );
            }


            // AGENT / SUPPLIER
            if ($FormObj['user_type'] == 3) {
                $getLastID = User::take('1')->orderby('id', 'desc')->first();
                Agent::create(
                    [
                        'agent_name' => $FormObj['name'],
                        'agent_code' => 'AG/' . $getLastID['id'],
                        'agent_email' => $FormObj['email'],

                    ]
                );
            }

            $FormObj['password'] = bcrypt($FormObj['password']);
            $FormObj['access'] = json_encode($FormObj['access']);
            $FormObj['name'] = ucfirst($FormObj['name']);


            $now = Carbon::now()->timestamp;
            if ($request->input('profilePic')) {
                $image_string = $request->input('profilePic');
                preg_match("/data:image\/(.*?);/", $image_string, $image_extension);
                $image_string = preg_replace('/data:image\/(.*?);base64,/', '', $image_string);
                $image_string = str_replace(' ', '+', $image_string);
                $image_name_string  = rand(10, 1000) . '_' . $now . '_' . 'image_' . rand(10, 1000) . '.' . $image_extension[1];
                Storage::disk('public')->put($image_name_string, base64_decode($image_string));
                $FormObj['profilePic'] = $image_name_string;
            }
            $storeObj =  User::create($FormObj);

            if ($FormObj['withInfo'] != 0) {
                $userID = User::take('1')->orderby('id', 'desc')->first();
                if ($userID) {
                    $userID = $userID->id;
                } else {
                    $userID = 1;
                }
                $storeObj_addtional =  UserInformation::create(
                    [
                        'user_id' => $userID,
                        'name' => $FormObj['withInfo']['name'],
                        'contact_person' => $FormObj['withInfo']['contact_person'],
                        'contact_number' => $FormObj['withInfo']['contact_number'],
                        'email' => $FormObj['withInfo']['email'],
                        'address' => $FormObj['withInfo']['address'],
                        'city' => $FormObj['withInfo']['city']['id'],
                        'zip_code' => $FormObj['withInfo']['zip_code'],
                        'country' => $FormObj['withInfo']['country']['id'],
                    ]
                );
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
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


    //
    // PROFILE UPDATE
    //

    public function profileUpdate(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $FormObj = $request->all();
            $storeObj = User::where('id', $id)
                ->update($FormObj);
            DB::commit();

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Profile updated successfully',
                'req' => $FormObj,
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

    //
    // password update
    //
    public function passwordUpdate(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $FormObj = $request->all();
            $hashedPassword = Auth::user()->password;

            if (Hash::check($FormObj['currentPassword'], $hashedPassword)) {
                if (!Hash::check($FormObj['confirmPassword'], $hashedPassword)) {
                    $users = User::find(Auth::user()->id);
                    $users->password = bcrypt($FormObj['confirmPassword']);
                    User::where('id', Auth::user()->id)->update(['password' =>  $users->password]);

                    DB::commit();
                    return response()->json([
                        'success' => true,
                        'status' => 200,
                        'message' => 'password has been updated successfully',

                    ], 200);
                } else {
                    DB::commit();
                    return response()->json([
                        'success' => true,
                        'status' => 200,
                        'message' => 'new password can not be the old password',

                    ], 401);
                }
            } else {
                DB::commit();
                return response()->json([
                    'success' => true,
                    'status' => 200,
                    'message' => 'current password is not matched',

                ], 401);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            DevelopmentErrorLog($e->getMessage(), $e->getLine());

            return response()->json([
                'success' => false,
                'message' => 'PLEASE TRY AGAIN LATER',
            ], 500);
        }
    }

    //
    // profile image update
    //
    public function profileImageUpdate(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $FormObj = $this->GetForm($request);
            $obj = User::find($id);
            $now = Carbon::now()->timestamp;
            if ($request->input('profilePic')) {
                $image_string = $request->input('profilePic');
                preg_match("/data:image\/(.*?);/", $image_string, $image_extension);
                $image_string = preg_replace('/data:image\/(.*?);base64,/', '', $image_string);
                $image_string = str_replace(' ', '+', $image_string);
                $image_name_string  = rand(10, 1000) . '_' . $now . '_' . 'image_' . rand(10, 1000) . '.' . $image_extension[1];
                Storage::disk('public')->put($image_name_string, base64_decode($image_string));
                $obj['profilePic'] = $image_name_string;
            }
            $obj->save();
            $user = $obj;
            DB::commit();

            return response()->json([
                'success' => true,
                'user_information' => ['id' => $user->id, 'name' => $user->name, 'phone' => $user->phone, 'profile' => $user->profilePic, 'role' => $user->role],
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

    //
    // UPDATE User Account
    //
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $FormObj = $this->GetForm($request);

            // return $FormObj;
            $obj = User::find($id);
            $obj['access'] = json_encode($FormObj['access']);
            $obj['account_number'] = $FormObj['account_number'];
            $obj['address'] = $FormObj['address'];
            $obj['attempts'] = $FormObj['attempts'];
            $obj['balance'] = $FormObj['balance'];
            $obj['basic_salary'] = $FormObj['basic_salary'];
            $obj['city'] = $FormObj['city'];
            $obj['company'] = $FormObj['company'];
            $obj['credit_limit'] = $FormObj['credit_limit'];
            $obj['dob'] = $FormObj['dob'];
            $obj['email'] = $FormObj['email'];
            // $obj['facebook_id'] = $FormObj['facebook_id'];
            // $obj['twitter_id'] = $FormObj['twitter_id'];
            // $obj['google_id'] = $FormObj['google_id'];
            $obj['gender'] = $FormObj['gender'];
            $obj['language'] = $FormObj['language'];
            $obj['location'] = $FormObj['location'];
            $obj['monthly_target'] = $FormObj['monthly_target'];
            $obj['name'] = ucfirst($FormObj['name']);
            $obj['nic'] = $FormObj['nic'];
            $obj['opening_balance'] = $FormObj['opening_balance'];
            $obj['payment_terms'] = $FormObj['payment_terms'];
            $obj['phone'] = $FormObj['phone'];
            $obj['role'] = $FormObj['role'];
            $obj['sales_rep_id'] = $FormObj['sales_rep_id'];
            $obj['status'] = $FormObj['status'];
            $obj['target_percentage'] = $FormObj['target_percentage'];
            $obj['user_type'] = $FormObj['user_type'];
            $obj['zip'] = $FormObj['zip'];

            $now = Carbon::now()->timestamp;
            if ($request->input('profilePic')) {
                $image_string = $request->input('profilePic');
                preg_match("/data:image\/(.*?);/", $image_string, $image_extension);
                $image_string = preg_replace('/data:image\/(.*?);base64,/', '', $image_string);
                $image_string = str_replace(' ', '+', $image_string);
                $image_name_string  = rand(10, 1000) . '_' . $now . '_' . 'image_' . rand(10, 1000) . '.' . $image_extension[1];
                Storage::disk('public')->put($image_name_string, base64_decode($image_string));
                $obj['profilePic'] = $image_name_string;
            }
            $obj->save();

            if ($FormObj['withInfo'] != 0) {
                $addtional_info =  UserInformation::where('user_id', $id)->get();
                if (count(($addtional_info)) < 1) {
                    $storeObj_addtional =  UserInformation::create(
                        [
                            'user_id' => $id,
                            'name' => $FormObj['withInfo']['name'],
                            'contact_person' => $FormObj['withInfo']['contact_person'],
                            'contact_number' => $FormObj['withInfo']['contact_number'],
                            'email' => $FormObj['withInfo']['email'],
                            'address' => $FormObj['withInfo']['address'],
                            'city' => $FormObj['withInfo']['city']['id'],
                            'zip_code' => $FormObj['withInfo']['zip_code'],
                            'country' => $FormObj['withInfo']['country']['id'],
                        ]
                    );
                } else {
                    $storeObj_addtional =  UserInformation::where('user_id', $id)->update(
                        [

                            'name' => $FormObj['withInfo']['name'],
                            'contact_person' => $FormObj['withInfo']['contact_person'],
                            'contact_number' => $FormObj['withInfo']['contact_number'],
                            'email' => $FormObj['withInfo']['email'],
                            'address' => $FormObj['withInfo']['address'],
                            'city' => $FormObj['withInfo']['city']['id'],
                            'zip_code' => $FormObj['withInfo']['zip_code'],
                            'country' => $FormObj['withInfo']['country']['id'],

                        ]
                    );
                }
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'foundedData' => $obj,
                // '$storeObj_addtional ' =>  $storeObj_addtional,
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

    //
    // SHOW User Account
    //
    public function show($id)
    {
        try {
            $objUser = User::with('City', 'Location', 'AdditionalInformation.city', 'AdditionalInformation.country')->find($id);
            return response()->json([
                'success' => true,
                'selected_user' => $objUser
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
     * User Login.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        DB::beginTransaction();
        try {

            // $this->reduceAttempt($request->email);

            // ORDER Login Request Validation
            $this->validate(
                $request,
                [
                    'email' =>  ['required', 'email'],
                    'password' =>  ['required', 'min:6'],
                ],
                [
                    'email.required' => 'Email address is required',
                    'password.required' => 'Password is required',
                ]
            );

            //  Request of email and password
            $credentials = request(['email', 'password']);
            // Checking credentials and reduce attempt value by 1
            if (!Auth::attempt($credentials)) {
                $this->reduceAttempt($request->email);
                return response()->json([
                    'message' => 'Unauthorized access',
                    'Unauthorized' => true,
                ]);
            }


            // ORDER Getting & Storing Access Token
            $user = $request->user();

            if ($user->status == 0) {
                return response()->json([
                    'pending' => true,
                    'message' => 'Account on pending process',

                ], 200);
            }

            if ($user->attempts <= 0) {
                return response()->json([
                    'attempts' => true,
                    'message' => 'You have reached the maximum login attempts. Please contact us for re-activate your account',
                ], 401);
            }

            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'user_information' => ['id' => $user->id, 'name' => $user->name, 'phone' => $user->phone, 'profile' => $user->profilePic, 'role' => $user->role],
                'message' => 'User Logged-in successfully',
                'user_access' => $user->access,
                'user_access_url' => $user->access_url,
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()

            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            DevelopmentErrorLog($e->getMessage(), $e->getLine());
            return response()->json([
                'success' => false,
                'help' => 'CHECK AUTH CONFIGURATION',
                'message' => 'PLEASE TRY AGAIN LATER',
            ], 500);
        }
    }

    public function reduceAttempt($email)
    {
        User::where('email',  $email)->update(['attempts' => 1]);
        return  $email;
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();
            return response()->json([
                'message' => 'Successfully logged out'
            ]);
        } catch (\Exception $e) {
            DevelopmentErrorLog($e->getMessage(), $e->getLine());
            return response()->json([
                'success' => false,
                'message' => 'PLEASE TRY AGAIN LATER',
            ], 500);
        }
    }

    public function search($find)
    {
        try {
            $objUser = User::orderby('id', 'desc')
                ->where('name', 'like', '%' . $find . '%')
                ->orWhere('phone', 'like', '%' . $find . '%')
                ->get();

            $this->rePhaseRole($objUser);


            return response()->json([
                'success' => true,
                'users' => $objUser
            ], 200);
        } catch (\Exception $e) {
            DevelopmentErrorLog($e->getMessage(), $e->getLine());
            return response()->json([
                'success' => false,
                'message' => 'PLEASE TRY AGAIN LATER',
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $obj = User::find($id);
            $obj->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User Successfully Deleted'
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

    public function get_ac_city_additional($find)
    {
        try {
            $objFetch = Location::where('location_city',  'like', '%' . $find . '%')->get();
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

    public function get_ac_country_additional($find)
    {
        try {
            $objFetch = Location::where('location_name',  'like', '%' . $find . '%')->get();
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

    public function rePhaseRole($object)
    {
        $object->each(function ($item, $key) {

            if ($item->role == 0) $i = $item->role = 'CLIENT';
            if ($item->role == 1) $i = $item->role = 'SUPER ADMIN';
            if ($item->role == 2) $i = $item->role = 'ADMIN';
            if ($item->role == 3) $i = $item->role = 'MANAGER';
            if ($item->role == 4) $i = $item->role = 'CASHIER';
            if ($item->role == 5) $i = $item->role = 'SALES REP';
            if ($item->role == 6) $i = $item->role = 'EMPLOYEE';
            if ($item->role == 7) $i = $item->role = 'MARKETING TEAM';
            return $i;
        });
    }

    public function GetForm(Request $request)
    {
        return $this->validate(
            $request,
            [
                'name'  => ['bail'],
                'email' => ['bail'],
                'password' => ['bail'],
                'company' => ['bail'],
                'phone' => ['bail'],
                'address' => ['bail'],
                'nic' => ['bail'],
                'gender' => ['bail'],
                'attempts' => ['bail'],
                'google_id' => ['bail'],
                'facebook_id' => ['bail'],
                'twitter_id' => ['bail'],
                'profilePic' => ['bail'],
                'access' => ['bail'],
                'access_url' => ['bail'],
                'status' => ['bail'],
                'role' => ['bail'],
                'dob' => ['bail'],
                'language' => ['bail'],
                'city' => ['bail'],
                'location' => ['bail'],
                'zip' => ['bail'],
                'account_number' => ['bail'],
                'user_type' => ['bail'], // ORDER CUSTOMER  OR VENDOR OR SUPPLIER
                'opening_balance' => ['bail'],
                'balance' => ['bail'],
                'credit_limit' => ['bail'],
                'payment_terms' => ['bail'],  // ORDER ?
                'sales_rep_id' => ['bail'], // ORDER ?
                'basic_salary' => ['bail'],
                'monthly_target' => ['bail'],
                'target_percentage' => ['bail'],
                'withInfo' => ['bail'],
            ],
        );
    }
}
