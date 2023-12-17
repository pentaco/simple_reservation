@php
    use Carbon\Carbon;
    $today_string = Carbon::parse($today)->format('Y/n/d');
    $timeslots = $reservation->timeslots;
    $date = Carbon::parse($timeslots[0]->date)->format('Y/n/d');
    $start_time = Carbon::parse($timeslots[0]->timetable->start)->format('H:i');
    $table = $timeslots[0]->table->name;
    $end_time = Carbon::parse($timeslots[$slot_count - 1]->timetable->end)->format('H:i');
    $is_reserved = $reservation->reservation_status_id === App\Models\ReservationStatus::RESERVED;
    $icon = $is_reserved ? "fas fa-check-square" : "fas fa-ban";
    $color = $is_reserved ? "has-text-success" : "has-text-danger";
    $text = $is_reserved ? "予約済み" : "キャンセルされた予約です！";
@endphp
@extends('web-layouts.common')
@section('title', 'レストラン予約 | シンプルリザーブ')
@section('keywords', '')
@section('description', '')
@section('css')
@endsection
@include('web-layouts.head')
@section('content')
    <section class="hero is-fullheight">
        <div class="hero-body">
            <div class="login">
                <div class="mb-4">
                    <span class="icon-text {{ $color }}">
                        <span class="icon">
                          <i class="{{ $icon }}"></i>
                        </span>
                        <span>{{ $text }}</span>
                    </span>
                </div>
                <h1 class="is-size-4 mb-3">ご予約内容</h1>
                @if($is_reserved)
                <p>ご予約ありがとうございます。</p>
                <p class="mb-3">予約の確認の為に予約番号をメモするか、このページをブックマークしてください。</p>
                @endif
                <div>予約番号：{{ $reservation->code }}</div>
                <div>名前：{{ $reservation->customer_name }} 様</div>
                <div>人数：{{ $reservation->number_of_people }}名</div>
                <div>日付：{{ $date }}</div>
                <div>時間：{{ $start_time }} ~ {{ $end_time }}</div>
                <div>テーブル：{{ $table }}</div>
                <br>
                <div>その他ご要望など：</div>
                <div>{!! nl2br(e($reservation->note)) !!}</div>
                @if($is_reserved)
                <button class="button is-block is-fullwidth is-danger is-outlined is-medium is-rounded mt-5"
                    type="button" id="cancelBtn">予約をキャンセルする</button>
                @endif
                <input type="hidden" id="cancelUrl" value="{{ route('api.reservation.cancel') }}">
                <input type="hidden" id="redirectUrl" value="{{ $redirect_url_when_canceled }}">
                <input type="hidden" id="reserveCode" value="{{ $reservation->code }}">
            </div>
        </div>
    </section>
@endsection
@section('js')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/cancel.js') }}"></script>
@endsection
@include('web-layouts.footer')
