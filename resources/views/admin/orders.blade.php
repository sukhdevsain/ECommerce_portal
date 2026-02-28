@extends('admin.includes.main')
@push('title')
<title>Orders</title>
@endpush

@php
    $orders = App\Models\Order::with('billing', 'items.product.category')->get();
@endphp

@section('content')
        
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                    <div class="card p-4 mt-4">
                            <div class="row">
                                <div class="col-xl-12 col-md-12">
                                    <div class="d-flex">
                                        <h4>Orders</h4>
                                        
                                    </div>
                                    <div class="mt-3">
                                        <table id="datatablesSimple">
                                            <thead>
                                                <tr>
                                                <th scope="col">Order Id</th>
                                                <th scope="col">Customer Name</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Commission (%)</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                           <tbody>
                                                @foreach($orders as $order)
                                                <tr>
                                                    <td>{{ $order->order_no }}</td>
                                                    <td>{{ $order->billing?->fullname ?? 'N/A' }}</td>
                                                    <td>₹ {{ $order->total }}</td>
                                                    <td>
                                                        @php $commissionTotal = 0; @endphp
                                                        @foreach ($order->items as $item)
                                                            @php
                                                                $commissionPercent = $item->product->category->c_commission ?? 0;
                                                                $commissionTotal += ($item->total * $commissionPercent) / 100;
                                                            @endphp
                                                        @endforeach
                                                        {{ number_format($commissionTotal, 2) }}
                                                    </td>
                                                    @php
                                                        $statusClass = match($order->status){
                                                            'pending' => 'text-bg-secondary',
                                                            'processing' => 'text-bg-warning',
                                                            'on the way' => 'text-bg-info',
                                                            'delivered' => 'text-bg-success',
                                                            default => 'text-bg-light',
                                                        };
                                                    @endphp
                                                    <td>
                                                        <span class="badge rounded-pill {{ $statusClass }}">{{ $order->status }}</span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('admin/order-detail/' . $order->order_id) }}" class="btn btn-warning btn-sm">
                                                            <i class="fa-regular fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                        
                                </div>
                            </div>
                        </div>      
                    </div>
                </main>


                

@endsection
                