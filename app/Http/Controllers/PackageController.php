<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\collection;
use App\Models\shipment;
use App\Models\category;
use App\Models\package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Session::has('NewCustomer')){
            // $Cust = customer::where('CustNumber',Session::get('NewCustomer')->CustNumber)->get();
            // $viberTokenStatus = $Cust[0]->ViberToken;
            Session::forget('newpackage');
            Session::forget('NewCustomer');
            // if( $viberTokenStatus == 'null'){
            //     // return view('confirm');
            //     return redirect('/customer');
            // }else{
                // return redirect('/customer');
            // }
        }
        
        return redirect('/customer');
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
        if ($request->SubmitType == "SAVE"){
            if(!shipment::where('packages_id', request('packageID'))->exists()) {
                return redirect('/create')->with('status', 'No item added ');
            } 
            if($request->payType == "CASH"){
                $NewCollection = new collection ([
                    'packID' => request('packageID'),
                    'paymentType' => Request('payType'),
                    'payslip' => ''
                ]);
                $NewCollection->save();
            }elseif($request->payType == "TRANSFER"){
                if($request->paySlip != null){
                    $newPath = time() . "_" . request('packageID') . "." . request('paySlip')->extension();
                    request('paySlip')->move(public_path("img"), $newPath);

                    $NewCollection = new collection ([
                        'packID' => request('packageID'),
                        'paymentType' => Request('payType'),
                        'payslip' => $newPath
                    ]);
                    $NewCollection->save();
                }else{
                    return redirect('/create?packid='.$request->packageID)->with('status','Please Attach the slip');
                }

            }
            package::where('id', $request->packageID)->update([
                'status' => "LOADED"
            ]);
            return redirect('/confirm');
        }else if($request->SubmitType == "CANCEL") {
            // deleting any added item
            if(shipment::where('packages_id', Session::get('newpackage')->id)->exists()){
                $deleteItem = shipment::where('packages_id', Session::get('newpackage')->id);
                $deleteItem->delete();
            }
            // Deleting customer details
            if(Package::where('id', Session::get('newpackage')->id)->exists()){
                $deleteItem = package::find(Session::get('newpackage')->id);
                $deleteItem->delete();
            }
            Session::forget('newpackage');
            Session::forget('NewCustomer');
            return redirect('/create');
        }else{
            return redirect('/create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(category $category)
    {
        //
    }

    // viber bot
    public function Bot($_input)
    {
        $access_token = "4e5f54eb7367de12-e551fff168cff2fc-7f2bd21f94dac62d";

        $request = file_get_contents("php://input");
        $input = json_decode($request, true);

        if($input['event'] == 'webhook'){
            $webhook_response['status'] = 0;
            $webhook_response['status_message'] = "ok";
            $webhook_response['event_type'] = "delivered";
            echo json_encode($webhook_response);
            die;
        }elseif($input['event'] == 'ho'){
            $MsgReceived = $input['message']['text'];
            $MsgSenderID = $input['sender']['id'];
            $MsgSenderName = $input['sender']['name'];
            $MsgSenderNumber = $input['sender']['mnc'];
            echo $MsgSenderID;
            $MTR = "hello ". $MsgSenderID . " ". $MsgSenderNumber ;

            $data['auth_token'] = $access_token;
            $data['receiver'] = $MsgSenderID;
            $data['type'] = "text";
            $data['text'] = $MTR;
            sendmessage($data);

        }

        // function SendDetil(){
        //     $MsgSenderID = "+9609555905";
        //     $MTR = "hello riley ";

        //     $data['auth_token'] = $access_token;
        //     $data['receiver'] = $MsgSenderID;
        //     $data['type'] = "text";
        //     $data['text'] = $MTR;
        //     sendmessage($data);
        // }

        function sendmessage($data){
            $url = "https://chatapi.viber.com/pa/send_message";
            $jsonData = json_encode($data);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content_Type : application/json'));
            $result = curl_exec($ch);
            return $result;

        }
        // SendDetil();
    }
}
