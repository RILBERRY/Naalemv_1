<?php

namespace App\Http\Controllers;

use App\Models\receivables;
use App\Models\category;
use App\Models\customer;
use App\Models\package;
use App\Models\shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $AllPackage = package::orderBy('id','DESC')->get();
        Session::get('isDhivehi') ? $lang = "dhi" : $lang = "eng";
        return view("$lang.collect",['AllPackage'=>$AllPackage]);
    }

    public function clam(Request $request)
    {
        $Total = 0;
        $load = package::with('payment_status')->where('id',$request->packid)->get();
        $laodCustomer = customer::where('id',$load[0]->customer_id)->get();
        $itemsLoaded = shipment::where('packages_id',$request->packid)->get();
        $allCategories = category::all();
        foreach($itemsLoaded as $item){
            $Total += $item->unit_price * $item->qty;
        }
        Session::get('isDhivehi') ? $lang = "dhi" : $lang = "eng";
        return view("$lang.clam",['load'=>$load,'laodCustomer'=>$laodCustomer,'itemsLoaded'=>$itemsLoaded,'allCategories'=>$allCategories,'Total'=>$Total]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $keyword = $request->q;
        if($request->q == ""){
            $result = package::orderBy('status','DESC')->get();
            return  json_decode($result, true); 
        }
        $result = package::where(function ($query) use($keyword) {
            $query
                ->where('CustAddress', 'like', '%' . $keyword . '%')
                ->orWhere('to', 'like', '%' . $keyword . '%')
                ->orWhere('id', 'like', '%' . $keyword . '%');
            })->get();
        return  json_decode($result, true); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function complete(Request $request)
    {
        $Load = true;
        if($request->payOption == "POD"){
            return redirect('/clam?packid='.$request->packageID)->with('status','Update payment details before Marking collected');
        }elseif($request->payOption == "NOW"){
            if($request->payType == "CASH"){
                $Newreceivables = new receivables ([
                    'packID' => request('packageID'),
                    'paymentType' => Request('payType'),
                    'payslip' => '',
                    'total' => $request->shipmentTotal
                ]);
                $Newreceivables->save();
            }elseif($request->payType == "TRANSFER"){
                if($request->paySlip != null){
                    $newPath = time() . "_" . request('packageID') . "." . request('paySlip')->extension();
                    request('paySlip')->move(public_path("img"), $newPath);

                    $Newreceivables = new receivables ([
                        'packID' => request('packageID'),
                        'paymentType' => Request('payType'),
                        'payslip' => $newPath,
                        'total' => $request->shipmentTotal
                    ]);
                    $Newreceivables->save();
                }else{
                    $load = false;
                    return redirect('/clam?packid='.$request->packageID)->with('status','Please Attach the slip');
                }

            }else {
                return redirect('/clam?packid='.$request->packageID)->with('status','error occured while saving! Try again');
            }
            
        }else{
            if(receivables::where('packID',$request->packageID)->exists()){
                $paydetail = receivables::where('packID',$request->packageID)->first();
                if($request->shipmentTotal != $paydetail->total){
                    $paydetail->update([
                        'total' => $request->shipmentTotal
                    ]);
                }
            }
        }
        if ($Load){
            package::where('id', $request->packageID)->update([
                'status' => "COLLECTED"
            ]);
        }
        return redirect('/clam?packid='.$request->packageID); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if($request->submit == "delete"){
            $deleteItem = shipment::find($id);
            if($deleteItem->img_path != 'load_default.png'){
                $fileName = 'item_img/'. $deleteItem->img_path;
                File::delete($fileName);
            }
            $deleteItem->delete();
            return redirect('/create');
        }elseif($request->submit == "edit"){
            shipment::where('id', $id)->update([
                'qty' => Request('qty'),
                'unit_price' => Request('unit_price')
            ]);
            return redirect('/clam?packid='.$request->shipmentID);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\collection  $collection
     * @return \Illuminate\Http\Response
     */
   
}
