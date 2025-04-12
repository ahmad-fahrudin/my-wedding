<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="wpOceans">
    <link rel="shortcut icon" type="image/png" href="{{ asset('lovelove/images/favicon.png') }}">
    <title> LoveLove - Wedding & Wedding Planner HTML5 Template</title>
    <link href="{{ asset('lovelove/css/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('lovelove/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lovelove/css/flaticon.css') }}" rel="stylesheet">
    <link href="{{ asset('lovelove/css/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ asset('lovelove/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lovelove/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('lovelove/css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('lovelove/css/owl.theme.css') }}" rel="stylesheet">
    <link href="{{ asset('lovelove/css/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('lovelove/css/slick-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('lovelove/css/swiper.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lovelove/css/nice-select.css') }}" rel="stylesheet">
    <link href="{{ asset('lovelove/css/owl.transitions.css') }}" rel="stylesheet">
    <link href="{{ asset('lovelove/css/jquery.fancybox.css') }}" rel="stylesheet">
    <link href="{{ asset('lovelove/css/odometer-theme-default.css') }}" rel="stylesheet">
    <link href="{{ asset('lovelove/css/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('lovelove/sass/style.css') }}" rel="stylesheet">
</head>

<body>
    <!-- start page-wrapper -->
    <div class="page-wrapper">
        <!-- start preloader -->
        <div class="preloader">
            <div class="vertical-centered-box">
                <div class="content">
                    <div class="loader-circle"></div>
                    <div class="loader-line-mask">
                        <div class="loader-line"></div>
                    </div>
                    <img src="{{ asset('lovelove/images/preloader.svg') }}" alt="">
                </div>
            </div>
        </div>
        <!-- end preloader -->
        <!-- Start header -->
        <header id="header">
            <div class="wpo-site-header wpo-header-style-1" id="sticky-header">
                <nav class="navigation navbar navbar-expand-lg navbar-light">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-3 col-3 d-lg-none d-block">
                                <div class="mobail-menu">
                                    <button type="button" class="navbar-toggler open-btn">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar first-angle"></span>
                                        <span class="icon-bar middle-angle"></span>
                                        <span class="icon-bar last-angle"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6 col-6 d-lg-block d-none">
                                <div class="social-info">
                                    <ul>
                                        <li><a href="#"><i class="fi flaticon-facebook-app-symbol"></i></a></li>
                                        <li><a href="#"><i class="fi flaticon-twitter"></i></a></li>
                                        <li><a href="#"><i class="fi flaticon-linkedin"></i></a></li>
                                        <li><a href="#"><i class="fi flaticon-instagram-1"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 col-6 d-lg-none dl-block">
                                <div class="navbar-header">
                                    <a class="navbar-brand" href="index.html"><img src="{{ asset('lovelove/images/logo.svg') }}" alt=""></a>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-1 col-1">
                                <div id="navbar" class="collapse navbar-collapse navigation-holder">
                                    <button class="menu-close"><i class="ti-close"></i></button>
                                    <ul class="nav navbar-nav mb-2 mb-lg-0">
                                        <li class="menu-item-has-children">
                                        </li>
                                        <li><a href="#story">Cerita</a></li>
                                        <li><a href="#gallery">Galeri</a></li>
                                        <li><a href="#rsvp">RSVP</a></li>
                                        <li><a href="#event">Acara</a></li>
                                        <li><a href="#blog">Blog</a></li>
                                    </ul>

                                </div><!-- end of nav-collapse -->
                            </div>
                        </div>
                    </div><!-- end of container -->
                </nav>
            </div>
        </header>
        <!-- end of header -->
        <!-- start of hero -->
        <section class="static-hero-s2">
            <div class="hero-container">
                <div class="hero-inner">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-xl-6 col-lg-6 col-12">
                                <div class="wpo-static-hero-inner">
                                    <div class="shape-1 wow fadeInUp" data-wow-duration="900ms"><img src="{{ asset('lovelove/images/slider/shape5.png') }}" alt=""></div>
                                    <div class="slide-title wow fadeInUp" data-wow-duration="1100ms">
                                        <h2>Srivalli & Bhuban</h2>
                                    </div>
                                    <div class="slide-text wow fadeInUp" data-wow-duration="1300ms">
                                        <p>Kami Akan Menikah pada 8 Jul, 2022</p>
                                    </div>
                                    <div class="wpo-wedding-date wow fadeInUp" data-wow-duration="1500ms">
                                        <div class="clock-grids">
                                            <div id="clock" data-date="2024/02/09 00:00"></div>
                                        </div>
                                    </div>
                                    <div class="shape-2 wow fadeInUp" data-wow-duration="1700ms"><img src="{{ asset('lovelove/images/slider/shape6.png') }}" alt=""></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-12">
                                <div class="static-hero-right">
                                    <div class="static-hero-img">
                                        <div class="static-hero-img-inner wow zoomIn" data-wow-duration="1500ms">
                                            <img src="{{ asset('lovelove/images/slider/couple.png') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="static-hero-shape"><img src="{{ asset('lovelove/images/slider/frame.png') }}" alt=""></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end of hero slider -->
        <!-- start couple-section -->
        <section class="wpo-couple-section-s3 section-padding" id="couple">
            <div class="container">
                <div class="couple-area clearfix">
                    <div class="row">
                        <div class="col col-md-4 col-12">
                            <div class="couple-item wow fadeInLeftSlow" data-wow-duration="1700ms">
                                <div class="couple-img">
                                    <img src="{{ asset('lovelove/images/couple/img-3.jpg') }}" alt="">
                                </div>
                                <div class="couple-text">
                                    <h3>Srivalli Ahuza</h3>
                                    <p>Srivalli adalah wanita yang penuh kasih dan perhatian. Dia memiliki cinta yang tulus dan selalu siap membantu orang lain. Dia adalah sosok yang membuat hidup sekitar terasa lebih berharga.</p>
                                    <div class="social">
                                        <ul>
                                            <li><a href="#"><i class="ti-facebook"></i></a></li>
                                            <li><a href="#"><i class="ti-twitter-alt"></i></a></li>
                                            <li><a href="#"><i class="ti-instagram"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col col-md-4 col-12">
                            <div class="middle-couple-shape wow fadeInUp" data-wow-duration="1000ms">
                                <div class="shape floating-item">
                                    <img src="{{ asset('lovelove/images/couple/shape.png') }}" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col col-md-4 col-12">
                            <div class="couple-item wow fadeInRightSlow" data-wow-duration="1700ms">
                                <div class="couple-img">
                                    <img src="{{ asset('lovelove/images/couple/img-4.jpg') }}" alt="">
                                </div>
                                <div class="couple-text">
                                    <h3>Bhaban Batra</h3>
                                    <p>Bhaban adalah sosok yang tegas dan bijaksana. Dia selalu memberikan dukungan kepada Srivalli dan menginspirasi banyak orang dengan ide dan pandangannya. Cintanya kepada Srivalli adalah bukti sejati dari komitmen dan kesetiaan.</p>
                                    <div class="social">
                                        <ul>
                                            <li><a href="#"><i class="ti-facebook"></i></a></li>
                                            <li><a href="#"><i class="ti-twitter-alt"></i></a></li>
                                            <li><a href="#"><i class="ti-instagram"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end container -->
        </section>
        <!-- end couple-section -->
        <!-- start wpo-video-section -->
        <section class="wpo-video-section-s3">
            <h2 class="hidden">some</h2>
            <div class="container-fluid">
                <div class="video-wrap">
                    <img src="{{ asset('lovelove/images/cta3.jpg') }}" alt="">
                    <a href="https://www.youtube.com/embed/ZpeFEBMRCyM" class="video-btn" data-type="iframe"><i class="fi flaticon-play"></i></a>
                </div>
            </div>
        </section>
        <!-- end wpo-video-section-->
        <!-- start wpo-story-section -->
        <section class="wpo-story-section-s3 section-padding pb-0" id="story">
            <div class="container">
                <div class="wpo-section-title">
                    <h4>Cerita Kami</h4>
                    <h2>Kisah Cinta Kami yang Manis</h2>
                </div>
                <div class="wpo-story-wrap">
                    <div class="wpo-story-item">
                        <div class="wpo-story-img-wrap wow fadeInLeftSlow" data-wow-duration="1700ms">
                            <div class="wpo-story-img">
                                <img src="{{ asset('lovelove/images/story/5.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="wpo-story-content  wow fadeInRightSlow" data-wow-duration="1700ms">
                            <div class="wpo-story-content-inner">
                                <h2>Pertama Kali Kami Bertemu</h2>
                                <span>12 Feb 2016</span>
                                <p>Kami pertama kali bertemu di sebuah acara keluarga, di mana kami saling bertukar pandangan dan senyum. Sejak saat itu, kami merasakan chemistry yang kuat dan menemukan kenyamanan dalam satu sama lain.</p>
                            </div>
                        </div>
                    </div>
                    <div class="wpo-story-item">
                        <div class="wpo-story-img-wrap wow fadeInRightSlow" data-wow-duration="1700ms">
                            <div class="wpo-story-img">
                                <img src="{{ asset('lovelove/images/story/6.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="wpo-story-content wow fadeInLeftSlow" data-wow-duration="1700ms">
                            <div class="wpo-story-content-inner">
                                <h2>Janji Pertama Kami</h2>
                                <span>23 Apr 2016</span>
                                <p>Setelah beberapa bulan berkenalan, kami akhirnya pergi berkencan. Momen tersebut sangat berkesan, di mana kami berbagi cerita, tertawa, dan saling mengenal lebih dalam.</p>
                            </div>
                        </div>
                    </div>
                    <div class="wpo-story-item">
                        <div class="wpo-story-img-wrap wow fadeInLeftSlow" data-wow-duration="1700ms">
                            <div class="wpo-story-img">
                                <img src="{{ asset('lovelove/images/story/7.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="wpo-story-content wow fadeInRightSlow" data-wow-duration="1700ms">
                            <div class="wpo-story-content-inner">
                                <h2>Dia Mengatakan Ya</h2>
                                <span>10 Mar 2016</span>
                                <p>Di suatu malam yang indah, saya melamar Srivalli di tempat favorit kami. Dengan penuh haru dan senyum, dia mengatakan "Ya". Momen itu menjadi awal dari perjalanan baru kami bersama.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end container -->
        </section>
        <!-- end story-section -->
        <!-- start wpo-portfolio-section -->
        <section class="wpo-portfolio-section-s2 section-padding pb-0" id="gallery">
            <h2 class="hidden">some</h2>
            <div class="container-fluid">
                <div class="sortable-gallery">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="portfolio-grids gallery-container clearfix">
                                <div class="grid">
                                    <div class="img-holder">
                                        <a href="{{ asset('lovelove/images/portfolio/12.jpg') }}" class="fancybox" data-fancybox-group="gall-1">
                                            <img src="{{ asset('lovelove/images/portfolio/12.jpg') }}" alt class="img img-responsive">
                                            <div class="hover-content">
                                                <i class="ti-plus"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="grid">
                                    <div class="img-holder">
                                        <a href="{{ asset('lovelove/images/portfolio/13.jpg') }}" class="fancybox" data-fancybox-group="gall-1">
                                            <img src="{{ asset('lovelove/images/portfolio/13.jpg') }}" alt class="img img-responsive">
                                            <div class="hover-content">
                                                <i class="ti-plus"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="grid">
                                    <div class="img-holder">
                                        <a href="{{ asset('lovelove/images/portfolio/15.jpg') }}" class="fancybox" data-fancybox-group="gall-1">
                                            <img src="{{ asset('lovelove/images/portfolio/15.jpg') }}" alt class="img img-responsive">
                                            <div class="hover-content">
                                                <i class="ti-plus"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="grid">
                                    <div class="img-holder">
                                        <a href="{{ asset('lovelove/images/portfolio/16.jpg') }}" class="fancybox" data-fancybox-group="gall-1">
                                            <img src="{{ asset('lovelove/images/portfolio/16.jpg') }}" alt class="img img-responsive">
                                            <div class="hover-content">
                                                <i class="ti-plus"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="grid">
                                    <div class="img-holder">
                                        <a href="{{ asset('lovelove/images/portfolio/14.jpg') }}" class="fancybox" data-fancybox-group="gall-1">
                                            <img src="{{ asset('lovelove/images/portfolio/14.jpg') }}" alt class="img img-responsive">
                                            <div class="hover-content">
                                                <i class="ti-plus"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="grid">
                                    <div class="img-holder">
                                        <a href="{{ asset('lovelove/images/portfolio/17.jpg') }}" class="fancybox" data-fancybox-group="gall-1">
                                            <img src="{{ asset('lovelove/images/portfolio/17.jpg') }}" alt class="img img-responsive">
                                            <div class="hover-content">
                                                <i class="ti-plus"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- end container -->
        </section>
        <!-- end wpo-portfolio-section -->
        <section class="wpo-contact-section-s4 section-padding" id="rsvp">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col col-lg-12 col-md-12 col-12">
                        <div class="wpo-contact-section-wrapper">
                            <div class="wpo-contact-section-inner">
                                <div class="wpo-contact-form-area">
                                    <div class="wpo-section-title">
                                        <h4>Ucapan & Doa</h4>
                                    </div>
                                    <form method="post" class="contact-validation-active" id="contact-form-main" action="">
                                        @csrf
                                        <input type="hidden" name="undangan_id" value="{{ $undangan->id ?? 1 }}">
                                        <div>
                                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Anda" required>
                                        </div>
                                        <div class="attendance-radio" style="margin-bottom: 20px; margin-top: 10px;">
                                            <label style="display: block; margin-bottom: 8px; color: #666; font-size: 15px;">Konfirmasi Kehadiran:</label>
                                            <div style="display: flex; gap: 30px;">
                                                <label style="position: relative; padding-left: 30px; cursor: pointer; display: flex; align-items: center; font-size: 15px; user-select: none; color: #666; margin: 0;">
                                                    <input type="radio" name="kehadiran" value="hadir" required style="position: absolute; opacity: 0; cursor: pointer;">
                                                    <span style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); height: 18px; width: 18px; background-color: #fff; border: 2px solid #c9a74d; border-radius: 50%; transition: all 0.2s ease;"></span>
                                                    Hadir
                                                </label>
                                                <label style="position: relative; padding-left: 30px; cursor: pointer; display: flex; align-items: center; font-size: 15px; user-select: none; color: #666; margin: 0;">
                                                    <input type="radio" name="kehadiran" value="tidak_hadir" required style="position: absolute; opacity: 0; cursor: pointer;">
                                                    <span style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); height: 18px; width: 18px; background-color: #fff; border: 2px solid #c9a74d; border-radius: 50%; transition: all 0.2s ease;"></span>
                                                    Tidak Hadir
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <textarea class="form-control" name="ucapan" id="ucapan" placeholder="Tuliskan ucapan dan doa untuk kedua mempelai" rows="4" required></textarea>
                                        </div>
                                        <div class="submit-area">
                                            <button type="submit" class="theme-btn">Kirim Ucapan</button>
                                            <div id="c-loader">
                                                <i class="ti-reload"></i>
                                            </div>
                                        </div>
                                        <div class="clearfix error-handling-messages">
                                            <div id="success">Terima kasih atas ucapan dan doanya</div>
                                            <div id="error">Terjadi kesalahan saat mengirim ucapan. Silakan coba lagi nanti.</div>
                                        </div>
                                    </form>
                                    <script>
                                        document.querySelectorAll('input[name="kehadiran"]').forEach(function(radio) {
                                            radio.addEventListener('change', function() {
                                                document.querySelectorAll('input[name="kehadiran"]').forEach(function(r) {
                                                    const span = r.nextElementSibling;
                                                    if (r.checked) {
                                                        span.style.background = '#fff';
                                                        span.style.boxShadow = 'inset 0 0 0 4px #c9a74d';
                                                    } else {
                                                        span.style.background = '#fff';
                                                        span.style.boxShadow = 'none';
                                                    }
                                                });
                                            });
                                        });

                                    </script>

                                    <!-- Daftar Ucapan Static -->
                                    <div class="wpo-testimonial-wrap" style="margin-top: 50px;">
                                        <div class="wpo-section-title">
                                            <h4>Ucapan dari Tamu</h4>
                                        </div>

                                        <div class="wpo-testimonial-items" style="max-height: 400px; overflow-y: auto; padding-right: 10px;">
                                            <!-- Ucapan Item 1 -->
                                            <div class="wpo-testimonial-item" style="background: rgba(250, 250, 250, 0.5); border-radius: 10px; padding: 20px; margin-bottom: 20px; border-left: 3px solid #c9a74d; position: relative;">
                                                <div class="wpo-testimonial-info" style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <div class="wpo-testimonial-info-img" style="width: 50px; height: 50px; border-radius: 50%; background-color: #c9a74d; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                                                        <span style="color: white; font-weight: bold; font-size: 20px;">R</span>
                                                    </div>
                                                    <div class="wpo-testimonial-info-text">
                                                        <h5 style="margin-bottom: 0; color: #333;">Rania Putri</h5>
                                                        <span style="font-size: 12px; color: #666;">12 April 2025 · <span style="color: #c9a74d; font-weight: 600;">Hadir</span></span>
                                                    </div>
                                                </div>
                                                <p style="margin-bottom: 0; color: #555; line-height: 1.6;">Selamat menempuh hidup baru untuk Srivalli dan Bhaban! Semoga Allah SWT senantiasa melimpahkan rahmat dan keberkahan dalam rumah tangga kalian. Menjadi keluarga yang sakinah, mawaddah, warahmah. Aamiin Ya Rabb.</p>
                                            </div>

                                            <!-- Ucapan Item 2 -->
                                            <div class="wpo-testimonial-item" style="background: rgba(250, 250, 250, 0.5); border-radius: 10px; padding: 20px; margin-bottom: 20px; border-left: 3px solid #c9a74d; position: relative;">
                                                <div class="wpo-testimonial-info" style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <div class="wpo-testimonial-info-img" style="width: 50px; height: 50px; border-radius: 50%; background-color: #c9a74d; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                                                        <span style="color: white; font-weight: bold; font-size: 20px;">A</span>
                                                    </div>
                                                    <div class="wpo-testimonial-info-text">
                                                        <h5 style="margin-bottom: 0; color: #333;">Ahmad Fauzi</h5>
                                                        <span style="font-size: 12px; color: #666;">11 April 2025 · <span style="color: #c9a74d; font-weight: 600;">Hadir</span></span>
                                                    </div>
                                                </div>
                                                <p style="margin-bottom: 0; color: #555; line-height: 1.6;">Bahagia rasanya bisa menyaksikan dua insan yang saling mencintai dipersatukan dalam ikatan suci pernikahan. Doa terbaik untuk sahabatku Bhaban dan pasangan hidupnya Srivalli. Semoga pernikahan kalian langgeng sampai kakek nenek!</p>
                                            </div>

                                            <!-- Ucapan Item 3 -->
                                            <div class="wpo-testimonial-item" style="background: rgba(250, 250, 250, 0.5); border-radius: 10px; padding: 20px; margin-bottom: 20px; border-left: 3px solid #c9a74d; position: relative;">
                                                <div class="wpo-testimonial-info" style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <div class="wpo-testimonial-info-img" style="width: 50px; height: 50px; border-radius: 50%; background-color: #c9a74d; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                                                        <span style="color: white; font-weight: bold; font-size: 20px;">D</span>
                                                    </div>
                                                    <div class="wpo-testimonial-info-text">
                                                        <h5 style="margin-bottom: 0; color: #333;">Dinda Kirana</h5>
                                                        <span style="font-size: 12px; color: #666;">10 April 2025 · <span style="color: #777; font-weight: 600;">Tidak Hadir</span></span>
                                                    </div>
                                                </div>
                                                <p style="margin-bottom: 0; color: #555; line-height: 1.6;">Mohon maaf tidak bisa hadir, tetapi doa terbaik selalu untuk kedua mempelai. Semoga cinta kalian abadi seperti pasangan dalam dongeng. Selamat menempuh hidup baru, Srivalli dan Bhaban!</p>
                                            </div>

                                            <!-- Ucapan Item 4 -->
                                            <div class="wpo-testimonial-item" style="background: rgba(250, 250, 250, 0.5); border-radius: 10px; padding: 20px; margin-bottom: 20px; border-left: 3px solid #c9a74d; position: relative;">
                                                <div class="wpo-testimonial-info" style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <div class="wpo-testimonial-info-img" style="width: 50px; height: 50px; border-radius: 50%; background-color: #c9a74d; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                                                        <span style="color: white; font-weight: bold; font-size: 20px;">R</span>
                                                    </div>
                                                    <div class="wpo-testimonial-info-text">
                                                        <h5 style="margin-bottom: 0; color: #333;">Raditya Dika</h5>
                                                        <span style="font-size: 12px; color: #666;">10 April 2025 · <span style="color: #c9a74d; font-weight: 600;">Hadir</span></span>
                                                    </div>
                                                </div>
                                                <p style="margin-bottom: 0; color: #555; line-height: 1.6;">Selamat atas pernikahan kalian! Semoga menjadi pasangan yang selalu bahagia, saling mengerti, dan terus tumbuh bersama dalam cinta. Ingat, kunci rumah tangga bahagia adalah saling mendengarkan dan makan enak bareng!</p>
                                            </div>

                                            <!-- Ucapan Item 5 -->
                                            <div class="wpo-testimonial-item" style="background: rgba(250, 250, 250, 0.5); border-radius: 10px; padding: 20px; margin-bottom: 0; border-left: 3px solid #c9a74d; position: relative;">
                                                <div class="wpo-testimonial-info" style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <div class="wpo-testimonial-info-img" style="width: 50px; height: 50px; border-radius: 50%; background-color: #c9a74d; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                                                        <span style="color: white; font-weight: bold; font-size: 20px;">A</span>
                                                    </div>
                                                    <div class="wpo-testimonial-info-text">
                                                        <h5 style="margin-bottom: 0; color: #333;">Anissa Aziza</h5>
                                                        <span style="font-size: 12px; color: #666;">9 April 2025 · <span style="color: #777; font-weight: 600;">Tidak Hadir</span></span>
                                                    </div>
                                                </div>
                                                <p style="margin-bottom: 0; color: #555; line-height: 1.6;">Meski terhalang jarak, namun tidak menghalangi ketulusan doa saya untuk kalian berdua. Semoga rumah tangga Srivalli dan Bhaban selalu dipenuhi dengan kebahagiaan, kesehatan, dan rezeki yang melimpah. Congratulations!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Daftar Ucapan Static -->
                                </div>
                            </div>
                            <div class="shape-1"><img class="floating-item wow fadeInLeftSlow" data-wow-duration="1700ms" src="{{ asset('lovelove/images/contact/shape-1.png') }}" alt=""></div>
                            <div class="shape-2"><img class="floating-item wow fadeInRightSlow" data-wow-duration="1700ms" src="{{ asset('lovelove/images/contact/shape-2.png') }}" alt=""></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- start wpo-partners-section -->
        <section class="wpo-partners-section">
            <h2 class="hidden">Partner</h2>
            <div class="container">
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="partner-grids partners-slider owl-carousel">
                            <div class="grid">
                                <img src="{{ asset('lovelove/images/partners/1.png') }}" alt>
                            </div>
                            <div class="grid">
                                <img src="{{ asset('lovelove/images/partners/2.png') }}" alt>
                            </div>
                            <div class="grid">
                                <img src="{{ asset('lovelove/images/partners/3.png') }}" alt>
                            </div>
                            <div class="grid">
                                <img src="{{ asset('lovelove/images/partners/4.png') }}" alt>
                            </div>
                            <div class="grid">
                                <img src="{{ asset('lovelove/images/partners/5.png') }}" alt>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end container -->
        </section>
        <!-- end wpo-partners-section-->

        <!-- start wpo-event-section -->
        <section class="wpo-event-section section-padding pb-0" id="event">
            <div class="container">
                <div class="wpo-section-title">
                    <h4>Pernikahan Kami</h4>
                    <h2>Kapan & Di Mana</h2>
                </div>
                <div class="wpo-event-wrap">
                    <div class="row">
                        <div class="col col-lg-4 col-md-6 col-12">
                            <div class="wpo-event-item">
                                <div class="wpo-event-img">
                                    <img src="{{ asset('lovelove/images/event/4.jpg') }}" alt="">
                                    <div class="title">
                                        <h2>Resepsi</h2>
                                    </div>
                                </div>
                                <div class="wpo-event-text">
                                    <ul>
                                        <li>Senin, 12 Apr. 2022
                                            1:00 PM – 2:30 PM</li>
                                        <li>4517 Washington Ave. Manchester, Kentucky 39495</li>
                                        <li>+1 234-567-8910</li>
                                        <li><a class="popup-gmaps" href="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25211.21212385712!2d144.95275648773628!3d-37.82748510398018!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0x5045675218ce7e0!2zTWVsYm91cm5lIFZJQyAzMDA0LCDgpoXgprjgp43gpp_gp43gprDgp4fgprLgpr_gpq_gprzgpr4!5e0!3m2!1sbn!2sbd!4v1503742051881">Lihat Lokasi</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-4 col-md-6 col-12">
                            <div class="wpo-event-item">
                                <div class="wpo-event-img">
                                    <img src="{{ asset('lovelove/images/event/5.jpg') }}" alt="">
                                    <div class="title">
                                        <h2>Akad Nikah</h2>
                                    </div>
                                </div>
                                <div class="wpo-event-text">
                                    <ul>
                                        <li>Senin, 12 Apr. 2022
                                            1:00 PM – 2:30 PM</li>
                                        <li>4517 Washington Ave. Manchester, Kentucky 39495</li>
                                        <li>+1 234-567-8910</li>
                                        <li><a class="popup-gmaps" href="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25211.21212385712!2d144.95275648773628!3d-37.82748510398018!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0x5045675218ce7e0!2zTWVsYm91cm5lIFZJQyAzMDA0LCDgpoXgprjgp43gpp_gp43gprDgp4fgprLgpr_gpq_gprzgpr4!5e0!3m2!1sbn!2sbd!4v1503742051881">Lihat Lokasi</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-4 col-md-6 col-12">
                            <div class="wpo-event-item">
                                <div class="wpo-event-img">
                                    <img src="{{ asset('lovelove/images/event/6.jpg') }}" alt="">
                                    <div class="title">
                                        <h2>Pesta Pernikahan</h2>
                                    </div>
                                </div>
                                <div class="wpo-event-text">
                                    <ul>
                                        <li>Senin, 12 Apr. 2022
                                            1:00 PM – 2:30 PM</li>
                                        <li>4517 Washington Ave. Manchester, Kentucky 39495</li>
                                        <li>+1 234-567-8910</li>
                                        <li><a class="popup-gmaps" href="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25211.21212385712!2d144.95275648773628!3d-37.82748510398018!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0x5045675218ce7e0!2zTWVsYm91cm5lIFZJQyAzMDA0LCDgpoXgprjgp43gpp_gp43gprDgp4fgprLgpr_gpq_gprzgpr4!5e0!3m2!1sbn!2sbd!4v1503742051881">Lihat Lokasi</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- end container -->
        </section>
        <!-- end wpo-event-section -->

        <!-- wpo-site-footer start -->
        <div class="wpo-site-footer text-center">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="footer-image">
                            <a class="logo" href="index.html"><img src="{{ asset('lovelove/images/logo.svg') }}" alt=""></a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="link-widget">
                            <ul>
                                <li><a href="#"><i class="ti-twitter"></i></a></li>
                                <li><a href="#"><i class="ti-dribbble"></i></a></li>
                                <li><a href="#"><i class="ti-facebook"></i></a></li>
                                <li><a href="#"><i class="ti-linkedin"></i></a></li>
                                <li><a href="#"><i class="ti-skype"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="copyright">
                            <p>© Hak Cipta 2022 | <a href="index.html">LoveLove</a> | Semua hak dilindungi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- wpo-site-footer end -->

        <!-- color-switcher -->
        <div class="color-switcher-wrap">
            <div class="color-switcher-item">
                <div class="color-toggle-btn">
                    <i class="fa fa-cog"></i>
                </div>
                <ul id="switcher">
                    <li class="btn btn1" id="Button1"></li>
                    <li class="btn btn2" id="Button2"></li>
                    <li class="btn btn3" id="Button3"></li>
                    <li class="btn btn4" id="Button4"></li>
                    <li class="btn btn5" id="Button5"></li>
                    <li class="btn btn6" id="Button6"></li>
                    <li class="btn btn7" id="Button7"></li>
                    <li class="btn btn8" id="Button8"></li>
                    <li class="btn btn9" id="Button9"></li>
                    <li class="btn btn10" id="Button10"></li>
                    <li class="btn btn11" id="Button11"></li>
                    <li class="btn btn12" id="Button12"></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end of page-wrapper -->

    <!-- All JavaScript files
    ================================================== -->
    <script src="{{ asset('lovelove/js/jquery.min.js') }}"></script>
    <script src="{{ asset('lovelove/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Plugins for this template -->
    <script src="{{ asset('lovelove/js/modernizr.custom.js') }}"></script>
    <!-- Moving Animation -->
    <script src="{{ asset('lovelove/js/moving-animation.js') }}"></script>
    <script src="{{ asset('lovelove/js/jquery-plugin-collection.js') }}"></script>
    <!-- Custom script for this template -->
    <script src="{{ asset('lovelove/js/script.js') }}"></script>
    <script>
        // Additional custom JavaScript can be added here

    </script>
</body>

</html>
