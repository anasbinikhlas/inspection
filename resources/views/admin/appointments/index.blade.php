@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-xl font-bold mb-4">Appointments ({{ ucfirst($status) }})</h1>

    @if($appointments->isEmpty())
        <p>No appointments found for this status.</p>
    @else
        <table class="min-w-full bg-white border rounded">
            <thead>
                <tr>
                    <th class="py-2 px-4 border">#</th>
                    <th class="py-2 px-4 border">Client Name</th>
                    <th class="py-2 px-4 border">Date</th>
                    <th class="py-2 px-4 border">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                <tr>
                    <td class="py-2 px-4 border">{{ $loop->iteration }}</td>
                    <td class="py-2 px-4 border">{{ $appointment->client_name }}</td>
                    <td class="py-2 px-4 border">{{ $appointment->date }}</td>
                    <td class="py-2 px-4 border">{{ $appointment->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
