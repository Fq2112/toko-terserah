<div class="card card-input">
    <div class="row">
        <div class="col-lg-12">
            <div class="media">
                <div class="content-area align-self-center ml-3" data-toggle="tooltip" data-placement="bottom"
                     title="Sunting Alamat" style="cursor: pointer"
                     onclick="editAddress('{{$row->nama}}','{{$row->telp}}','{{$row->lat}}','{{$row->long}}',
                         '{{$row->kota_id}}','{{$row->alamat}}','{{$row->kode_pos}}','{{$row->getOccupancy->id}}',
                         '{{$row->getOccupancy->name}}','{{$row->isUtama}}',
                         '{{route('user.profil-alamat.update', ['id' => $row->id])}}')">
                    <img alt="icon" width="100" src="{{asset('images/icons/occupancy/'.$row->getOccupancy->image)}}">
                    <div class="custom-overlay">
                        <div class="custom-text">
                            <i class="icon-edit icon-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="ml-3 media-body" onclick="getShipping('{{$row->area_id}}',
                    '{{$row->lat.','.$row->long}}','{{$check}}','{{$occupancy}}')">
                    <h5 class="mt-3 mb-1">
                        <i class="icon-building mr-1"></i>{{$row->getOccupancy->name}}
                        {!! $row->isUtama == false ? '' : '<span style="font-weight: 500;color: unset">[Alamat Utama]</span>'!!}
                    </h5>
                    <blockquote class="mb-3" style="font-size: 14px;text-transform: none">
                        <table class="m-0" style="font-size: 14px">
                            <tr data-toggle="tooltip" data-placement="left" title="Nama Lengkap">
                                <td><i class="icon-id-card"></i></td>
                                <td>&nbsp;</td>
                                <td>{{$row->nama}}</td>
                            </tr>
                            <tr data-toggle="tooltip" data-placement="left" title="Nomor Telepon">
                                <td><i class="icon-phone"></i></td>
                                <td>&nbsp;</td>
                                <td>{{$row->telp}}</td>
                            </tr>
                            <tr data-toggle="tooltip" data-placement="left" title="Kabupaten/Kota">
                                <td><i class="icon-city"></i></td>
                                <td>&nbsp;</td>
                                <td>{{$row->getKota->getProvinsi->nam.', '.$row->getKota->nama}}</td>
                            </tr>
                            <tr data-toggle="tooltip" data-placement="left" title="Alamat Lengkap">
                                <td><i class="icon-map-marker-alt"></i></td>
                                <td>&nbsp;</td>
                                <td>{{$row->alamat.' - '.$row->kode_pos}}</td>
                            </tr>
                        </table>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
</div>
