@extends('web-layouts.common')
@section('title', 'ホーム | シンプルリザーブ')
@section('keywords', '')
@section('description', '')
@section('css')
<style>
    .card{
        width: 500px !important;
    }
</style>
@endsection
@include('web-layouts.head')
@section('content')
<section class="hero is-fullheight">
    <div class="hero-body">
        <div class="card is-shady">
            <div class="card-image">
                <figure class="image is-4by3">
                    <img src="{{ asset('img/jay-wennington-N_Y88TWmGwA-unsplash.jpg') }}">
                </figure>
            </div>
            <div class="card-content">
                <div class="content">
                    <button class="button is-block is-fullwidth is-primary is-medium is-rounded mt-3" data-reserve-url="{{ route('reservation.create')}}" id="reserveBtn">新規当日予約</button>
                </div>
                <div class="content mt-5">
                    <div class="field">
                        <label class="label">予約番号</label>
                        <div class="control">
                            <input class="input" type="text" name="code" id="inputCode">
                        </div>
                        <div class="is-size-7">予約番号が正しくない場合は404（ページが見つからない）エラーとなります。</div>
                    </div>
                    <button class="button is-outlined is-fullwidth is-primary is-medium is-rounded mt-3" type="button"  data-reservation-url="{{ route('reservation.show')}}" id="reservationBtn">予約確認</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
<script src="{{ asset('js/home.js') }}"></script>
@endsection
@include('web-layouts.footer')
