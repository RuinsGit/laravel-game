@extends('layouts.admin')

@section('content')
    <div class="konteyner-3">
        <h1 class="səhifə-başlıq">Sifarişləri İdarə Et</h1>

        <div class="cədvəl-konteyneri">
            <table class="cədvəl">
                <thead>
                <tr>
                    <th>Sifariş ID</th>
                    <th>İstifadəçi</th>
                    <th>Məhsul</th>
                    <th>Miqdar</th>
                    <th>Cəm Qiymət</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>  <!-- İstifadəçi adı -->
                        <td>{{ $order->product->name }}</td>  <!-- Məhsul adı -->
                        <td>{{ $order->quantity }}</td>
                        <td>{{ $order->total_price }} TL</td>  <!-- Cəm qiymət -->
                        <td>
                            <span class="status {{ strtolower($order->status) }}">{{ $order->status }}</span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
