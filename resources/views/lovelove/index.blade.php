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
        <!-- In the hero section -->
        <section class="static-hero-s2">
            <div class="hero-container">
                <div class="hero-inner">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-xl-6 col-lg-6 col-12">
                                <div class="wpo-static-hero-inner">
                                    <div class="shape-1 wow fadeInUp" data-wow-duration="900ms"><img src="{{ asset('lovelove/images/slider/shape5.png') }}" alt=""></div>
                                    <div class="slide-title wow fadeInUp" data-wow-duration="1100ms">
                                        <h2>{{ $undangan->nama_mempelai_1 ?? 'Srivalli' }} & {{ $undangan->nama_mempelai_2 ?? 'Bhuban' }}</h2>
                                    </div>
                                    <div class="slide-text wow fadeInUp" data-wow-duration="1300ms">
                                        <p>Kami Akan Menikah pada {{ $undangan ? \Carbon\Carbon::parse($undangan->tanggal_acara)->format('d M, Y') : '8 Jul, 2022' }}</p>
                                    </div>
                                    <div class="wpo-wedding-date wow fadeInUp" data-wow-duration="1500ms">
                                        <div class="clock-grids">
                                            <div id="clock" data-date="{{ $undangan ? $undangan->tanggal_acara : '2024/02/09 00:00' }}"></div>
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
                                            @php
                                            $heroImage = null;
                                            if(isset($galeri) && count($galeri) > 0) {
                                            $heroImages = $galeri->where('category', App\Enums\GaleriCategoryEnum::HERO->value);
                                            if($heroImages->count() > 0) {
                                            $heroImage = $heroImages->first()->image;
                                            }
                                            }
                                            @endphp

                                            @if($heroImage)
                                            <img src="{{ strpos($heroImage, 'data:image') === 0 ? $heroImage : 'data:image/jpeg;base64,' . $heroImage }}" alt="Hero image">
                                            @else
                                            <img src="{{ asset('lovelove/images/slider/couple.png') }}" alt="Default hero image">
                                            @endif
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
        <!-- end of hero section -->
        <!-- start couple-section -->
        <section class="wpo-couple-section-s3 section-padding" id="couple">
            <div class="container">
                <div class="couple-area clearfix">
                    <div class="row">
                        <div class="col col-md-4 col-12">
                            <div class="couple-item wow fadeInLeftSlow" data-wow-duration="1700ms">
                                <div class="couple-img">
                                    @php
                                    $bride = null;
                                    if(isset($galeri) && count($galeri) > 0) {
                                    $coupleImages = $galeri->where('category', App\Enums\GaleriCategoryEnum::COUPLE->value);
                                    if($coupleImages->count() > 0) {
                                    $bride = $coupleImages->first()->image;
                                    }
                                    }
                                    @endphp

                                    @if($bride)
                                    <img src="{{ strpos($bride, 'data:image') === 0 ? $bride : 'data:image/jpeg;base64,' . $bride }}" alt="Bride image">
                                    @else
                                    <img src="{{ asset('lovelove/images/couple/img-3.jpg') }}" alt="Default bride image">
                                    @endif
                                </div>
                                <div class="couple-text">
                                    <h3>{{ $undangan->nama_mempelai_1 ?? 'Srivalli Ahuza' }}</h3>
                                    <p>{{ $undangan->deskripsi_mempelai_1 ?? 'Srivalli adalah wanita yang penuh kasih dan perhatian. Dia memiliki cinta yang tulus dan selalu siap membantu orang lain. Dia adalah sosok yang membuat hidup sekitar terasa lebih berharga.' }}</p>
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
                                    @php
                                    $groom = null;
                                    if(isset($galeri) && count($galeri) > 0) {
                                    $coupleImages = $galeri->where('category', App\Enums\GaleriCategoryEnum::COUPLE->value);
                                    if($coupleImages->count() > 1) {
                                    $groom = $coupleImages->skip(1)->first()->image;
                                    }
                                    }
                                    @endphp

                                    @if($groom)
                                    <img src="{{ strpos($groom, 'data:image') === 0 ? $groom : 'data:image/jpeg;base64,' . $groom }}" alt="Groom image">
                                    @else
                                    <img src="{{ asset('lovelove/images/couple/img-4.jpg') }}" alt="Default groom image">
                                    @endif
                                </div>
                                <div class="couple-text">
                                    <h3>{{ $undangan->nama_mempelai_2 ?? 'Bhaban Batra' }}</h3>
                                    <p>{{ $undangan->deskripsi_mempelai_2 ?? 'Bhaban adalah sosok yang tegas dan bijaksana. Dia selalu memberikan dukungan kepada Srivalli dan menginspirasi banyak orang dengan ide dan pandangannya. Cintanya kepada Srivalli adalah bukti sejati dari komitmen dan kesetiaan.' }}</p>
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
        <!-- start wpo-story-section -->
        <section class="wpo-story-section-s3 section-padding pb-0" id="story">
            <div class="container">
                <div class="wpo-section-title">
                    <h4>Cerita Kami</h4>
                    <h2>Kisah Cinta Kami yang Manis</h2>
                </div>
                <div class="wpo-story-wrap">
                    @php
                    $storyImages = [];
                    if(isset($galeri) && count($galeri) > 0) {
                    $storyImages = $galeri->where('category', App\Enums\GaleriCategoryEnum::STORY->value)->take(3)->values();
                    }
                    @endphp

                    <div class="wpo-story-item">
                        <div class="wpo-story-img-wrap wow fadeInLeftSlow" data-wow-duration="1700ms">
                            <div class="wpo-story-img">
                                @if(isset($storyImages[0]))
                                <img src="{{ strpos($storyImages[0]->image, 'data:image') === 0 ? $storyImages[0]->image : 'data:image/jpeg;base64,' . $storyImages[0]->image }}" alt="Story image 1">
                                @else
                                <img src="{{ asset('lovelove/images/story/5.jpg') }}" alt="Default story image 1">
                                @endif
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
                                @if(isset($storyImages[1]))
                                <img src="{{ strpos($storyImages[1]->image, 'data:image') === 0 ? $storyImages[1]->image : 'data:image/jpeg;base64,' . $storyImages[1]->image }}" alt="Story image 2">
                                @else
                                <img src="{{ asset('lovelove/images/story/6.jpg') }}" alt="Default story image 2">
                                @endif
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
                                @if(isset($storyImages[2]))
                                <img src="{{ strpos($storyImages[2]->image, 'data:image') === 0 ? $storyImages[2]->image : 'data:image/jpeg;base64,' . $storyImages[2]->image }}" alt="Story image 3">
                                @else
                                <img src="{{ asset('lovelove/images/story/7.jpg') }}" alt="Default story image 3">
                                @endif
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
        <!-- In the gallery section -->
        <section class="wpo-portfolio-section-s2 section-padding pb-0" id="gallery">
            <h2 class="hidden">some</h2>
            <div class="container-fluid">
                <div class="sortable-gallery">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="portfolio-grids gallery-container clearfix">
                                @php
                                $defaultImages = [
                                'lovelove/images/portfolio/12.jpg',
                                'lovelove/images/portfolio/13.jpg',
                                'lovelove/images/portfolio/14.jpg',
                                'lovelove/images/portfolio/15.jpg',
                                'lovelove/images/portfolio/16.jpg',
                                'lovelove/images/portfolio/17.jpg',
                                ];

                                $galleryImages = [];
                                $imageCount = 0;
                                if(isset($galeri) && count($galeri) > 0) {
                                $galleryImages = $galeri->where('category', App\Enums\GaleriCategoryEnum::GALLERY->value);
                                $imageCount = $galleryImages->count();
                                }
                                @endphp

                                @if($imageCount > 0)
                                @foreach($galleryImages as $img)
                                <div class="grid">
                                    <div class="img-holder">
                                        @php
                                        $imageSrc = strpos($img->image, 'data:image') === 0
                                        ? $img->image
                                        : 'data:image/jpeg;base64,' . $img->image;
                                        @endphp
                                        <a href="{{ $imageSrc }}" class="fancybox" data-fancybox-group="gall-1">
                                            <img src="{{ $imageSrc }}" alt class="img img-responsive">
                                            <div class="hover-content">
                                                <i class="ti-plus"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                                @endif

                                <!-- Add default images if needed -->
                                @if($imageCount < 6) @for($i=$imageCount; $i < 6; $i++) <div class="grid">
                                    <div class="img-holder">
                                        <a href="{{ asset($defaultImages[$i]) }}" class="fancybox" data-fancybox-group="gall-1">
                                            <img src="{{ asset($defaultImages[$i]) }}" alt class="img img-responsive">
                                            <div class="hover-content">
                                                <i class="ti-plus"></i>
                                            </div>
                                        </a>
                                    </div>
                            </div>
                            @endfor
                            @endif
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>

    <!-- In the events section -->
    <section class="wpo-event-section section-padding pb-0" id="event">
        <div class="container">
            <div class="wpo-section-title">
                <h4>Pernikahan Kami</h4>
                <h2>Kapan & Di Mana</h2>
            </div>

            <div class="wpo-event-wrap">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Event details card with enhanced styling -->
                        <div class="wpo-event-card" style="background: rgba(255,255,255,0.9); border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); padding: 30px; margin: 0 auto 30px; max-width: 800px; position: relative; overflow: hidden;">
                            <div class="row justify-content-center">
                                <div class="col-md-8 text-center">
                                    <div class="wpo-event-item">
                                        <div class="event-icon mb-3">
                                            <i class="fi flaticon-wedding" style="font-size: 40px; color: #c9a74d;"></i>
                                        </div>
                                        <div class="wpo-event-text">
                                            <h3 style="margin-bottom: 15px; color: #333; font-size: 24px;">Akad & Resepsi Pernikahan</h3>
                                            <ul style="list-style: none; padding: 0;">
                                                <li style="margin-bottom: 10px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-calendar" style="margin-right: 10px; color: #c9a74d;"></i>
                                                    <span>{{ $undangan ? \Carbon\Carbon::parse($undangan->tanggal_acara)->format('l, d M. Y') : 'Senin, 12 Apr. 2022' }}</span>
                                                </li>
                                                <li style="margin-bottom: 10px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-clock-o" style="margin-right: 10px; color: #c9a74d;"></i>
                                                    <span>{{ $undangan ? $undangan->waktu_acara : '1:00 PM – 2:30 PM' }}</span>
                                                </li>
                                                <li style="display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-map-marker" style="margin-right: 10px; color: #c9a74d;"></i>
                                                    <span>{{ $undangan ? $undangan->tempat : '4517 Washington Ave. Manchester, Kentucky 39495' }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Responsive Google Maps with enhanced container -->
                    <div class="col-lg-12">
                        <div class="maps-container" style="position: relative; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); margin-bottom: 30px;">
                            <!-- Optional label overlay -->
                            <div class="map-label" style="position: absolute; top: 20px; left: 20px; background: rgba(201, 167, 77, 0.85); color: white; padding: 8px 15px; border-radius: 30px; z-index: 10; font-weight: 600;">
                                <i class="fa fa-map-marker" style="margin-right: 5px;"></i> Lokasi Acara
                            </div>

                            <div class="maps-wrapper" style="padding-bottom: 56.25%; height: 0; position: relative;">
                                <iframe src="{{ $undangan && $undangan->url_maps ?
                                        (strpos($undangan->url_maps, 'output=embed') !== false ?
                                            $undangan->url_maps :
                                            'https://maps.google.com/maps?q=' . str_replace('https://www.google.com/maps?q=', '', $undangan->url_maps) . '&z=15&output=embed') :
                                        'https://maps.google.com/maps?q=-7.031716143360291,111.52387699696449&z=15&output=embed' }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>

                        <!-- Get directions button -->
                        <div class="get-direction-btn text-center mb-4">
                            <a href="{{ $undangan && $undangan->url_maps ? $undangan->url_maps : 'https://www.google.com/maps?q=-7.031716143360291,111.52387699696449' }}" target="_blank" class="theme-btn" style="background: #c9a74d; color: white; border-radius: 30px; padding: 12px 25px; display: inline-flex; align-items: center; text-decoration: none; transition: all 0.3s ease;">
                                <i class="fa fa-location-arrow" style="margin-right: 8px;"></i>
                                Petunjuk Arah
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- In the RSVP section with ucapan/comments -->
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
                                <form method="post" class="contact-validation-active" action="{{ route('ucapan.store') }}" novalidate="novalidate"> @csrf <input type="hidden" name="undangan_id" value="{{ $undangan->id ?? 1 }}">
                                    <div> <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Anda" required> </div>
                                    <div class="attendance-radio" style="margin-bottom: 20px; margin-top: 10px;"> <label style="display: block; margin-bottom: 8px; color: #666; font-size: 15px;">Konfirmasi Kehadiran:</label>
                                        <div style="display: flex; gap: 30px;">
                                            <label class="radio-container" style="position: relative; padding-left: 30px; cursor: pointer; display: flex; align-items: center; font-size: 15px; user-select: none; color: #666; margin: 0;">
                                                <input type="radio" name="kehadiran" value="hadir" required style="position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0;">
                                                <span class="radio-checkmark" style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); height: 18px; width: 18px; background-color: #fff; border: 2px solid #c9a74d; border-radius: 50%;"></span>
                                                <span>Hadir</span>
                                            </label>
                                            <label class="radio-container" style="position: relative; padding-left: 30px; cursor: pointer; display: flex; align-items: center; font-size: 15px; user-select: none; color: #666; margin: 0;">
                                                <input type="radio" name="kehadiran" value="tidak_hadir" required style="position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0;">
                                                <span class="radio-checkmark" style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); height: 18px; width: 18px; background-color: #fff; border: 2px solid #c9a74d; border-radius: 50%;"></span>
                                                <span>Tidak Hadir</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div> <textarea class="form-control" name="ucapan" id="ucapan" placeholder="Tuliskan ucapan dan doa untuk kedua mempelai" rows="4" required></textarea> </div>
                                    <div class="submit-area"> <button type="submit" class="theme-btn">Kirim Ucapan</button>
                                        <div id="c-loader"> <i class="ti-reload"></i> </div>
                                    </div>
                                    <div class="clearfix error-handling-messages">
                                        <div id="success">Terima kasih atas ucapan dan doanya</div>
                                        <div id="error">Terjadi kesalahan saat mengirim ucapan. Silakan coba lagi nanti.</div>
                                    </div>
                                </form>
                                <style>
                                    /* Custom radio button styling */
                                    .radio-container:hover .radio-checkmark {
                                        border-color: #b08c43;
                                    }

                                    .radio-container input:checked~.radio-checkmark {
                                        border-color: #c9a74d;
                                    }

                                    .radio-container input:checked~.radio-checkmark:after {
                                        content: "";
                                        position: absolute;
                                        display: block;
                                        top: 50%;
                                        left: 50%;
                                        transform: translate(-50%, -50%);
                                        width: 10px;
                                        height: 10px;
                                        border-radius: 50%;
                                        background: #c9a74d;
                                    }

                                </style>

                                <script>
                                    // Ensure jQuery is loaded
                                    $(document).ready(function() {
                                        // Form submission handling
                                        $("#contact-form-main").on('submit', function(e) {
                                            e.preventDefault();

                                            var form = $(this);
                                            var url = "";
                                            var formData = form.serialize();

                                            $.ajax({
                                                type: "POST"
                                                , url: url
                                                , data: formData
                                                , beforeSend: function() {
                                                    $("#c-loader").show();
                                                }
                                                , success: function(response) {
                                                    $("#success").fadeIn();
                                                    setTimeout(function() {
                                                        $("#success").fadeOut();
                                                        form[0].reset();
                                                        // Refresh the comments section or append new comment
                                                        window.location.reload();
                                                    }, 2000);
                                                }
                                                , error: function(xhr) {
                                                    $("#error").fadeIn();
                                                    setTimeout(function() {
                                                        $("#error").fadeOut();
                                                    }, 3000);
                                                }
                                                , complete: function() {
                                                    $("#c-loader").hide();
                                                }
                                            });
                                        });
                                    });

                                </script>

                                <!-- Daftar Ucapan -->
                                <div class="wpo-testimonial-wrap" style="margin-top: 50px;">
                                    <div class="wpo-section-title">
                                        <h4>Ucapan dari Tamu</h4>
                                    </div>

                                    <div class="wpo-testimonial-items" style="max-height: 400px; overflow-y: auto; padding-right: 10px;">
                                        @if(isset($ucapan) && count($ucapan) > 0)
                                        @foreach($ucapan as $pesan)
                                        <div class="wpo-testimonial-item" style="background: rgba(250, 250, 250, 0.5); border-radius: 10px; padding: 20px; margin-bottom: 20px; border-left: 3px solid #c9a74d; position: relative;">
                                            <div class="wpo-testimonial-info" style="display: flex; align-items: center; margin-bottom: 10px;">
                                                <div class="wpo-testimonial-info-img" style="width: 50px; height: 50px; border-radius: 50%; background-color: #c9a74d; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                                                    <span style="color: white; font-weight: bold; font-size: 20px;">{{ substr($pesan->nama, 0, 1) }}</span>
                                                </div>
                                                <div class="wpo-testimonial-info-text">
                                                    <h5 style="margin-bottom: 0; color: #333;">{{ $pesan->nama }}</h5>
                                                    <span style="font-size: 12px; color: #666;">
                                                        {{ \Carbon\Carbon::parse($pesan->created_at)->format('d F Y') }} ·
                                                        <span style="color: {{ $pesan->kehadiran === 'hadir' ? '#c9a74d' : '#777' }}; font-weight: 600;">
                                                            {{ $pesan->kehadiran === 'hadir' ? 'Hadir' : 'Tidak Hadir' }}
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                            <p style="margin-bottom: 0; color: #555; line-height: 1.6;">{{ $pesan->ucapan }}</p>
                                        </div>
                                        @endforeach
                                        @else
                                        <!-- Static testimonials when no data is available -->
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
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="shape-1"><img class="floating-item wow fadeInLeftSlow" data-wow-duration="1700ms" src="{{ asset('lovelove/images/contact/shape-1.png') }}" alt=""></div>
                        <div class="shape-2"><img class="floating-item wow fadeInRightSlow" data-wow-duration="1700ms" src="{{ asset('lovelove/images/contact/shape-2.png') }}" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </section>




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
