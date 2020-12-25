@extends('layouts.mst_admin')
@section('title', 'Admin '.env('APP_NAME').': Dashboard | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('admins/modules/bootstrap-datepicker/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/summernote/summernote-bs4.css')}}">
    <style>
        .bootstrap-select .dropdown-menu {
            min-width: 100% !important;
        }

        .form-control-feedback {
            position: absolute;
            top: 3em;
            right: 2em;
        }
    </style>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Welcome to Dashboard</h1>
        </div>
        <?php
        $stock_alert = \App\Models\Produk::query()->where('stock','<=',10)->get();
        ?>
        @if(!empty($stock_alert))
        <div class="row">
            <div class="col-lg-12  col-md-6">

                <div class="alert alert-danger" role="alert">
                    <span class="fa fa-info-circle"></span> PERHATIAN !! terdapat {{count($stock_alert)}} item yang akan habis, segera menambahkan stock. <a href="{{route('admin.show.produk.habis')}}" class="alert-link">Lihat keseluruhan item</a>.
                </div>
            </div>
        </div>
        @endif

        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Pelanggan</h4>
                        </div>
                        <div class="card-body">
                            {{count($users)}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Admin</h4>
                        </div>
                        <div class="card-body">
                            {{count($admins)}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-tools"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Pesanan</h4>
                        </div>
                        <div class="card-body">
                            {{count(\App\Models\Pesanan::all())}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-blog"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Inbox</h4>
                        </div>
                        <div class="card-body">
                            {{count($kontak)}}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-6 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-stats">
                        <div class="card-stats-title">Order Statistics on {{date('F - Y')}}
                        </div>
                        <div class="card-stats-items">
                            <div class="card-stats-item">
                                {{count(\App\Models\Pesanan::where('isLunas',false)->whereMonth('created_at', today()->format('m'))->get())}}
                                <div
                                    class="card-stats-item-count"></div>
                                <div class="card-stats-item-label">Belum Dibayar</div>
                            </div>
                            <div class="card-stats-item">
                                {{count(\App\Models\Pesanan::where('isLunas',true)->whereMonth('created_at', today()->format('m'))->get())}}
                                <div
                                    class="card-stats-item-count"></div>
                                <div class="card-stats-item-label">Telah Dibayar</div>
                            </div>
                            <div class="card-stats-item">
                                {{count(\App\Models\Pesanan::where('isLunas',true)->where('resi','!=',null)->whereMonth('created_at', today()->format('m'))->get())}}
                                <div
                                    class="card-stats-item-count"></div>
                                <div class="card-stats-item-label">Sedang Dikirm</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-archive"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Orders</h4>
                        </div>
                        <div class="card-body">
                            {{count(\App\Models\Pesanan::whereMonth('created_at', today()->format('m'))->get())}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-chart">
                        <canvas id="balance-chart" height="80"></canvas>
                    </div>
                    <div class="card-icon shAadow-primary bg-primary">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Income {{date('F - Y')}}</h4>
                        </div>
                        <div class="card-body">
                            <?php
                            $today = today()->format('m');
                            $income = \App\Models\Pesanan::whereMonth('created_at', $today)->get()->sum('total_harga');
                            echo "Rp" . number_format($income)
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4>Latest Invoices</h4>
                        <div class="card-header-action">
                            <a href="{{route('admin.order')}}" class="btn btn-danger">Lihat Semua <i
                                    class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive table-invoice">
                            <table class="table table-striped">
                                <tr>
                                    <th>Pembayaran ID</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Pembelian Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                                @if(empty($payment))
                                    <tr>
                                        <td colspan="5">
                                            <div class="dropdown-item-desc">
                                                <p>Tampaknya tidak ada data pembayaran untuk sementara waktu, mohon tetap di sini</p>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach($payment->take(5) as $item)
                                        <tr>
                                            <td><a href="javascript:void(0)">#{{$item->uni_code}}</a></td>
                                            <td class="font-weight-600">{{$item->getUser->name}}</td>
                                            <td>
                                                @if($item->isLunas == 1)
                                                    <div class="badge badge-success">{{strtoupper('Telah DIbayar')}}</div>
                                                @else
                                                    <div class="badge badge-warning">{{strtoupper('Belum Dibayar')}}</div>
                                                @endif
                                            </td>
                                            <td>{{\Carbon\Carbon::parse($item->updated_at)->format('d  F Y')}}</td>
                                            <td>
                                                @if($item->isLunas == 1)
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-danger"
                                                           onclick="getInvoice('{{$item->getUser->id}}','{{ucfirst($item->uni_code)}}')"
                                                           data-toggle="tooltip" title="Download Invoice"><i
                                                                class="fa fa-file-pdf"></i></a>
                                                        <a href="{{route('admin.order')}}" class="btn btn-info"
                                                           data-toggle="tooltip" title="Detail Invoice"><i
                                                                class="fa fa-info"></i></a>
                                                    </div>
                                                @else
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-danger"
                                                           onclick="getInvoice('{{$item->getUser->id}}','{{ucfirst($item->uni_code_payment)}}')" class="btn btn-danger"
                                                           data-toggle="tooltip" title="Download Invoice"><i
                                                                class="fa fa-file-pdf"></i></a>
                                                    </div>
                                                @endif

                                            </td>
                                        </tr>

                                    @endforeach
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(($role->isRoot() || $role->isOwner()) && count($kontak) > 0)
            <div class="row">
                <div class="col">
                    <div class="card card-hero">
                        <div class="card-header">
                            <div class="card-icon">
                                <i class="far fa-question-circle"></i>
                            </div>
                            <h4>{{count($kontak)}}</h4>
                            <div class="card-description">Pelanggan butuh bantuan</div>
                        </div>
                        <div class="card-body p-0">
                            <div class="tickets-list">
                                @foreach(\App\Models\Kontak::orderByDesc('id')->take(3)->get() as $row)
                                    <a href="{{route('admin.inbox',['id' => $row->id])}}" class="ticket-item">
                                        <div class="ticket-title">
                                            <h4>{{$row->subject}}</h4>
                                        </div>
                                        <div class="ticket-info">
                                            <div>{{$row->name}}</div>
                                            <div class="bullet"></div>
                                            <div class="text-primary">
                                                {{\Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</div>
                                        </div>
                                    </a>
                                @endforeach
                                <a href="{{route('admin.inbox')}}" class="ticket-item ticket-more">
                                    LIHAT SEMUA <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>
@endsection
@push('scripts')
    <script src="{{asset('admins/modules/chart.min.js')}}"></script>
    <script src="{{asset('admins/modules/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('admins/modules/summernote/summernote-bs4.js')}}"></script>
    <script>

        function getInvoice(user_id, code) {
            $.ajax({
                type: 'post',
                url: '{{route('admin.order.invoice.download')}}',
                data: {
                    _token: '{{csrf_token()}}',
                    code: code,
                    user_id: user_id
                },
                success: function (data) {
                    // swal('Success', "Plesae Wait Till Page Succesfully Realoded", 'success');
                    // setTimeout(
                    //     function () {
                    //         location.reload();
                    //     }, 5000);
                }, error: function (xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 404) {
                        console.log(xhr);
                        swal('Error', xhr.responseJSON.message, 'error');
                    }
                }
            });
        }

        var balance_chart = document.getElementById("balance-chart").getContext('2d');

        var balance_chart_bg_color = balance_chart.createLinearGradient(0, 0, 0, 70);
        balance_chart_bg_color.addColorStop(0, 'rgba(63,82,227,.2)');
        balance_chart_bg_color.addColorStop(1, 'rgba(63,82,227,0)');

        var myChart = new Chart(balance_chart, {
            type: 'bar',
            data: {
                labels: [
                    @php
                        $months = [
                            "jan" => "January",
                            "feb" => "February",
                            "mar" => "March",
                            "apr" => "April",
                            "mei" => "May",
                            "jun" => "June",
                            "jul" => "July",
                            "aug" => "August",
                            "sep" => "September",
                            "oct" => "October",
                            "nov" => "November",
                            "dec" => "December",
                        ];
                    @endphp
                        @foreach($months as $month)
                        '{{$month}}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Income (Rp)',
                    data: [
                        @php $total = 0; @endphp
                        @for($i=1;$i<=12;$i++)
                        @php
                            $today = today()->format('m');
                            $income = \App\Models\Pesanan::whereMonth('created_at', $i)->get()->sum('total_harga');
                        @endphp
                        {{$income}},
                        @endfor
                    ],
                    backgroundColor: balance_chart_bg_color,
                    borderWidth: 3,
                    borderColor: '#5bb300',
                    pointBorderWidth: 0,
                    pointBorderColor: 'transparent',
                    pointRadius: 3,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgba(63,82,227,1)',
                }]
            },
            options: {
                layout: {
                    padding: {
                        bottom: -1,
                        left: -1
                    }
                },
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            beginAtZero: true,
                            display: false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            drawBorder: false,
                            display: false,
                        },
                        ticks: {
                            display: false
                        }
                    }]
                },
            }
        });
    </script>
@endpush
