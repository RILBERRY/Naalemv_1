<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\package;
use App\Models\customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::get('isDhivehi') ? $lang = "dhi" : $lang = "eng";
        if(session::has('NewCustomer')){
            return redirect('/create');
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
            
            return view("$lang.create",['allCategories' => $allCategories]);
        }
        return view("$lang.create",['allCategories' => $allCategories]);
        
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
                'customer_id' => $CustID
            ]);
            $newpackage = package::where('id', Session::get('newpackage')->id)->get();
            Session::forget('newpackage');
            Session::put('newpackage',$newpackage[0]);
        }else{
            $newpackage = new package ([
                'CustAddress' => request('CustAddress'),
                'from' => Request('LFrom'),
                'to' => Request('ULTo'),
                'customer_id' => $CustID
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
