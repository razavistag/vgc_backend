<?php

namespace App\Http\Controllers;

use App\Mail\commentMail;
use App\Models\Comment;
use App\Models\Order;
use App\Models\Po;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
            if ($request->operation == 'ORDER#') {
                $status = ' Received this ';
                $documentID =  Order::take('1')->orderby('id', 'desc')->first();
                if ($documentID) {
                    $documentID = $documentID->id + 1;
                } else {
                    $documentID = 1;
                }
            }

            if ($request->operation == 'PO#') {
                $status = ' Requested this  ';
                $documentID =  Po::take('1')->orderby('id', 'desc')->first();
                if ($documentID) {
                    $documentID = $documentID->id + 1;
                } else {
                    $documentID = 1;
                }
            }

            $user = Auth::user();
            $time = time();

            $storeObj =  Comment::create(
                [
                    'type_id' => 0,
                    'document_id' => $documentID,
                    'document_status' => $request->status,
                    'hrm_auto_id' => $user->id,
                    'email_add' => null,
                    'hrm_name' => $user->name,
                    'is_read' => 0,
                    'is_send_email' => 0,
                    'current_time' => $time,
                    'comment' => $user->name . $status . $request->operation . $documentID . ' on ' . date("D Y-m-d h:i:s A", $time),
                ]
            );
        } catch (\Exception $e) {
            DB::rollBack();
            DevelopmentErrorLog($e->getMessage(), $e->getLine());
            return response()->json([
                'success' => false,
                'message' => 'PLEASE TRY AGAIN LATER',
            ], 500);
        }
    }

    public function sendMessage(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $time = time();
            if ($request->mailList) {
                $mailList = json_encode($request->mailList);
                $mailBox = $request->mailList;
            } else {
                $mailList = null;
            }
            $storeObj =  Comment::create(
                [
                    'type_id' => 0,
                    'document_id' => $request->data_id['id'],
                    'document_status' =>  $request->data_id['status'],
                    'hrm_auto_id' => $user->id,
                    'email_add' => $mailList,
                    'hrm_name' => $user->name,
                    'is_read' => 0,
                    'is_send_email' => 1,
                    'current_time' => $time,
                    'comment' => $request->message,
                ]
            );

            if (isset($mailBox)) {

                foreach ($mailBox as $i) {
                    Mail::send(new commentMail(['object' => $storeObj, 'emailTo' => $i, 'comment' => $request->message]));
                }
            }


            $getMessage = $this->show($request->data_id['id']);
            DB::commit();
            return response()->json([
                'req' => $request->all(),
                'succcess' => true,
                'objects' => collect($getMessage->original['objects'])
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
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $objects = Comment::with('user:id,name,profilePic')
                ->where('document_id', $id)
                ->orderBy('id', 'desc')
                ->limit(6)->get();
            $objects->each(function ($item, $key) {
                if ($item->is_read == 0) return $item->is_read = 'Mark as read';
                if ($item->is_read == 1) return $item->is_read = 'Mark as unread';
            });
            $objects->each(function ($item, $key) {
                return $item->current_time  = date("D Y-m-d h:i:s A",  $item->current_time);
            });

            return response()->json([
                'succcess' => true,
                'objects' => $objects,
                'status' => 200
            ]);
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
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    public function order_status($status, $document_id, $operation)
    {
        $user = Auth::user();
        $time = time();
        if ($status == 0) {
            $status  = 'Received';
        }
        if ($status == 1) {
            $status  = 'Working';
        }
        if ($status == 2) {
            $status  = 'Completed';
        }
        if ($status == 3) {
            $status  = 'Approved';
        }
        if ($status == 4) {
            $status  = 'Re-opend';
        }
        if ($status == 5) {
            $status  = 'Pending';
        }
        if ($status == 6) {
            $status  = 'Canceled';
        }
        if ($status == 7) {
            $status  = 'Need revised';
        }
        if ($status == 8) {
            $status  = 'Pull stock';
        }
        $oldStatus = Comment::select('document_status')->take(1)->where('document_id', $document_id)->orderby('id', 'desc')->first();
        $setStatus = '';
        if ($oldStatus['document_status'] == 0) {
            $setStatus  = 'Received';
        }
        if ($oldStatus['document_status'] == 1) {
            $setStatus  = 'Working';
        }
        if ($oldStatus['document_status'] == 2) {
            $setStatus  = 'Completed';
        }
        if ($oldStatus['document_status'] == 3) {
            $setStatus  = 'Approved';
        }
        if ($oldStatus['document_status'] == 4) {
            $setStatus = 'Re-opend';
        }
        if ($oldStatus['document_status'] == 5) {
            $setStatus  = 'Pending';
        }
        if ($oldStatus['document_status'] == 6) {
            $setStatus  = 'Canceled';
        }
        if ($oldStatus['document_status'] == 7) {
            $setStatus  = 'Need revised';
        }
        if ($oldStatus['document_status'] == 8) {
            $setStatus  = 'Pull stock';
        }
        $message = $user->name . ' Changed this ' . $operation . ' from ' . $setStatus . ' to ' . $status . ' on ' . date("D Y-m-d h:i:s A", $time);

        return $message;
    }

    public function po_status($status, $document_id, $operation)
    {
        $user = Auth::user();
        $time = time();
        if ($status == 0) {
            $status  = 'Requested';
        }
        if ($status == 1) {
            $status  = 'Working';
        }
        if ($status == 2) {
            $status  = 'Completed';
        }
        if ($status == 3) {
            $status  = 'Reopend';
        }
        if ($status == 4) {
            $status  = 'Pending';
        }
        if ($status == 5) {
            $status  = 'Approved ord';
        }
        if ($status == 6) {
            $status  = 'Approved pro';
        }
        if ($status == 7) {
            $status  = 'Approved';
        }
        if ($status == 8) {
            $status  = 'Close';
        }
        if ($status == 9) {
            $status  = 'Canceled';
        }
        $oldStatus = Comment::select('document_status')->take(1)->where('document_id', $document_id)->orderby('id', 'desc')->first();
        $setStatus = '';
        if ($oldStatus['document_status'] == 0) {
            $setStatus  = 'Requested';
        }
        if ($oldStatus['document_status'] == 1) {
            $setStatus  = 'Working';
        }
        if ($oldStatus['document_status'] == 2) {
            $setStatus  = 'Completed';
        }
        if ($oldStatus['document_status'] == 3) {
            $setStatus  = 'Reopend';
        }
        if ($oldStatus['document_status'] == 4) {
            $setStatus = 'Pending';
        }
        if ($oldStatus['document_status'] == 5) {
            $setStatus  = 'Approved ord';
        }
        if ($oldStatus['document_status'] == 6) {
            $setStatus  = 'Approved pro';
        }
        if ($oldStatus['document_status'] == 7) {
            $setStatus  = 'Approved';
        }
        if ($oldStatus['document_status'] == 8) {
            $setStatus  = 'Close';
        }
        if ($oldStatus['document_status'] == 9) {
            $setStatus  = 'Canceled';
        }

        $message = $user->name . ' Changed this ' . $operation . ' from ' . $setStatus . ' to ' . $status . ' on ' . date("D Y-m-d h:i:s A", $time);

        return $message;
    }

    public function mark_read(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $obj = Comment::find($id);
            if ($request->is_read == 'Mark as read') {
                $obj->is_read = 1;
            }
            if ($request->is_read == 'Mark as unread') {
                $obj->is_read = 0;
            }
            $obj->save();
            // return  [$request->is_read, $obj];
            DB::commit();
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'read information updated',
                // 'data' => $storeObj
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $time = time();
            if ($request->statusMood == 'order_status') {
                $message =  $this->order_status($request->status, $request->id, $request->operation);
            }
            if ($request->statusMood == 'po_status') {
                $message =  $this->po_status($request->status, $request->id, $request->operation);
            }
            $storeObj =  Comment::create(
                [
                    'type_id' => 0,
                    'document_id' => $request->id,
                    'document_status' => $request->status,
                    'hrm_auto_id' => $user->id,
                    'email_add' => null,
                    'hrm_name' => $user->name,
                    'is_read' => 0,
                    'is_send_email' => 0,
                    'current_time' => $time,
                    'comment' => $message,
                ]
            );
            DB::commit();
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
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
        // GET CURRENT TIMESTEMP
        // $t = time();
        // echo ($t . "<br>");
        // echo (date("D Y-m-d h:i:s A", $t));

        // OUTPUT
        // 1624643750
        // Fri 2021-06-25 05:55:50 PM

        // d - The day of the month (from 01 to 31)
        // D - A textual representation of a day (three letters)
        // j - The day of the month without leading zeros (1 to 31)
        // l (lowercase 'L') - A full textual representation of a day
        // N - The ISO-8601 numeric representation of a day (1 for Monday, 7 for Sunday)
        // S - The English ordinal suffix for the day of the month (2 characters st, nd, rd or th. Works well with j)
        // w - A numeric representation of the day (0 for Sunday, 6 for Saturday)
        // z - The day of the year (from 0 through 365)
        // W - The ISO-8601 week number of year (weeks starting on Monday)
        // F - A full textual representation of a month (January through December)
        // m - A numeric representation of a month (from 01 to 12)
        // M - A short textual representation of a month (three letters)
        // n - A numeric representation of a month, without leading zeros (1 to 12)
        // t - The number of days in the given month
        // L - Whether it's a leap year (1 if it is a leap year, 0 otherwise)
        // o - The ISO-8601 year number
        // Y - A four digit representation of a year
        // y - A two digit representation of a year
        // a - Lowercase am or pm
        // A - Uppercase AM or PM
        // B - Swatch Internet time (000 to 999)
        // g - 12-hour format of an hour (1 to 12)
        // G - 24-hour format of an hour (0 to 23)
        // h - 12-hour format of an hour (01 to 12)
        // H - 24-hour format of an hour (00 to 23)
        // i - Minutes with leading zeros (00 to 59)
        // s - Seconds, with leading zeros (00 to 59)
        // u - Microseconds (added in PHP 5.2.2)
        // e - The timezone identifier (Examples: UTC, GMT, Atlantic/Azores)
        // I (capital i) - Whether the date is in daylights savings time (1 if Daylight Savings Time, 0 otherwise)
        // O - Difference to Greenwich time (GMT) in hours (Example: +0100)
        // P - Difference to Greenwich time (GMT) in hours:minutes (added in PHP 5.1.3)
        // T - Timezone abbreviations (Examples: EST, MDT)
        // Z - Timezone offset in seconds. The offset for timezones west of UTC is negative (-43200 to 50400)
        // c - The ISO-8601 date (e.g. 2013-05-05T16:34:42+00:00)
        // r - The RFC 2822 formatted date (e.g. Fri, 12 Apr 2013 12:01:05 +0200)
        // U - The seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)
        // and the following predefined constants can also be used (available since PHP 5.1.0):

        // DATE_ATOM - Atom (example: 2013-04-12T15:52:01+00:00)
        // DATE_COOKIE - HTTP Cookies (example: Friday, 12-Apr-13 15:52:01 UTC)
        // DATE_ISO8601 - ISO-8601 (example: 2013-04-12T15:52:01+0000)
        // DATE_RFC822 - RFC 822 (example: Fri, 12 Apr 13 15:52:01 +0000)
        // DATE_RFC850 - RFC 850 (example: Friday, 12-Apr-13 15:52:01 UTC)
        // DATE_RFC1036 - RFC 1036 (example: Fri, 12 Apr 13 15:52:01 +0000)
        // DATE_RFC1123 - RFC 1123 (example: Fri, 12 Apr 2013 15:52:01 +0000)
        // DATE_RFC2822 - RFC 2822 (Fri, 12 Apr 2013 15:52:01 +0000)
        // DATE_RFC3339 - Same as DATE_ATOM (since PHP 5.1.3)
        // DATE_RSS - RSS (Fri, 12 Aug 2013 15:52:01 +0000)
        // DATE_W3C - World Wide Web Consortium (example: 2013-04-12T15:52:01+00:00)
