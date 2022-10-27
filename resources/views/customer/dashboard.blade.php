@extends('/customer/master')
@section('content')  
    <div class="pageDisplayHeader">Dashboard</div>
    <div class="ContentDisplayer">
        <div class="LeftContent">
            <div>
                <h3>Shipment Details</h3>
                <div class="SubContent">
                    <div class="ContentDetails w-100">
                        <h4>Total Shipment</h4>
                        <h3>{{$transaction->TotalShipments}}</h3>
                    </div>
                </div>
                <div class="SubContent">
                    <div class="ContentDetails w-2">
                        <h4>Shipped</h4>
                        <h3>{{$transaction->Shipped}}</h3>
                    </div>
                    <div class="ContentDetails w-2">
                        <h4>Total Collected</h4>
                        <h3>{{$transaction->Collected}}</h3>
                    </div>
                </div>
            </div>
            {{-- <div>
                <h3>Payment Details</h3>
                <div class="SubContent">
                    <div class="ContentDetails w-2">
                        <h4>Total Shipment</h4>
                        <h3>230</h3>
                    </div>
                    <div class="ContentDetails w-2">
                        <h4>Total Shipment</h4>
                        <h3>230</h3>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="RightContent">
            <h3>Package History</h3>
            <div class="ContentDetails h_100">
                @if(!$LastPack)
                <div class="detailInfo">
                    <p class="HistoryTitle">No order found</p>
                </div>
                @elseif($LastPack->status =="LOADED")
                <div class="HistoryDetails">
                    <div class="iconCont">
                        <div class="circle active"></div>
                        <div class="line active"></div>
                    </div>
                    <div class="detailInfo active">
                        <p class="HistoryTitle">Created Shipment</p>
                        <p class="HistoryDate">{{$LastPack->created_at}}</p>
                    </div>
                </div>
                <div class="HistoryDetails">
                    <div class="iconCont">
                        <div class="circle active"></div>
                        <div class="line active"></div>
                    </div>
                    <div class="detailInfo active">
                        <p class="HistoryTitle">Loaded to {{$LastPack->VesselName->name}} Boat</p>
                        <p class="HistoryDate">{{$LastPack->created_at}}</p>
                    </div>
                </div>
                @if($DepatrueTime->isDepatured)
                <div class="HistoryDetails">
                    <div class="iconCont">
                        <div class="circle active"></div>
                        <div class="line active"></div>
                    </div>
                    <div class="detailInfo active">
                        <p class="HistoryTitle">Boat Depature {{$LastPack->from}} - {{$LastPack->to}}</p>
                        <p class="HistoryDate">{{$DepatrueTime->dep_date}}</p>
                    </div>
                </div>
                @else
                <div class="HistoryDetails">
                    <div class="iconCont">
                        <div class="circle"></div>
                        <div class="line"></div>
                    </div>
                    <div class="detailInfo">
                        <p class="HistoryTitle">Boat Depature {{$LastPack->from}} - {{$LastPack->to}}</p>
                        <p class="HistoryDate">{{$DepatrueTime->dep_date}}</p>
                    </div>
                </div>
                @endif

                @if($LastPack->status == "COLLECTED") 
                    <div class="HistoryDetails">
                        <div class="iconCont">
                            <div class="circle active"></div>
                            <div class="line active"></div>
                        </div>
                        <div class="detailInfo active">
                            <p class="HistoryTitle">Docked in {{$LastPack->to}}</p>
                            <p class="HistoryDate">{{$DepatrueTime->updated_at}}</p>
                        </div>
                    </div>
                    <div class="HistoryDetails">
                        <div class="iconCont">
                            <div class="circle active"></div>
                            <div class="line active"></div>
                        </div>
                        <div class="detailInfo active">
                            <p class="HistoryTitle">Ready Clam</p>
                            <p class="HistoryDate">{{$DepatrueTime->updated_at}}</p>
                        </div>
                    </div>
                    <div class="HistoryDetails">
                        <div class="iconCont">
                            <div class="circle active"></div>
                            {{-- <div class="line"></div> --}}
                        </div>
                        <div class="detailInfo active">
                            <p class="HistoryTitle">Collected</p>
                            <p class="HistoryDate">{{$LastPack->updated_at}}</p>
                        </div>
                    </div>

                @elseif($DepatrueTime->status == "READY")
                    <div class="HistoryDetails">
                        <div class="iconCont">
                            <div class="circle active"></div>
                            <div class="line active"></div>
                        </div>
                        <div class="detailInfo active">
                            <p class="HistoryTitle">Docked in {{$LastPack->to}}</p>
                            <p class="HistoryDate">{{$DepatrueTime->updated_at}}</p>
                        </div>
                    </div>
                    <div class="HistoryDetails">
                        <div class="iconCont">
                            <div class="circle active"></div>
                            {{-- <div class="line"></div> --}}
                        </div>
                        <div class="detailInfo active">
                            <p class="HistoryTitle">Ready Clam</p>
                            <p class="HistoryDate">{{$DepatrueTime->updated_at}}</p>
                        </div>
                    </div>
                @elseif($DepatrueTime->status == "ARRAIVED")
                    <div class="HistoryDetails">
                        <div class="iconCont">
                            <div class="circle active"></div>
                            <div class="line active"></div>
                        </div>
                        <div class="detailInfo active">
                            <p class="HistoryTitle">Docked in {{$LastPack->to}}</p>
                            <p class="HistoryDate">{{$DepatrueTime->updated_at}}</p>
                        </div>
                    </div>
                    <div class="HistoryDetails">
                        <div class="iconCont">
                            <div class="circle "></div>
                            {{-- <div class="line"></div> --}}
                        </div>
                        <div class="detailInfo ">
                            <p class="HistoryTitle">Ready Clam</p>
                            <p class="HistoryDate">....</p>
                        </div>
                    </div>
                   
                @else
                    <div class="HistoryDetails">
                        <div class="iconCont">
                            <div class="circle "></div>
                            <div class="line "></div>
                        </div>
                        <div class="detailInfo ">
                            <p class="HistoryTitle">Docked in {{$LastPack->to}}</p>
                            <p class="HistoryDate">.....</p>
                        </div>
                    </div>
                    <div class="HistoryDetails">
                        <div class="iconCont">
                            <div class="circle "></div>
                            {{-- <div class="line"></div> --}}
                        </div>
                        <div class="detailInfo ">
                            <p class="HistoryTitle">Ready Clam</p>
                            <p class="HistoryDate">.....</p>
                        </div>
                    </div>
                   
                @endif
                @else
                <div class="detailInfo">
                    <p class="HistoryTitle">No order found</p>
                </div>
                @endif
            </div>
        </div>
      </div>
    
@endsection