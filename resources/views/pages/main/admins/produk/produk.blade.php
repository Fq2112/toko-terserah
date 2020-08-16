@extends('layouts.mst_admin')
@section('title', __('admin.sidebar.head').': '.__('admin.tables.blog-category').' | '.env('APP_TITLE'))
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
            <h1>Daftar Produk</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Ulasan</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-form">
                                <a id="btn_create" class="btn btn-primary text-uppercase" href="{{route('admin.show.produk.tambah')}}">
                                    <strong><i class="fas fa-plus mr-2"></i>Tambah Produk</strong>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="content1" class="table-responsive">
                                <table class="table table-striped" id="dt-buttons">
                                    <thead>
                                    <tr>
                                        <th class="text-center" width="5%">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" class="custom-control-input" id="cb-all">
                                                <label for="cb-all" class="custom-control-label">#</label>
                                            </div>
                                        </th>
                                        <th class="text-center">ID</th>
                                        <th width="15%">Kode Produk</th>
                                        <th width="15%">Nama Produk</th>
                                        <th width="15%">
                                            Jenis
                                        </th>
                                        <th class="text-center" width="10%">Diskon</th>
                                        <th class="text-center" width="10%">Harga</th>
                                        <th class="text-center" width="10%">diskon Grosir</th>
                                        <th class="text-center" width="10%">harga Grosir</th>
                                        <th class="text-center" width="10%">Stok</th>
                                        <th class="text-center" width="10%">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($data as $item)
                                        <tr>
                                            <td style="vertical-align: middle" align="center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" id="cb-{{$item->id}}"
                                                           class="custom-control-input dt-checkboxes">
                                                    <label for="cb-{{$item->id}}"
                                                           class="custom-control-label">{{$no++}}</label>
                                                </div>
                                            </td>
                                            <td class="text-center">{{$item->id}}</td>
                                            <td>{!! DNS1D::getBarcodeHTML($item->barcode, 'C39') !!}</td>
                                            <td>
                                                {{$item->nama}}
                                            </td>
                                            <td>
                                                {{$item->getSubkategori->nama}}
                                            </td>
                                            <td class="text-center" width="10%">
                                                {{$item->diskon ?? '0'}} %
                                            </td>
                                            <td class="text-center" width="10%">
                                                @if($item->is_diskon == 1)
                                                    <strike> {{number_format($item->harga)}}</strike><br>
                                                    <span
                                                        class="text-danger">  {{number_format($item->harga_diskon)}}</span>
                                                @else
                                                    {{number_format($item->harga)}}
                                                @endif
                                            </td>

                                            <td class="text-center" width="10%">
                                                {{$item->diskonGrosir ?? '0'}} %
                                            </td>
                                            <td class="text-center" width="10%">
                                                @if($item->is_diskon == 1)
                                                    <strike> {{number_format($item->harga_grosir)}}</strike><br>
                                                    <span
                                                        class="text-danger">  {{number_format($item->harga_diskon_grosir)}}</span>
                                                @else
                                                    {{number_format($item->harga_grosir)}}
                                                @endif
                                            </td>
                                            <td class="text-center" width="15%">
                                                <p id="stock-{{$item->id}}">{{$item->stock}}</p>
                                                <form action="{{route('admin.show.produk.stock')}}" method="post" style="display: none"
                                                      id="form_{{$item->id}}">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="id_produk" id="" value="{{$item->id}}"
                                                           required>
                                                    <div class="input-group">
                                                    <input type="number" name="stock_produk" id="" class="form-control" min="{{$item->stock == 0 ? 1:$item->stock}}"
                                                           value="{{$item->stock}}" required>
                                                        <div class="input-group-append">
                                                            <button data-placement="right" data-toggle="tooltip"
                                                                    title="Tambah Data"
                                                                    type="submit" class="btn btn-primary" style="height: 2.25rem">
                                                                <i class="fa fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="text-center" width="10%">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" class="btn btn-success"
                                                       data-toggle="tooltip" onclick="show_input('{{$item->id}}')"
                                                       title="Tambah Stok Barang"><i class="fa fa-plus-square"></i> </a>
                                                    <a href="{{route('admin.show.produk.edit',['kode_barang'=>$item->kode_barang])}}" class="btn btn-info" data-toggle="tooltip"
                                                       title="Sunting Barang"><i class="fa fa-edit"></i> </a>
                                                    <a href="{{route('delete.produk',['id' => $item->id])}}" class="btn btn-danger  delete-data" data-toggle="tooltip"
                                                       title="Hapus Barang"><i class="fa fa-trash"></i> </a>
                                                </div>
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
            var export_filename = 'Blog Categories Table ({{now()->format('j F Y')}})',
                table = $("#dt-buttons").DataTable({
                    dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-4'f>>" +
                        "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    columnDefs: [
                        {sortable: false, targets: 6},
                        {targets: 1, visible: false, searchable: false}
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
                            extend: 'print',
                            exportOptions: {
                                columns: [0, 2, 3, 4]
                            },
                            className: 'btn btn-info assets-select-btn export-print'
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

        function openModal(code, url_action, title) {
            console.log(code);
            $.post(url_action, {
                    _token: '{{csrf_token()}}',
                    code: code
                },
                function (data) {
                    $('#customModalbody').html(data);
                });
            $('#payment_code').val(code);
            $('#customModalTitle').text(title);
            $('#customModal').modal({backdrop: 'static', keyboard: false})
        }

        function show_input(id) {
            console.log(id);
            $('#stock-' + id).toggle(300);
            $('#form_' + id).toggle(300);
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

        function get_shipping(code) {
            $.ajax({
                type: 'get',
                url: '{{route('admin.order.shipping')}}',
                data: {
                    code: code,
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



        function get_design(code) {
            $.ajax({
                type: 'post',
                url: '{{route('admin.order.production.pdf')}}',
                data: {
                    _token: '{{csrf_token()}}',
                    code: code
                },
                success: function (data) {

                    setTimeout(
                        function () {
                            $.ajax({ //Download File from above
                                type: 'post',
                                url: '{{route('admin.order.production.download')}}',
                                data: {
                                    _token: '{{csrf_token()}}',
                                    code: code
                                },
                                success: function (data) {
                                    console.log('downloaded')
                                }
                            });
                        }, 1000);


                    swal('Success', "Plesae Wait Till Page Succesfully Realoded", 'success');
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


    </script>
@endpush
