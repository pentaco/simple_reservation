@php
    use Carbon\Carbon;
    $today_string = Carbon::parse($today)->format('Y/n/d');
@endphp
@extends('web-layouts.common')
@section('title', 'レストラン予約 | シンプルリザーブ')
@section('keywords', '')
@section('description', '')
@section('css')
    <style>
        .time-table {
            display: block;
            border-collapse: collapse;
            overflow: scroll;
            height: 70dvh;
        }

        .time-table {
            display: block;
            border-collapse: collapse;
        }

        .time-table th {
            border-top: 1px solid #d2d2d2;
        }

        .time-table th,
        .time-table td {
            padding: 0px 5px;
            text-align: center;
            height: 50px;
            border-bottom: 1px solid #d2d2d2;
            vertical-align: middle;
        }

        .time-table td {
            width: 100%;
            min-width: 58px;
            color: #1ba1e6;
            font-weight: bold;
        }

        .time-table td .time {
            color: #3c3c3c;
        }

        @media screen and (max-width: 764px) {
            .time-table td {
                min-width: auto;
                width: 100%;
                max-width: 5%;
                font-size: 12px;
            }

            .time-table th,
            .time-table td {
                min-width: 40px;
                width: 100%;
                padding: 0px 15px;
                font-size: 10px;
            }
        }

        .modal_window {
            width: 330px;
            height: 500px;
            border-radius: 4px;
            padding: 24px;
            background-color: #fff;
            position: absolute;
            top: auto;
            overflow: scroll;
            opacity: 0;
            visibility: hidden;
            z-index: 1000;
            left: 50%;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
        }

        .activeModal {
            opacity: 1;
            visibility: visible;
            transition: opacity 1s, visibility 1s;
        }

        .modalOverlay {
            width: 100%;
            height: 100%;
            background-color: #000;
            position: fixed;
            top: 0;
            left: 0;
            margin: 0;
            padding: 0;
            opacity: 0;
            visibility: hidden;
            z-index: 900;
        }

        .activeOverlay {
            opacity: .5;
            visibility: visible;
            transition: opacity 1s, visibility 1s;
        }
    </style>
@endsection
@include('web-layouts.head')
@section('content')
    <section class="hero is-fullheight">
        <div class="hero-body">
            <div class="login">
                <h1>本日のレストラン予約</h1>
                @if(count($grouped_timeslots) === count($tables))
                    @if($reservations_open_at->gte(now()))
                    <div>予約は本日{{$reservations_open_at->format('H:i')}}より承ります。</div>
                    @else
                    <div>ご希望のテーブルと開始時間を選択しください。</div>
                    <div class="mb-5">選択した時間から1時間30分のご利用となります。</div>
                    <table class="time-table">
                        <tbody>
                            <tr>
                                <th>利用開始時間</th>
                                @foreach ($tables as $table)
                                    <th>{{ $table->name }}</th>
                                @endforeach
                            </tr>
                            @foreach ($tables as $table)
                                <tr>
                                    @foreach ($grouped_timeslots[$table->id] as $key => $timeslot)
                                        @if ($key === 0)
                                            <td class="time">{{ Carbon::parse($timeslot->timetable->start)->format('H:i') }}〜
                                            </td>
                                        @endif
                                        <td>
                                            @if (in_array($timeslot->id, $selectable_timeslot_ids))
                                                <input type="radio" class="radioTimeslot" name="select_timeslot"
                                                    value="{{ $timeslot->id }}"
                                                    data-table="{{ $timeslot->table->name }}"
                                                    data-start="{{ Carbon::parse($timeslot->timetable->start)->format('H:i') }}" />
                                            @else
                                                ×
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button class="button is-block is-fullwidth is-primary is-medium is-rounded mt-3 modalToggle"
                        type="button">予約情報の入力へ</button>

                    @endif
                @else
                <div>申し訳ございません。本日の予約は受け付けておりません。</div>
                <div>店休日〇〇曜日</div>
                @endif
            </div>
        </div>
    </section>
    <div id="modalOverlay" class="modalOverlay"></div>
    <div id="modal" class="modal_window card" role="dialog" aria-labelledby="dialog-header"
        aria-describedby="dialog-desc">
        <div class="card-content">
            <div class="media">
                <div class="media-content">
                    <p class="title is-6">{{ $today_string }} - 本日の予約</p>
                    <p>予約情報をご入力ください。</p>
                </div>
            </div>



            <div class="content">
                <label class="label">テーブル</label>
                <div id="cardTable"></div>
            </div>

            <div class="content">
                <label class="label">開始時間</label>
                <time id="cardTime"></time>
            </div>

            <div class="field">
                <label class="label">ご利用人数</label>
                <div class="control">
                    <div class="select">
                        <select id="inputNumber">
                            <?php for ($i = 1; $i <= 4; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="field">
                <label class="label">お名前</label>
                <div class="control">
                    <input class="input" type="text" placeholder="例）おなまえたろう" id="inputName">
                </div>
            </div>

            <div class="field">
                <label class="label">メールアドレス</label>
                <div class="control">
                    <input class="input" type="email" placeholder="例）simple@example.com" id="inputEmail">
                </div>
            </div>

            <div class="field">
                <label class="label">電話番号</label>
                <div class="control">
                    <input class="input" type="email" placeholder="例）080-1234-1234" id="inputTel">
                </div>
            </div>

            <div class="field">
                <label class="label">その他【任意】</label>
                <div class="control">
                    <p class="help">ご要望などございましたらご記入ください。</p>
                    <textarea class="textarea" placeholder="" id="inputNote"></textarea>
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <label class="checkbox">
                        <input type="checkbox" id="agreement">
                        <a href="https://forms.gle/W78vTLA9bRumPsmN7" target="_blank">個人情報保護方針</a>に同意する
                    </label>
                </div>
            </div>
        </div>
        <footer class="card-footer">
            <input type="hidden" id="reserveTimeslot">
            <input type="hidden" value="{{ $today_string }}" id="reserveDate">
            <input type="hidden" value="{{ $reserve_url }}" id="reserveUrl">
            <input type="hidden" value="{{ $detail_url }}" id="detailUrl">
            <a class="card-footer-item close closeBtn">閉じる</a>
            <a class="card-footer-item" id="reserveBtn">予約する</a>
        </footer>
    </div>
@endsection
@section('js')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/modal.js') }}"></script>
    <script src="{{ asset('js/card.js') }}"></script>
    <script src="{{ asset('js/reserve.js') }}"></script>
@endsection
@include('web-layouts.footer')
