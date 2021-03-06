@extends('layouts.mst_admin')
@section('title', 'Admin '.env('APP_NAME').': List Data Pesanan | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/datatables.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('admins/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Buttons-1.5.6/css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/summernote/summernote-bs4.css')}}">
    <style>
        .fix-label-group .bootstrap-select {
            padding: 0 !important;
        }

        .bootstrap-select .dropdown-menu {
            min-width: 100% !important;
        }

        .form-control-feedback {
            position: absolute;
            top: 3em;
            right: 2em;
        }

        .modal-header {
            padding: 1rem !important;
            border-bottom: 1px solid #e9ecef !important;
        }

        .modal-footer {
            padding: 1rem !important;
            border-top: 1px solid #e9ecef !important;
        }

        label {
            width: 100%;
            font-size: 1rem;
        }

        .card-input-element + .card {
            height: calc(45px + 2 * 1rem);
            color: var(--primary);
            -webkit-box-shadow: none;
            box-shadow: none;
            border: 2px solid transparent;
            border-radius: 4px;
        }

        .card-input-element + .card:hover {
            cursor: pointer;
        }

        .card-input-element:checked + .card {
            border: 2px solid #f89406;
            -webkit-transition: border .3s;
            -o-transition: border .3s;
            transition: border .3s;
        }

        .card-input-element:checked + .card::after {
            font-family: "Font Awesome 5 Free";
            content: "\f14a";
            color: #f89406;
            font-size: 24px;
            -webkit-animation-name: fadeInCheckbox;
            animation-name: fadeInCheckbox;
            -webkit-animation-duration: .5s;
            animation-duration: .5s;
            -webkit-animation-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            animation-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        @-webkit-keyframes fadeInCheckbox {
            from {
                opacity: 0;
                -webkit-transform: rotateZ(-20deg);
            }
            to {
                opacity: 1;
                -webkit-transform: rotateZ(0deg);
            }
        }

        @keyframes fadeInCheckbox {
            from {
                opacity: 0;
                transform: rotateZ(-20deg);
            }
            to {
                opacity: 1;
                transform: rotateZ(0deg);
            }
        }

    </style>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Riwayat Pemesanan & Status Pesanan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Order History</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route(Route::currentRouteName())}}"
                                  method="get">
                                <div class="row form-group">
                                    <div class="col-3 fix-label-group">
                                        <label for="period">Time Period</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text fix-label-item" style="height: 2.25rem">
                                                    <i class="fa fa-calendar-week"></i></span>
                                            </div>
                                            <select id="period" class="form-control selectpicker" title="-- Choose --"
                                                    name="period" data-live-search="true">
                                                <option value="99999">{{strtoupper('all')}}</option>
                                                <option value="7">{{strtoupper('One Week')}}</option>
                                                <option value="30">{{strtoupper('One Month')}}</option>
                                                <option value="90">{{strtoupper('Three Months')}}</option>
                                                <option value="180">{{strtoupper('Six Months')}}</option>
                                                <option value="360">{{strtoupper('One Year')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3 fix-label-group">
                                        <label for="status">Status Payment</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                                                    <span
                                                                                        class="input-group-text fix-label-item"
                                                                                        style="height: 2.25rem">
                                                                                        <i class="fa fa-tag"></i></span>
                                            </div>
                                            <select id="status" class="form-control selectpicker" title="-- Choose --"
                                                    name="status" data-live-search="true">
                                                <option value="">{{strtoupper('all')}}</option>
                                                <option value="1">{{strtoupper('Paid')}}</option>
                                                <option value="false">{{strtoupper('Unppaid')}}</option>
                                            </select>
                                            <div class="input-group-append">
                                                <button data-placement="right" data-toggle="tooltip"
                                                        title="Submit Filter"
                                                        type="submit" class="btn btn-primary" style="height: 2.25rem">
                                                    <i class="fa fa-filter"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="content1" class="table-responsive">
                                <table class="table table-striped" id="dt-buttons">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th width="15%">Kode</th>
                                        <th width="20%">Customer</th>
                                        <th width="15%">
                                            <center>Kurir</center>
                                        </th>
                                        <th class="text-center" width="10%">Tanggal Pesanan</th>
                                        <th class="text-center" width="10%">Status Pembayaran</th>
                                        <th class="text-center" width="10%">Resi</th>
                                        <th class="text-center" width="10%">Tgl Pengiriman</th>
                                        <th class="text-center" width="10%">Tgl Diterima</th>
                                        <th width="25%" align="center">
                                            <center>Action</center>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($data as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td width="15%"  data-placement="top"
                                                data-toggle="tooltip"
                                                title="{{ucfirst($item->uni_code)}}">{{\Illuminate\Support\Str::limit(ucfirst($item->uni_code),15,'...')}}</td>
                                            <td width="20%">{{$item->getUser->name}} <br>
                                                <a  href="tel:{{$item->getUser->getBio->phone}}" class="text-primary">{{$item->getUser->getBio->phone}} </a>
                                            </td>
                                            <td width="15%" align="center">
                                                @if($item->is_kurir_terserah)
                                                    <img src="{{asset('images/logotype.png')}}" alt="" width="50px">
                                                    <br>
                                                    Kurir Toko Terserah
                                                @else
                                                    <img src="{{asset('images/kurir/'.$item->kode_kurir.'.png')}}" alt="" width="50px"> <br>
                                                    {{strtoupper($item->kode_kurir)}}
                                                @endif
                                            </td>

                                            <td class="text-center" width="10%">{{$item->updated_at}}</td>
                                            <td class="text-center" width="10%">
                                                @if($item->isLunas == 1)
                                                    <div class="badge badge-success" data-placement="top"
                                                         data-toggle="tooltip"
                                                         title="Telah Dibayar"><i class="fa fa-check"></i></div>
                                                @else
                                                    <div class="badge badge-danger" data-placement="top"
                                                         data-toggle="tooltip"
                                                         title="Belum Dibayar"><i class="fa fa-window-close"></i></div>
                                                @endif
                                            </td>
                                            <td class="text-center" width="10%">
                                                @if($item->is_kurir_terserah)
                                                    <div class="badge badge-info" data-placement="top"
                                                         data-toggle="tooltip"
                                                         title="Resi Tidak Tersedia Untuk Kurir Terserah"><i
                                                            class="fa fa-info-circle"></i></div>
                                                @else
                                                    @if($item->isAmbil)
                                                        <div class="badge badge-info" data-placement="top"
                                                             data-toggle="tooltip"
                                                             title="Pelanggan Ambil Sendiri"><i
                                                                class="fa fa-shopping-basket"></i></div>
                                                    @else
                                                        @if($item->resi == null | $item->resi == "")

                                                            <div class="badge badge-danger" data-placement="top"
                                                                 data-toggle="tooltip"
                                                                 title="Resi Belum Terpasang"><i
                                                                    class="fa fa-window-close"></i></div>
                                                        @else
                                                            {{$item->resi}}
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="text-center" width="10%">
                                                {{$item->tgl_pengiriman ?? ' - '}}
                                            </td>
                                            <td class="text-center" width="10%">
                                                {{$item->tgl_diterima ?? ' - '}}
                                            </td>
                                            <td width="25%" align="center">
                                                <?php
                                                $order = \App\Models\Pesanan::where('uni_code', $item->uni_code)->get()
                                                ?>
                                                @if($item->isLunas == 1)
                                                    <div class="btn-group">
                                                        @if($item->is_kurir_terserah)
                                                            @if($item->tgl_pengiriman == null)
                                                                <a href="{{route('order.berangkat',['id' => encrypt( $item->id)])}}"
                                                                   class="btn btn-success  delete-data"
                                                                   data-toggle="tooltip"
                                                                   title="Tandai Order Telah Dikirm"><i
                                                                        class="fa fa-shipping-fast"></i> </a>
                                                                @else
                                                                @if($item->tgl_diterima == null)
                                                                <a href="{{route('order.diterima',['id' => encrypt( $item->id)])}}"
                                                                   class="btn btn-warning  delete-data"
                                                                   data-toggle="tooltip"
                                                                   title="Tandai Order Telah Diterima"><i
                                                                        class="fa fa-check"></i> </a>
                                                                    @endif
                                                            @endif
                                                        @else
                                                            @if($item->isAmbil)

                                                            @else
                                                                @if($item->resi == null | $item->resi == "")
                                                                    <button type="button" class="btn btn-warning"
                                                                            data-toggle="tooltip"
                                                                            onclick="openModal('{{$item->id}}','{{$item->uni_code}}')"
                                                                            title="Tambahkan Resi" data-html="true"
                                                                            data-placement="top"><i
                                                                            class="fa fa-plus-square" aria-hidden="true"></i>
                                                                    </button>
                                                                @else
                                                                    <button type="button" class="btn btn-light"
                                                                            data-toggle="tooltip"
                                                                            onclick="openModalEdit('{{$item->id}}','{{$item->uni_code}}','{{$item->resi}}')"
                                                                            title="Sunting Resi" data-html="true"
                                                                            data-placement="top"><i
                                                                            class="fa fa-edit"></i>
                                                                    </button>
                                                                @endif

                                                            @endif
                                                        @endif
                                                        <div class="dropdown">
                                                            <button class="btn btn-primary dropdown-toggle"
                                                                    type="button" id="dropdownMenuButton"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false"><i
                                                                    class="fa fa-file-download"></i>
                                                                Download
                                                            </button>
                                                            <div class="dropdown-menu"
                                                                 aria-labelledby="dropdownMenuButton">
                                                                <a class="dropdown-item"
                                                                   href="{{route('admin.order.invoice.get',['user_id'=>$item->getUser->id,
                                                                    'code' => $item->uni_code])}}">Invoice</a>
                                                                @if($item->isAmbil)
                                                                @else
                                                                    <a class="dropdown-item"
                                                                       href="{{route('order.label.download',['code'=>$item->uni_code])}}">Label
                                                                        Pengiriman</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <a href="{{route('admin.order.user',['kode'=>$item->uni_code])}}"
                                                           data-placement="right" data-toggle="tooltip" target="_blank"
                                                           title="Detail Info" type="button" class="btn btn-info">
                                                            <i class="fa fa-info-circle"></i></a>
                                                    </div>
                                                @else
                                                    <div class="btn-group">
                                                        <a class="btn btn-danger"
                                                           href="{{route('admin.order.invoice.get',['user_id'=>$item->getUser->id,
                                                                    'code' => $item->uni_code])}}"
                                                           data-toggle="tooltip"
                                                           title="Download Invoice" data-html="true"
                                                           data-placement="top"><i class="fa fa-file-pdf"></i>
                                                        </a>
                                                        <a href="{{route('admin.order.user',['kode'=>$item->uni_code])}}"
                                                           data-placement="right" data-toggle="tooltip" target="_blank"
                                                           title="Detail Info" type="button" class="btn btn-info">
                                                            <i class="fa fa-info-circle"></i></a>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <form method="post" id="form-mass">
                                    {{csrf_field()}}
                                    <input type="hidden" name="category_ids">
                                </form>
                                <form method="post" id="form-mass">
                                    {{csrf_field()}}
                                    <input type="hidden" name="post_ids">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade " id="modalResi" tabindex="-1" role="dialog"
         aria-labelledby="blogCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 100%">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-light">Resi </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-blogCategory" method="post" action="{{route('order.resi')}}">
                    {{csrf_field()}}
                    <input type="hidden" name="_method">
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <label for="name">Nomor Pesanan</label>
                                <div class="input-group">
                                    <div>
                                        <h6 id="pesanan"></h6>
                                        <input type="hidden" name="id" id="id_pesanan">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label for="name">Resi <sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="text" name="resi" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade " id="modalResiEdit" tabindex="-1" role="dialog"
         aria-labelledby="blogCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 100%">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-light">Sunting Resi </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-blogCategory" method="post" action="{{route('order.resi.update')}}">
                    {{csrf_field()}}
                    <input type="hidden" name="_method">
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <label for="name">Nomor Pesanan</label>
                                <div class="input-group">
                                    <div>
                                        <h6 id="pesanan_edit"></h6>
                                        <input type="hidden" name="id" id="id_pesanan_edit">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label for="name">Resi <sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="text" name="resi" class="form-control" id="resi_edit">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade " id="modal_export" tabindex="-1" role="dialog"
         aria-labelledby="blogCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 100%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cetak Report</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-blogCategory" method="post" action="{{route('admin.order.print')}}"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Periode :</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="date" class="form-control" id="start_data" name="start">
                                </div>

                                <div class="col-6">
                                    <input type="date" class="form-control" id="end_data" name="end">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jenis" class="col-form-label">Status :</label>
                            <select name="jenis" class="form-control">
                                <option value="all">Semua</option>
                                <option value="true">Telah Dibayarkan</option>
                                <option value="false">Belum Dibayarkan</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push("scripts")
    <script src="{{asset('admins/modules/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Buttons-1.5.6/js/buttons.dataTables.min.js')}}"></script>
    <script src="{{asset('admins/modules/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{asset('admins/modules/summernote/summernote-bs4.js')}}"></script>
    <script>
        $(function () {

            $('#start_data').attr({
                "max": new Date().toISOString().split("T")[0]
            });

            $('#end_data').attr({
                "max": new Date().toISOString().split("T")[0]
            });


            var export_filename = 'Blog Categories Table ({{now()->format('j F Y')}})',
                table = $("#dt-buttons").DataTable({
                    dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-4'f>>" +
                        "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    columnDefs: [
                        {sortable: false, targets: 8},
                    ],
                    buttons: [
                        {
                            text: '<strong class="text-uppercase"><i class="far fa-clipboard mr-2"></i>Copy</strong>',
                            extend: 'copy',
                            exportOptions: {
                                columns: [0, 2, 3, 4]
                            },
                            className: 'btn btn-warning assets-export-btn export-copy ttip'
                        }, {
                            text: '<strong class="text-uppercase"><i class="far fa-file-excel mr-2"></i>Excel</strong>',
                            extend: 'excel',
                            exportOptions: {
                                columns: [0, 2, 3, 4]
                            },
                            className: 'btn btn-success assets-export-btn export-xls ttip',
                            title: export_filename,
                            extension: '.xls'
                        }, {
                            text: '<strong class="text-uppercase"><i class="fa fa-print mr-2"></i>Print</strong>',
                            exportOptions: {
                                columns: [0, 2, 3, 4]
                            },
                            className: 'btn btn-info assets-select-btn export-print',
                            action: function (e, dt, node, config) {
                                open_export();
                            }
                        },
                        // {
                        //     text: '<strong class="text-uppercase"><i class="fa fa-trash-alt mr-2"></i>Deletes</strong>',
                        //     className: 'btn btn-danger btn_massDelete'
                        // }
                    ],
                    fnDrawCallback: function (oSettings) {
                        $('.use-nicescroll').getNiceScroll().resize();
                        $('[data-toggle="tooltip"]').tooltip();
                        $('[data-toggle="popover"]').popover();

                        $("#cb-all").on('click', function () {
                            if ($(this).is(":checked")) {
                                $("#dt-buttons tbody tr").addClass("terpilih")
                                    .find('.dt-checkboxes').prop("checked", true).trigger('change');
                            } else {
                                $("#dt-buttons tbody tr").removeClass("terpilih")
                                    .find('.dt-checkboxes').prop("checked", false).trigger('change');
                            }
                        });

                        $("#dt-buttons tbody tr").on("click", function () {
                            $(this).toggleClass("terpilih");
                            if ($(this).hasClass('terpilih')) {
                                $(this).find('.dt-checkboxes').prop("checked", true).trigger('change');
                            } else {
                                $(this).find('.dt-checkboxes').prop("checked", false).trigger('change');
                            }
                        });

                        $('.dt-checkboxes').on('click', function () {
                            if ($(this).is(':checked')) {
                                $(this).parent().parent().parent().addClass("terpilih");
                            } else {
                                $(this).parent().parent().parent().removeClass("terpilih");
                            }
                        });
                    },
                });
        });

        function open_export() {

            $('#modal_export').modal('show')
        }

        function openModal(id_tanya, tanya) {
            $('#id_pesanan').val(id_tanya);
            $('#pesanan').text(tanya);
            $('#modalResi').modal('show')
        }

        function openModalEdit(id_tanya, tanya, resi) {
            $('#id_pesanan_edit').val(id_tanya);
            $('#pesanan_edit').text(tanya);
            $('#resi_edit').val(resi);
            $('#modalResiEdit').modal('show')
        }

        function getPhoneAgent(phone, name) {
            $("#agent_name").val(name);
            $("#agent_phone").val(phone);
        }

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

        @if(request()->has('period'))
        $('#period').val('{{ request()->get('period') }}');
        @endif

        @if(request()->has('status'))
        $('#status').val('{{ request()->get('status') }}');

        @endif


        /*
        function get_label(code) {
            console.log(code);
            $.ajax({
                type: 'post',
                url: '{{route('order.label')}}',
                data: {
                    _token: '{{csrf_token()}}',
                    code: code
                },
                success: function (data) {
                    setTimeout(
                        function () {
                            $.ajax({ //Download File from above
                                type: 'post',
                                url: '',
                                data: {
                                    _token: '{{csrf_token()}}',
                                    code: code
                                },
                                success: function (data) {
                                    console.log('downloaded')
                                }
                            });
                        }, 1000);


                    swal('Success', "Tunggu Hingga Halam Berhasil Reload", 'success');
                    setTimeout(
                        function () {
                            location.reload();
                        }, 5000);


                }, error: function (xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 500) {
                        console.log(xhr);
                        swal('Error', xhr.responseJSON.error, 'error');
                    }
                }
            });
        }
            */

    </script>
@endpush
