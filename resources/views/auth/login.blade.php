@extends('web-layouts.common')
@section('title', 'ログイン | シンプルリザーブ')
@section('keywords', '')
@section('description', '')
@section('css')
@endsection
@include('web-layouts.head')
@section('content')
    <section class="hero is-fullheight">
        <div class="hero-body">
            <div class="login">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="field">
                        <label class="label">メールアドレス</label>
                        <div class="control">
                            <input class="input" type="email" placeholder="例）simple@example.com" name="email">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">パスワード</label>
                        <div class="control">
                            <input class="input" type="password" name="password">
                        </div>
                    </div>
                    <button class="button is-block is-fullwidth is-primary is-medium is-rounded mt-3"
                    type="submit">ログイン</button>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('js')
@endsection
@include('web-layouts.footer')
