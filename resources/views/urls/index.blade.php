@extends('layouts.app')
@section('content')
<div class="container">
    <table class="table">
        <thead>
        <tr>
            <th>
                Shortened Url
            </th>
            <th>
                Redirects To
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($urls as $url)
        <tr>
            <td><a href="{{ env('APP_URL')  }}/{{ $url->id  }}">{{ env('APP_URL')  }}/{{ $url->id  }}</a></td>
            <td><a href="{{ $url->url }}">{{ $url->url }}</a> </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
