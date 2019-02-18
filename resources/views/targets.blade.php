@extends('layouts.app')

@section('content')

    <!-- Bootstrap шаблон... -->

    <div class="panel-body">
        <!-- Отображение ошибок проверки ввода -->
        @include('common.errors')
        <h1 class="title">Put Target</h1>
        <!-- Форма новой задачи -->
        <form action="{{ url('targets') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <div class="field">
                <label class="label" for="link">Resouce URL</label>

                <div class="control">
                    <input class="input {{ $errors->has('link') ? 'is-danger' : '' }}" name="link"
                           value="{{ old('link') }}"
                           placeholder="Resource URL" type="url" required>
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <button type="submit" class="button is-link">Put Target</button>
                </div>
            </div>
        </form>
    </div>
    <h1 class="title">Targets List</h1>

    @if (count($targets))
        <table class="table is-fullwidth is-bordered">
            <thead>
            <tr>
                <th>Link</th>
                <th>Status</th>
                <th></th>

            </tr>
            </thead>
            <tbody>

            @foreach($targets as $target)

                <tr>
                    <td>{{ $target->link }}</td>
                    <td>{{ $target->status() }}</td>
                    <td class="text-justify"><?= $target->completed()
							? ' <a href="/targets/'.$target->id.'/download">Download</a>' : '' ?></td>
                </tr>

            @endforeach

            </tbody>
        </table>
    @else
        <p>Party!!! No jobs! Time for blobs!</p>
    @endif
@endsection
