@extends('layouts.common')
@section('title', '予約枠作成 | シンプルリザーブ')
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
                <form action="{{ route('timeslot.store') }}" method="POST">
                    @csrf
                    <div class="field">
                        <label class="label">開始</label>

                        <div class="control">
                            <input class="input" type="text" name="start" id="start_date" autocomplete="off" readonly=”readonly” value="{{ old('start') }}">
                        </div>
                        @error('start')
                            <p class="has-text-danger">
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                    <div class="field end-input-field">
                        <label class="label">終了</label>
                        <div class="control">
                            <input class="input" type="text" name="end" id="end_date" autocomplete="off" readonly=”readonly” value="{{ old('end') }}">
                        </div>
                        @error('end')
                            <p class="has-text-danger">
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                    <button class="button is-block is-fullwidth is-primary is-medium is-rounded" type="submit">Next</button>
                </form>
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
