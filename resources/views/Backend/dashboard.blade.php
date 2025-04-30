@extends('Backend.main')

@section('title', 'Dashboard')
@section('page', 'Dashboard')
@section('content')
<div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div
                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">weekend</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Today's Money</p>
                    <h4 class="mb-0">
                        @isset($data['today_money'])
                        Rp.{{ number_format($data['today_money'], 0, ',', '.') }}
                        @else
                        Data not available
                        @endisset
                    </h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                <p class="mb-0">
                    @isset($data['money_change'])
                    <span class="text-success text-sm font-weight-bolder">{{ $data['money_change'] }}</span>
                    @else
                    <span class="text-warning text-sm">No change data available</span>
                    @endisset
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div
                    class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">account_balance_wallet</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Total Expenses</p>
                    <h4 class="mb-0">
                        @isset($data['expenses'])
                        Rp. {{ number_format($data['expenses'], 0, ',', '.') }}
                        @else
                        Data not available
                        @endisset
                    </h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                <p class="mb-0">
                    @isset($data['expenses_change'])
                    <span class="text-danger text-sm font-weight-bolder">{{ $data['expenses_change'] }}</span>
                    @else
                    <span class="text-warning text-sm">No change data available</span>
                    @endisset
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div
                    class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">person</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Total Users</p>
                    <h4 class="mb-0">
                        @isset($data['users'])
                        {{ number_format($data['users']) }}
                        @else
                        Data not available
                        @endisset
                    </h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                <p class="mb-0">
                    @isset($data['users_change'])
                    <span class="text-success text-sm font-weight-bolder">{{ $data['users_change'] }}</span>
                    @else
                    <span class="text-warning text-sm">No change data available</span>
                    @endisset
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div
                    class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">weekend</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Sales</p>
                    <h4 class="mb-0">
                        @isset($data['sales'])
                        Rp. {{ number_format($data['sales'], 0, ',', '.') }}
                        @else
                        Data not available
                        @endisset
                    </h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                <p class="mb-0">
                    @isset($data['sales_change'])
                    <span class="text-success text-sm font-weight-bolder">{{ $data['sales_change'] }}</span>
                    @else
                    <span class="text-warning text-sm">No change data available</span>
                    @endisset
                </p>
            </div>
        </div>
    </div>
</div>


<div class="row mt-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header pb-0">
                <h6>Grafik Tren Pendapatan</h6>
            </div>
            <div class="card-body">
                <div class="chart-container" style="position: relative; width: 100%;">
                    <img src="{{ route('chart.revenue', [
                        'labels' => json_encode($data['sales_labels']),
                        'data' => json_encode($data['sales_data']),
                        'month' => now()->format('F'),
                        'year' => now()->year
                    ]) }}" class="img-fluid" alt="Grafik Tren Pendapatan"
                        style="max-height: 400px; display: block; margin: auto;" />
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header pb-0">
                <h6>Grafik Tren Pengeluaran</h6>
            </div>
            <div class="card-body">
                <div class="chart-container" style="position: relative; width: 100%;">
                    <img src="{{ route('chart.expense', [
                        'labels' => json_encode($data['expense_labels']),
                        'data' => json_encode($data['expense_data']),
                        'month' => now()->format('F'),
                        'year' => now()->year
                    ]) }}" class="img-fluid" alt="Grafik Tren Pengeluaran"
                        style="max-height: 400px; display: block; margin: auto;" />
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row mt-4">
    <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-lg-6 col-7">
                        <h6>Sales Details</h6>
                        <p class="text-sm mb-0">
                            <i class="fa fa-check text-info" aria-hidden="true"></i>
                            <span class="font-weight-bold">{{ $data['sales_details']->count() }} items</span> sold
                            this
                            month
                        </p>
                    </div>
                    <div class="col-lg-6 col-5 my-auto text-end">
                        <div class="dropdown float-lg-end pe-4">
                            <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fa fa-ellipsis-v text-secondary"></i>
                            </a>
                            <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                                <li><a class="dropdown-item border-radius-md" href="javascript:;">Action</a></li>
                                <li><a class="dropdown-item border-radius-md" href="javascript:;">Another action</a>
                                </li>
                                <li><a class="dropdown-item border-radius-md" href="javascript:;">Something else
                                        here</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Product
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Quantity</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Price</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    SubTotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['sales_details'] as $detail)
                            @php
                            $pricePerUnit = $detail->quantity > 0 ? $detail->subtotal / $detail->quantity : 0;
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="{{ asset('storage/' . $detail->product->image) }}"
                                                class="avatar avatar-sm me-3" alt="{{ $detail->product->name }}">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $detail->product->product_name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-xs font-weight-bold">{{ $detail->quantity }}</span>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span
                                        class="text-xs font-weight-bold">Rp.{{ number_format($pricePerUnit, 2) }}</span>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-xs font-weight-bold">Rp.
                                        {{ number_format($detail->subtotal, 2) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-4 col-md-6">
        <div class="card h-100">
            <div class="card-header pb-0">
                <h6>Orders Overview</h6>
                <p class="text-sm">
                    <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                    <span class="font-weight-bold">{{ $recentOrders->count() }}</span> orders this month
                </p>
            </div>
            <div class="card-body p-3">
                <div class="timeline timeline-one-side">
                    @forelse($recentOrders as $order)
                    <div class="timeline-block mb-3">
                        <span class="timeline-step">
                            <i class="material-icons text-success text-gradient">shopping_cart</i>
                        </span>
                        <div class="timeline-content">
                            <h6 class="text-dark text-sm font-weight-bold mb-0">
                                Order #{{ $order->id }} - Rp.{{ number_format($order->total_amount, 0, ',', '.') }}
                            </h6>
                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                {{ $order->formatted_date }}
                            </p>
                            <div class="alert alert-info py-2 px-2 d-inline-block text-white text-xs font-weight-bold">
                                <i class="fas fa-check-circle"></i> Diproses
                            </div>
                            <p class="text-sm text-muted mb-0">
                                <i class="fas fa-user text-info"></i> {{ $order->user->nama ?? 'Guest' }}
                            </p>
                            <p class="text-sm text-muted">
                                <i class="fas fa-money-bill text-warning"></i>
                                {{ $order->paymentMethod->method_name ?? 'Unknown' }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="timeline-block mb-3">
                        <span class="timeline-step">
                            <i class="material-icons text-dark text-gradient">info</i>
                        </span>
                        <div class="timeline-content">
                            <h6 class="text-dark text-sm font-weight-bold mb-0">No recent orders</h6>
                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                There are no orders to display.
                            </p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>




</div>

<style>
.chart-container {
    overflow: hidden;
    text-align: center;
    max-height: 400px;
}
</style>


@endsection