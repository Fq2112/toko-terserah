@extends('layouts.mst')
@section('title', 'Kebijakan Privasi | '.env('APP_TITLE'))
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
                    <h2>Pendahuluan</h2>
                    <p> Di {{env('APP_NAME')}}, dapat diakses dari tokoterserah.com, salah satu prioritas utama kami
                        adalah privasi pengunjung kami. Dokumen Kebijakan Privasi ini berisi jenis informasi yang
                        dikumpulkan dan dicatat oleh {{env('APP_NAME')}} dan bagaimana kami menggunakannya. </p>
                    <p> Jika Anda memiliki pertanyaan tambahan atau memerlukan informasi lebih lanjut tentang Kebijakan
                        Privasi kami, jangan ragu untuk menghubungi kami. </p>
                    <h2> Log File </h2>
                    <p> {{env('APP_NAME')}} mengikuti prosedur standar menggunakan file log. File-file ini mencatat
                        pengunjung ketika mereka mengunjungi situs web. Semua perusahaan hosting melakukan ini dan
                        bagian dari analisis layanan hosting. Informasi yang dikumpulkan oleh file log termasuk alamat
                        protokol internet (IP), tipe browser, Penyedia Layanan Internet (ISP), cap tanggal dan waktu,
                        halaman rujukan / keluar, dan mungkin jumlah klik. Ini tidak terkait dengan informasi apa pun
                        yang dapat diidentifikasi secara pribadi. Tujuan dari informasi ini adalah untuk menganalisis
                        tren, mengelola situs, melacak pergerakan pengguna di situs web, dan mengumpulkan informasi
                        demografis. </p>
                    <h2> Cookie dan Beacon Web </h2>
                    <p> Seperti situs web lainnya, {{env('APP_NAME')}} menggunakan 'cookies'. Cookie ini digunakan untuk
                        menyimpan informasi termasuk preferensi pengunjung, dan halaman-halaman di situs web yang
                        diakses atau dikunjungi pengunjung. Informasi ini digunakan untuk mengoptimalkan pengalaman
                        pengguna dengan menyesuaikan konten halaman web kami berdasarkan jenis browser pengunjung dan /
                        atau informasi lainnya. </p>
                    <p> Untuk informasi lebih lanjut tentang cookie, silakan baca artikel "What Are Cookies" di <a
                            href="https://www.cookieconsent.com/what-are-cookies/"> situs web Persetujuan Cookie </a> .
                    </p>
                    <h2> Kebijakan Privasi </h2>
                    <P> Anda dapat berkonsultasi daftar ini untuk menemukan Kebijakan Privasi untuk masing-masing mitra
                        iklan {{env('APP_NAME')}}. Kebijakan Privasi kami dibuat dengan bantuan <a
                            href="https://www.privacypolicygenerator.org"> Pembuat Kebijakan Privasi Gratis </a> dan <a
                            href="https://www.privacypolicyonline.com / privacy-policy-generator / "> Pembuat Kebijakan
                            Privasi Online </a>. </p>
                    <p> Server iklan pihak ketiga atau jaringan iklan menggunakan teknologi seperti cookie, JavaScript,
                        atau Web Beacon yang digunakan dalam iklan masing-masing dan tautan yang muncul
                        di {{env('APP_NAME')}}, yang dikirim langsung ke browser pengguna. Mereka secara otomatis
                        menerima alamat IP Anda ketika ini terjadi. Teknologi ini digunakan untuk mengukur efektivitas
                        kampanye iklan mereka dan / atau untuk mempersonalisasi konten iklan yang Anda lihat di situs
                        web yang Anda kunjungi. </p>
                    <p> Perhatikan bahwa {{env('APP_NAME')}} tidak memiliki akses ke atau kontrol terhadap cookie ini
                        yang digunakan oleh pengiklan pihak ketiga. </p>
                    <h2> Kebijakan Privasi Pihak Ketiga </h2>
                    <p> Kebijakan Privasi {{env('APP_NAME')}} tidak berlaku untuk pengiklan atau situs web lain.
                        Karenanya, kami menyarankan Anda untuk berkonsultasi dengan masing-masing Kebijakan Privasi dari
                        server iklan pihak ketiga ini untuk informasi yang lebih terperinci. Ini mungkin termasuk
                        praktik dan instruksi mereka tentang cara menyisih dari opsi tertentu. </p>
                    <p> Anda dapat memilih untuk menonaktifkan cookie melalui opsi browser individual Anda. Untuk
                        mengetahui informasi lebih rinci tentang manajemen cookie dengan browser web tertentu, dapat
                        ditemukan di situs web masing-masing browser. Apa Itu Cookie? </p>
                    <h2> Informasi Anak-Anak </h2>
                    <p> Bagian lain dari prioritas kami adalah menambahkan perlindungan untuk anak-anak saat menggunakan
                        internet. Kami mendorong orang tua dan wali untuk mengamati, berpartisipasi, dan / atau memantau
                        dan membimbing aktivitas online mereka. </p>
                    <p> {{env('APP_NAME')}} tidak sengaja mengumpulkan Informasi Identifikasi Pribadi apa pun dari anak
                        di bawah 13 tahun. Jika Anda berpikir bahwa anak Anda memberikan informasi semacam ini di situs
                        web kami, kami sangat menganjurkan Anda untuk menghubungi kami segera dan kami akan melakukan
                        yang terbaik upaya untuk segera menghapus informasi tersebut dari catatan kami. </p>
                    <h2> Hanya Kebijakan Privasi Online </h2>
                    <p> Kebijakan Privasi ini hanya berlaku untuk aktivitas online kami dan berlaku untuk pengunjung
                        situs web kami sehubungan dengan informasi yang mereka bagikan dan / atau kumpulkan
                        di {{env('APP_NAME')}}. Kebijakan ini tidak berlaku untuk informasi apa pun yang dikumpulkan
                        secara offline atau melalui saluran selain dari situs web ini. </p>
                    <h2> Persetujuan </h2>
                    <p> Dengan menggunakan situs web kami, Anda dengan ini menyetujui Kebijakan Privasi kami dan
                        menyetujui Syarat dan Ketentuannya. </p>
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
