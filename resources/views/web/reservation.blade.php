@extends('web-layouts.common')
@section('title', 'レストラン予約 | シンプルリザーブ')
@section('keywords', '')
@section('description', '')
@section('css')
<style>
.time-table {
    display: block;
    border-collapse: collapse;
  }
  
  .time-table {
    display: block;
    border-collapse: collapse;
  }
  
  .time-table th {
    border-top: 1px solid #d2d2d2;
  }
  
  .time-table th, .time-table td {
    padding: 0px 10px;
    text-align: center;
    height:50px;
    border-bottom: 1px solid #d2d2d2;
  }
  
  .time-table td {
        width: 100%;
      min-width: 58px;
      color:#1ba1e6;
      font-weight: bold;
  }
  
  .time-table td .time {
   color:#3c3c3c;
  }
  
  @media screen and (max-width: 764px)  {
   .time-table td {
    min-width: auto;
    width:100%;
    max-width:5%;
    font-size:12px;
   }
  
   .time-table th, .time-table td {
    min-width: 40px;
    width:100%;
    padding:0px 15px;
    font-size:10px;
   }
  }
  
  
</style>
@endsection
@include('web-layouts.head')
@section('content')
    <section class="hero is-fullheight">
        <div class="hero-body">
            <div class="login">
                <table class="time-table">
                    <tbody>
                        {{-- <tr>
                            @foreach ($grouped_timeslots as $grouped_timeslot)
                                <th>{{ $grouped_timeslot->id }}</th>
                            @endforeach
                        </tr> --}}
                        @foreach ($grouped_timeslots as $grouped_timeslot)
                        <tr>
                            <td class="time">9:30〜12:30</td>
                            @foreach ($grouped_timeslot as $timeslot)
                            <td>{{ $timeslot->timeslot_status_id }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
@section('js')
@endsection
@include('web-layouts.footer')
