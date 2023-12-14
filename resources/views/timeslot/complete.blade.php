@extends('layouts.common')
@section('title', '予約枠作成完了 | シンプルリザーブ')
@section('keywords', '')
@section('description', '')
@section('noindex')
<meta name="googlebot" content="noindex">
@endsection
@section('css')
@endsection
@include('layouts.head')
@section('content')
    <section class="hero is-fullheight">
        <div class="hero-body">
            <div class="login">
                <div>作成完了</div>
            </div>
        </div>
    </section>
@endsection
@section('js')
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<script>
    $("#start_date").datepicker({
        // minDate: new Date($("#min_date1").val())
    });
    $("#end_date").datepicker({
        // minDate: new Date($("#start_date").val())
    });
</script>
@endsection
@include('layouts.footer')
