<?php

namespace App\Http\Controllers;

use App\Models\atoll;
use App\Models\shipment;
use App\Models\customer;
use App\Models\package;
use App\Models\category;
use App\Models\islands;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File; 

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Session::get('isDhivehi') ? $lang = "dhi" : $lang = "eng";
        Session::put('NewCategory',$request->cateid);
        if(session::has('NewCustomer')){
            $allCategories = category::all();
            if(Session::has('newpackage')){
                if (shipment::where('packages_id', Session::get('newpackage')->id)->exists()){
                    $Total = 0;
                    $Shipments = shipment::where('packages_id', Session::get('newpackage')->id)->get();
                    foreach($Shipments as $item){
                        $Total += $item->unit_price * $item->qty;
                    }
                    return view("$lang.create",['allCategories' => $allCategories, 'Shipments'=>$Shipments, 'Total'=>$Total]);
                }
            }
            return view("$lang.create",['allCategories' => $allCategories]);
        }
        return redirect('/customer');
    }

    function island(Request $request){
        $allIslands = islands::orderBy('name','asc')->get();
        Session::get('isDhivehi') ? $lang = "dhi" : $lang = "eng";
        return view("$lang.dashboard",['allIslands' => $allIslands]);

    }

    function createIsland(Request $request){
        $this->validate($request, [
            'atoll' => ['required'],
            'name' => ['required'],
            'code' => ['required'],
        ]);
        if(!atoll::where('name',strtoupper($request->atoll))->exists()){
            $atoll = new atoll([
                'name'=>strtoupper($request->atoll),
                'code'=>'-',
            ]);
            $atoll->save();
        }
        
        $atoll = atoll::where('name',$request->atoll)->first();
        $newIslands = new islands ([
            'atoll_id' => $atoll->id,
            'name' => $request->name,
            'code' => $request->code,
        ]);
        $newIslands->save();
        return redirect('dashboard')->with(['newIslands'=>$newIslands]);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Session::get('isDhivehi') ? $lang = "dhi" : $lang = "eng";
        $allCategories = category::all();
        return view("$lang.create",['allCategories' => $allCategories]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->submit == "AddItem" || session::has('NewCustomer') ){
            $this->validate($request, [
                'qty' => ['required'],
                'unit_price' => ['required'],
                'cateID' => ['required'],
                'packID' => ['required']
            ]);
            $newPath = "load_default.png";
            if(Request('img')!=null){
                $newPath = time() . "_pack_id_" . Request('packID') . "." . request('img')->extension();
                request('img')->move(public_path("item_img"), $newPath);
            }
            
            $newShipment = new shipment ([
                'qty' => Request('qty'),
                'unit_price' => Request('unit_price'),
                'img_path' => $newPath,
                'category_id' => Request('cateID'),
                'packages_id' => Request('packID')
            ]);
            $newShipment->save();

        }else if( $request->submit == "AddItem_Guest"){

            // create guest 
            $NewCustomer = new customer([
                'CustNumber' => 0 ,
                'CustName' => "Guest"
                
            ]);
            $NewCustomer;
            if (customer::where('CustNumber', 0)->exists()){
                $Cust = customer::all('id','CustNumber');
            }
            else{
                $NewCustomer -> save();
                $Cust = customer::all('id','CustNumber');
            }
    
            foreach( $Cust as $_Cust){
                if($_Cust['CustNumber'] == 0){
                    $CustID = $_Cust['id'];
                    break;
                }
            }
            $newpackage = new package ([
                'CustAddress' => "-",
                'from' => "-",
                'to' => "-",
                'customer_id' => $CustID
            ]);
            $newpackage->save();
            // Session::put('NewCustomer',$NewCustomer);
            Session::put('newpackage',$newpackage);

            // adding package
            $this->validate($request, [
                'qty' => ['required'],
                'unit_price' => ['required'],
                'cateID' => ['required']
            ]);
            $newPath = "load_default.png";
            if(Request('img')!=null){
                $newPath = time() . "_pack_id_" . Request('packID') . "." . request('img')->extension();
                request('img')->move(public_path("item_img"), $newPath);
            }
            $newShipment = new shipment ([
                'qty' => Request('qty'),
                'unit_price' => Request('unit_price'),
                'img_path' => $newPath,
                'category_id' => Request('cateID'),
                'packages_id' => $newpackage->id
            ]);
            $newShipment->save();
        }
        return redirect('/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function show(shipment $shipment)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function edit(shipment $shipment)
    {
        dd("asghdb");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, shipment $shipment)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if($request->submit == "delete"){
            $deleteItem = shipment::find($request->cateID);
            $fileName = 'item_img/'. $deleteItem->img_path;
            File::delete($fileName);
            $deleteItem->delete();
            return redirect('/create');
        }elseif($request->submit == "AddItem"){
            shipment::where('id', $request->cateID)->update([
                'qty' => Request('qty'),
                'unit_price' => Request('unit_price')
            ]);
            return redirect('/create');
        }
    }
}
