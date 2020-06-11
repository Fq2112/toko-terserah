@extends('layouts.mst')
@section('title', 'Syarat dan Ketentuan | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('vendor/bootstrap-toc/bootstrap-toc.min.css')}}">
    <style>
        nav[data-toggle=toc] {
            margin-top: 30px;
        }

        .affix {
            border: 1px solid #eee;
            max-height: 90%;
            overflow-y: auto;
        }

        .affix-bottom {
            position: absolute;
        }

        nav[data-toggle=toc] .nav > li > a {
            font-size: 16px;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        nav[data-toggle=toc] .nav .nav > li > a {
            font-size: 14px;
            padding: 8px;
        }

        @media (max-width: 768px) {
            nav.affix[data-toggle='toc'] {
                position: static;
            }

            nav[data-toggle=toc] .nav .active .nav {
                display: none;
            }
        }
    </style>
@endpush
@section('content')
    <section class="none-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <nav id="toc" data-spy="affix" data-toggle="toc"></nav>
                </div>
                <div class="col-lg-8">
                    <h2> Selamat datang di {{env ('APP_NAME')}}! </h2>
                    <p> Syarat dan ketentuan ini menguraikan aturan dan peraturan untuk penggunaan Situs
                        Web {{env ('APP_NAME')}}, yang berlokasi di tokoterserah.com. </p>
                    <p> Dengan mengakses situs web ini, kami menganggap Anda menerima syarat dan ketentuan ini. Jangan
                        terus menggunakan {{env ('APP_NAME')}} jika Anda tidak setuju untuk mengambil semua syarat dan
                        ketentuan yang dinyatakan di halaman ini. Syarat dan Ketentuan kami dibuat dengan bantuan <a
                            href="https://www.privacypolicyonline.com/terms-conditions-generator/"> Syarat & Ketentuan
                            Generator Online </a> dan <a href=" https://www.termsconditionsgenerator.com "> Generator
                            Syarat & Ketentuan Gratis </a>. </p>
                    <p> Terminologi berikut ini berlaku untuk Syarat dan Ketentuan ini, Pernyataan Privasi dan
                        Pemberitahuan Sangkalan dan semua Perjanjian: "Klien", "Anda" dan "Anda" merujuk kepada Anda,
                        orang yang masuk ke situs web ini dan mematuhi persyaratan Perusahaan dan kondisi. "Perusahaan",
                        "Diri Kami", "Kami", "Kami" dan "Kami", mengacu pada Perusahaan kami. "Pihak", "Pihak", atau
                        "Kami", mengacu pada Klien dan diri kami sendiri. Semua istilah mengacu pada penawaran,
                        penerimaan, dan pertimbangan pembayaran yang diperlukan untuk melakukan proses bantuan kami
                        kepada Klien dengan cara yang paling tepat untuk tujuan yang jelas dalam memenuhi kebutuhan
                        Klien sehubungan dengan penyediaan layanan yang dinyatakan Perusahaan, sesuai dengan dan tunduk
                        pada, hukum Belanda yang berlaku. Setiap penggunaan terminologi di atas atau kata-kata lain
                        dalam bentuk tunggal, jamak, huruf besar dan / atau dia, dianggap dapat dipertukarkan dan oleh
                        karena itu merujuk pada hal yang sama. </p>
                    <h2>Cookies</h2>
                    <p> Kami menggunakan penggunaan cookie. Dengan mengakses {{env ('APP_NAME')}}}, Anda setuju untuk
                        menggunakan cookie sesuai dengan {{env ('APP_NAME')}} Kebijakan Privasi. </p>
                    <p> Sebagian besar situs web interaktif menggunakan cookie untuk memungkinkan kami mengambil detail
                        pengguna untuk setiap kunjungan. Cookie digunakan oleh situs web kami untuk mengaktifkan
                        fungsionalitas area tertentu agar lebih mudah bagi orang yang mengunjungi situs web kami.
                        Beberapa mitra afiliasi / iklan kami juga dapat menggunakan cookie. </p>
                    <h2>Lisensi</h2>
                    <p> Kecuali dinyatakan sebaliknya, {{env ('APP_NAME')}} dan / atau pemberi lisensinya memiliki hak
                        kekayaan intelektual untuk semua materi di {{env ('APP_NAME')}}. Semua hak kekayaan intelektual
                        dilindungi. Anda dapat mengakses ini dari {{env ('APP_NAME')}} untuk penggunaan pribadi Anda
                        dengan batasan yang diatur dalam syarat dan ketentuan ini. </p>
                    <p> Anda tidak boleh: </p>
                    <ul>
                        <li> Publikasikan ulang materi dari {{env ('APP_NAME')}} </li>
                        <li> Jual, sewa, atau materi sub-lisensi dari {{env ('APP_NAME')}} </li>
                        <li> Reproduksi, duplikat, atau salin materi dari {{env ('APP_NAME')}} </li>
                        <li> Distribusi ulang konten dari {{env ('APP_NAME')}} </li>
                    </ul>
                    <p> Perjanjian ini akan dimulai pada tanggal perjanjian ini. </p>
                    <p> Bagian dari situs web ini menawarkan kesempatan bagi pengguna untuk mengirim dan bertukar
                        pendapat dan informasi di area situs web tertentu. {{env ('APP_NAME')}} tidak memfilter,
                        mengedit, menerbitkan atau meninjau Komentar sebelum kehadiran mereka di situs web. Komentar
                        tidak mencerminkan pandangan dan pendapat {{env ('APP_NAME')}}, agen dan / atau afiliasinya.
                        Komentar mencerminkan pandangan dan pendapat orang yang memposting pandangan dan pendapat
                        mereka. Sejauh diizinkan oleh undang-undang yang berlaku, {{env ('APP_NAME')}} tidak akan
                        bertanggung jawab atas Komentar atau untuk setiap kewajiban, kerusakan atau biaya yang
                        disebabkan dan / atau diderita sebagai akibat dari penggunaan dan / atau pengeposan dari dan /
                        atau tampilan Komentar di situs web ini. </p>
                    <p> {{env ('APP_NAME')}} berhak untuk memantau semua Komentar dan menghapus Komentar apa pun yang
                        dapat dianggap tidak pantas, menyinggung, atau menyebabkan pelanggaran terhadap Syarat dan
                        Ketentuan ini. </p>
                    <p> Anda menjamin dan menyatakan bahwa: </p>
                    <ul>
                        <li> Anda berhak memposting Komentar di situs web kami dan memiliki semua lisensi dan
                            persetujuan yang diperlukan untuk melakukannya;
                        </li>
                        <li> Komentar tidak melanggar hak kekayaan intelektual apa pun, termasuk tanpa batasan hak
                            cipta, paten, atau merek dagang pihak ketiga mana pun;
                        </li>
                        <li> Komentar tidak mengandung materi yang memfitnah, memfitnah, menyinggung, tidak senonoh,
                            atau melanggar hukum yang merupakan pelanggaran privasi
                        </li>
                        <li> Komentar tidak akan digunakan untuk meminta atau mempromosikan bisnis atau kebiasaan atau
                            menyajikan aktivitas komersial atau aktivitas yang melanggar hukum.
                        </li>
                    </ul>
                    <p> Anda dengan ini memberikan {{env ('APP_NAME')}} lisensi non-eksklusif untuk menggunakan,
                        mereproduksi, mengedit, dan mengotorisasi orang lain untuk menggunakan, mereproduksi, dan
                        mengedit Komentar Anda dalam setiap dan semua bentuk, format, atau media. </p>
                    <h2>Hyperlink ke Konten kami</h2>
                    <p> Organisasi berikut dapat menautkan ke situs web kami tanpa persetujuan tertulis sebelumnya: </p>
                    <ul>
                        <li> Instansi pemerintah;</li>
                        <li> Mesin pencari;</li>
                        <li> Organisasi berita;</li>
                        <li> Distributor direktori online dapat menautkan ke Situs Web kami dengan cara yang sama
                            seperti mereka melakukan hyperlink ke Situs-situs web bisnis terdaftar lainnya; dan
                        </li>
                        <li> Bisnis Terakreditasi di Seluruh Sistem kecuali meminta organisasi nirlaba, pusat
                            perbelanjaan amal, dan kelompok penggalangan dana amal yang mungkin tidak hyperlink ke situs
                            Web kami.
                        </li>
                    </ul>
                    <p> Organisasi-organisasi ini dapat menautkan ke beranda kami, ke publikasi atau ke informasi Situs
                        Web lainnya selama tautan: (a) sama sekali tidak menipu; (B) tidak secara tidak langsung
                        menyiratkan sponsor, dukungan atau persetujuan dari pihak yang menghubungkan dan produk dan /
                        atau layanannya; dan (c) sesuai dengan konteks situs pihak yang menghubungkan. </p>
                    <p> Kami dapat mempertimbangkan dan menyetujui permintaan tautan lain dari jenis organisasi
                        berikut: </p>
                    <ul>
                        <li> sumber informasi konsumen dan / atau bisnis yang umum dikenal;</li>
                        <li> situs komunitas dot.com;</li>
                        <li> asosiasi atau grup lain yang mewakili amal;</li>
                        <li> distributor direktori online;</li>
                        <li> portal internet;</li>
                        <li> perusahaan akuntansi, hukum, dan konsultan; dan</li>
                        <li> lembaga pendidikan dan asosiasi perdagangan.</li>
                    </ul>
                    <p> Kami akan menyetujui permintaan tautan dari organisasi-organisasi ini jika kami memutuskan
                        bahwa: (a) tautan tersebut tidak akan membuat kami terlihat tidak menguntungkan bagi diri kami
                        sendiri atau bisnis terakreditasi kami; (B) organisasi tidak memiliki catatan negatif dengan
                        kami; (c) manfaat bagi kami dari visibilitas hyperlink mengkompensasi
                        ketiadaan {{env ('APP_NAME')}}; dan (d) tautannya ada dalam konteks informasi sumber daya
                        umum. </p>
                    <p> Organisasi-organisasi ini dapat menautkan ke beranda kami selama tautan tersebut: (a) sama
                        sekali tidak menipu; (B) tidak secara tidak langsung menyiratkan sponsor, dukungan atau
                        persetujuan dari pihak yang menghubungkan dan produk atau layanannya; dan (c) sesuai dengan
                        konteks situs pihak yang menghubungkan. </p>
                    <p> Jika Anda salah satu organisasi yang tercantum dalam paragraf 2 di atas dan tertarik untuk
                        menautkan ke situs web kami, Anda harus memberi tahu kami dengan mengirim email
                        ke {{env ('APP_NAME')}}. Harap sertakan nama Anda, nama organisasi Anda, informasi kontak serta
                        URL situs Anda, daftar URL apa pun yang ingin Anda tautkan ke Situs web kami, dan daftar URL di
                        situs kami yang ingin Anda kunjungi tautan. Tunggu 2-3 minggu untuk tanggapan. </p>
                    <p> Organisasi yang disetujui dapat hyperlink ke Situs web kami sebagai berikut: </p>
                    <ul>
                        <li> Dengan menggunakan nama perusahaan kami; atau</li>
                        <li> Dengan menggunakan pencari sumber daya seragam yang ditautkan ke; atau</li>
                        <li> Dengan menggunakan uraian lain apa pun dari Situs Web kami yang ditautkan dengan yang masuk
                            akal dalam konteks dan format konten di situs pihak yang menautkan.
                        </li>
                    </ul>
                    <p> Tidak ada penggunaan logo {{env ('APP_NAME')}} atau karya seni lainnya akan diizinkan untuk
                        menghubungkan tanpa adanya perjanjian lisensi merek dagang. </p>
                    <h2>iFrames</h2>
                    <p> Tanpa persetujuan sebelumnya dan izin tertulis, Anda tidak boleh membuat bingkai di sekitar
                        Halaman Web kami yang mengubah cara tampilan visual atau penampilan Situs Web kami. </p>
                    <h2>Kewajiban Konten</h2>
                    <p> Kami tidak akan bertanggung jawab atas konten apa pun yang muncul di Situs Web Anda. Anda setuju
                        untuk melindungi dan membela kami terhadap semua klaim yang muncul di Situs Web Anda. Tidak ada
                        tautan yang muncul di Situs web mana pun yang dapat ditafsirkan sebagai fitnah, cabul atau
                        kriminal, atau yang melanggar, jika tidak melanggar, atau mengadvokasi pelanggaran atau
                        pelanggaran lain terhadap, hak pihak ketiga. </p>
                    <h2>Reservasi Hak</h2>
                    <p> Kami berhak meminta Anda menghapus semua tautan atau tautan tertentu apa pun ke Situs Web kami.
                        Anda menyetujui untuk segera menghapus semua tautan ke Situs web kami berdasarkan permintaan.
                        Kami juga berhak mengubah syarat dan ketentuan ini dan ini menautkan kebijakan kapan saja.
                        Dengan terus menautkan ke Situs web kami, Anda setuju untuk terikat dan mengikuti syarat dan
                        ketentuan tautan ini. </p>
                    <h2>Penghapusan tautan dari situs web kami</h2>
                    <p> Jika Anda menemukan tautan apa pun di Situs Web kami yang menyinggung karena alasan apa pun,
                        Anda bebas untuk menghubungi dan memberi tahu kami kapan saja. Kami akan mempertimbangkan
                        permintaan untuk menghapus tautan tetapi kami tidak berkewajiban atau lebih atau untuk
                        menanggapi Anda secara langsung. </p>
                    <p> Kami tidak memastikan bahwa informasi di situs web ini benar, kami tidak menjamin kelengkapan
                        atau keakuratannya; kami juga tidak berjanji untuk memastikan bahwa situs web tetap tersedia
                        atau bahwa materi di situs web tetap terbaru. </p>
                    <h2>Penafian</h2>
                    <p> Sejauh diizinkan oleh hukum yang berlaku, kami mengecualikan semua representasi, jaminan, dan
                        ketentuan yang berkaitan dengan situs web kami dan penggunaan situs web ini. Tidak ada dalam
                        penafian ini yang akan: </p>
                    <ul>
                        <li> membatasi atau mengecualikan tanggung jawab kami atau Anda atas kematian atau cedera
                            pribadi;
                        </li>
                        <li> membatasi atau mengecualikan tanggung jawab kami atau Anda atas penipuan atau penipuan yang
                            salah;
                        </li>
                        <li> membatasi salah satu dari kewajiban kami atau Anda dengan cara apa pun yang tidak diizinkan
                            berdasarkan hukum yang berlaku; atau
                        </li>
                        <li> mengecualikan salah satu dari kewajiban kami atau Anda yang mungkin tidak dikecualikan
                            berdasarkan hukum yang berlaku.
                        </li>
                    </ul>
                    <p> Batasan dan larangan tanggung jawab yang diatur dalam Bagian ini dan di tempat lain dalam
                        penafian ini: (a) tunduk pada paragraf sebelumnya; dan (b) mengatur semua kewajiban yang timbul
                        berdasarkan penafian, termasuk kewajiban yang timbul dalam kontrak, dalam gugatan hukum dan
                        untuk pelanggaran kewajiban hukum. </p>
                    <p> Selama situs web dan informasi serta layanan di situs web disediakan secara gratis, kami tidak
                        akan bertanggung jawab atas kehilangan atau kerusakan apa pun. </p>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{asset('vendor/bootstrap-toc/bootstrap-toc.min.js')}}"></script>
    <script>
        $(function () {
            $("#toc ul li:nth-child(1), #toc ul li:nth-child(2), #toc ul li:nth-child(3)").remove();
        });

        $("nav[data-toggle=toc]").affix({
            offset: {
                bottom: function () {
                    return (this.bottom = $('footer').outerHeight(true))
                }
            }
        });

        $(document).on('click', 'a[href^="#"]', function (event) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: $($.attr(this, 'href')).offset().top
            }, 500);
        });
    </script>
@endpush
