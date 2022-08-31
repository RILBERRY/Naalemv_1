<?php

namespace App\Http\Controllers;

use App\Models\collection;
use App\Models\category;
use App\Models\customer;
use App\Models\package;
use App\Models\shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 

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
        return view('collect',['AllPackage'=>$AllPackage]);
    }

    public function clam(Request $request)
    {
        $Total = 0;
        $load = package::where('id',$request->packid)->get();
        $collectionDetails = collection::where('packID',$request->packid)->get();
        $laodCustomer = customer::where('id',$load[0]->customer_id)->get();
        $itemsLoaded = shipment::where('packages_id',$request->packid)->get();
        $allCategories = category::all();
        foreach($itemsLoaded as $item){
            $Total += $item->unit_price * $item->qty;
        }
        return view('clam',['load'=>$load,'laodCustomer'=>$laodCustomer,'itemsLoaded'=>$itemsLoaded,'allCategories'=>$allCategories,'Total'=>$Total,'collectionDetails'=>$collectionDetails]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd($request);
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
                    $load = false;
                    return redirect('/clam?packid='.$request->packageID)->with('status','Please Attach the slip');
                }

            }else {
                $Load = false;
                return redirect('/clam?packid='.$request->packageID)->with('status','error occured while saving! Try again');
            }
            if ($Load){
                package::where('id', $request->packageID)->update([
                    'status' => "COLLECTED"
                ]);
            }
            return redirect('/collect') ;
        }else {
            return redirect('/clam?packid='.$request->packageID)->with('status','error occured while saving! Try again');
        }
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
    public function edit(Request $request)
    {
        dd($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, collection $collection)
    {
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function destroy(collection $collection)
    {
        dd($request);
    }
}