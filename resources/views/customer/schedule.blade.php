@extends('/customer/master')
@section('content')  
    <div class="pageDisplayHeader">Schedule</div>
    <div class="ContentDisplayer ">
        <table id="BoatList">
            <tr>
              <th>Boat Name</th>
              <th>Depature Island</th>
              <th>Schedule Island</th>
              <th>Departure Date</th>
              <th>Contact No</th>
            </tr>
            @foreach($schedules as $schedule)
            <tr>
              <td>{{$schedule->vessel_name}}</td>
              <td>{{$schedule->dock_island}}</td>
              <td>{{$schedule->visiting_to}}</td>
              <td>{{date('d-m-Y', strtotime($schedule->dep_date))}}</td>
              <td>{{$schedule->vessel_Contact}}</td>
            </tr> 
            @endforeach
          </table>
      </div>
    
@endsection