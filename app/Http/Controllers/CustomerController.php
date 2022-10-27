<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\package;
use App\Models\customer;
use App\Models\islands;
use App\Models\schedule;
use App\Models\receivables;
use App\Models\shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Session::get('isDhivehi') ? $lang = "dhi" : $lang = "eng";
        if(session::has('NewCustomer')){
            return redirect('/create');
        }

        $selectedIsland = islands::orderBy('name')->get();
        if($request->exists('island')){
            $selectedIsland = islands::where( 'id',$request->island)->get();

        }
        $allCategories = category::all();
        $newpackage = package::all()->last();
        if($newpackage != null){

            if($newpackage->status =="LOADING"){
                $NewCustomer = customer::where('id',$newpackage->customer_id)->first();
                Session::put('NewCustomer',$NewCustomer);
                Session::put('newpackage',$newpackage);
                return redirect('/create');
            }
        }
        return view("$lang.create",['allCategories' => $allCategories,'selectedIsland'=>$selectedIsland]);
        
    }



    public function dashboard()
    {
        $datetime = date('Y-m-d H:i:s');
        $LastPack = package::with('VesselName')->where([['customer_id',auth()->user()->custid]])->orderByDesc('id')->First();
        $transaction = package::where('customer_id',auth()->user()->custid)->orderByDesc('id')->get();
        $TransColl = package::where([['customer_id',auth()->user()->custid],['status','COLLECTED']])->orderByDesc('id')->get();
        $TransShipped = package::where([['customer_id',auth()->user()->custid],['status','!=','COLLECTED']])->orderByDesc('id')->get();
        $transaction->TotalShipments = count($transaction);
        $transaction->Collected = count($TransColl);
        $transaction->Shipped = count($TransShipped);
        if($LastPack){    
            if($LastPack->status !='COLLECTED'){    
                $DepatrueTime = schedule::where([['id',$LastPack->vessel_id],['status','!=','COMPLETE']])->orderByDesc('id')->first();
                $DepatrueTime->isDepatured = false;
                if($DepatrueTime->dep_date <= $datetime){
                    $DepatrueTime->isDepatured = true;
                }
                return view('customer.dashboard',['transaction'=>$transaction,'LastPack'=>$LastPack, 'DepatrueTime'=>$DepatrueTime]);
            }
        }
        return view('customer.dashboard',['transaction'=>$transaction,'LastPack'=>$LastPack]);
    }
    public function schedule()
    {
        $schedules = schedule::orderByDesc('id')->get();
        return view('customer.schedule',['schedules'=>$schedules]);
    }
    public function transaction()
    {
        $transaction = package::where('customer_id',auth()->user()->custid)->orderByDesc('id')->get();
        return view('customer.transaction',['transaction'=>$transaction]);
    }
    public function settlement()
    {
        $transaction = package::where('customer_id',auth()->user()->custid)->orderByDesc('id')->get();
        $items = shipment::orderByDesc('packages_id')->get();
        $receivables = receivables::orderByDesc('packID')->get();
        foreach($transaction as $trans){
            $total = 0;
            foreach($receivables as $receiv ){
                if($trans->id == $receiv->packID){
                    $trans->paymentStatus = "PAID";
                    break;
                }
                $trans->paymentStatus = "CREDIT";
            }
            foreach($items as $item ){
                if($trans->id == $item->packages_id){
                    $total+= $item->qty * $item->unit_price;
                }
            }
            $trans->total = $total; 
        }
        return view('customer.settlement',['transaction'=>$transaction]);
    }
    public function setting()
    {
        return view('customer.setting');
    }
    public function logout()
    {
        return view('customer.logout');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'CustNumber' => ['required'],
            'CustAddress' => ['required'],
            'LFrom' => ['required'],
            'ULTo' => ['required']
        ]);
        // variables
        $Cust;
        $CustID;
        $NewCustomer = new customer([
            'CustNumber' => request('CustNumber') ,
            'CustName' => request('CustName')
        ]);
        
        if (customer::where('CustNumber', request('CustNumber'))->exists()){
            $_Customer = customer::where('CustNumber', request('CustNumber'))->get();
            // dd($_Customer[0]);
            if($_Customer[0]->CustName != request('CustName')){
                Customer::where('CustNumber', request('CustNumber'))->update([
                    'CustName' => request('CustName')
                ]);
            }
            $Cust = customer::all('id','CustNumber');
        }
        else{
            $NewCustomer -> save();
            $Cust = customer::all('id','CustNumber');
        }

        foreach( $Cust as $_Cust){
            if($_Cust['CustNumber'] == request('CustNumber')){
                $CustID = $_Cust['id'];
                break;
            }
        }
        if(Session::has('newpackage')){
            package::where('id', Session::get('newpackage')->id)->update([
                'CustAddress' => request('CustAddress'),
                'from' => Request('LFrom'),
                'to' => Request('ULTo'),
                'customer_id' => $CustID,
                'vessel_id' => auth()->user()->boatid,
            ]);
            $newpackage = package::where('id', Session::get('newpackage')->id)->get();
            Session::forget('newpackage');
            Session::put('newpackage',$newpackage[0]);
        }else{
            $newpackage = new package ([
                'CustAddress' => request('CustAddress'),
                'from' => Request('LFrom'),
                'to' => Request('ULTo'),
                'customer_id' => $CustID,
                'vessel_id' => auth()->user()->boatid,
            ]);
            $newpackage->save();
            Session::put('newpackage',$newpackage);
        }
        Session::put('NewCustomer',$NewCustomer);
        // dd(Session::get('newpackage'));
        return redirect('/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function customerInfo(Request $request)
    {
        $CustNo = $request->custno;
        $CustomerInfo = customer::where('CustNumber', $CustNo)->get();
        return $CustomerInfo;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(customer $customer)
    {
        //
    }
}
