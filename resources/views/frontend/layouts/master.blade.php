<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A Big Shout Out</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/Logos/Favicon.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">

    <!-- Custom CSS  -->
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

    <!-- AOS Animation Library  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    @livewireStyles
</head>

<body>
    <!-- First Section with Header -->
    <nav class="menu-on-right">
        <ul>
            <li><a href="#home" class="active text-uppercase">home</a></li>
            <li><a href="#services" class="text-uppercase">services</a></li>
            <li><a href="#about-us" class="text-uppercase">about us</a></li>
            <li><a href="#work" class="text-uppercase">work</a></li>
            <li><a href="#clients" class="text-uppercase">clients</a></li>
            <li><a href="#team" class="text-uppercase">team</a></li>
            <li><a href="#fun-facts" class="text-uppercase">facts</a></li>
            <li><a href="#contact" class="text-uppercase">contact</a></li>
        </ul>
    </nav>

    <div class="header-bg-image" id="home">

        <header>
            <div class="container-lg">
                <div class="header-padding-x mx-xxl-5">

                    <!-- Logo  -->
                    <a href="{{ route('home') }}"><img src="{{ asset('assets/images/Logos/big-shout-out-logo.png') }}" alt="a-big-shout-out-logo" class="logo"></a>

                    <!-- Header Menu for Large Screen  -->
                    <nav>
                        <ul class="head-menu-wrap">
                            <li class="head-menu-item head-list-width first-list"><a href="#services">SERVICES</a></li>
                            <li class="head-menu-item head-list-width second-list"><a href="#about-us">ABOUT US</a></li>
                            <li class="head-menu-item head-list-width fourth-list"><a href="#work">WORK</a></li>
                            <li class="head-menu-item head-list-width fifth-list"><a href="#team">TEAM</a></li>
                            <li class="head-menu-item head-list-width sixth-list"><a href="#contact">CONTACT</a></li>
                        </ul>
                    </nav>


                    <!-- Side Bar for Small Screen  -->
                    <ul id="mobile-sidebar" class="mobile-sidebar">
                        <!-- Cross Menu Button -->
                        <span class="icon-container" onclick="hideSidebar()"><a href="#"><i class="bi bi-x-lg"></i></a></span>
                        <li><a href="#services" onclick="handleSidebarLinkClick(event, '#services')">SERVICES</a></li>
                        <li><a href="#about-us" onclick="handleSidebarLinkClick(event, '#about-us')">ABOUT US</a></li>
                        <li><a href="#work" onclick="handleSidebarLinkClick(event, '#work')">WORK</a></li>
                        <li><a href="#team" onclick="handleSidebarLinkClick(event, '#team')">TEAM</a></li>
                        <li><a href="#contact" onclick="handleSidebarLinkClick(event, '#contact')">CONTACT</a></li>
                    </ul>

                    <!-- Hamburger Menu Button on Small Screen  -->
                    <span class="menu-button" onclick="showSidebar()"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 -960 960 960" width="36px" fill="#ffffff"> <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z" /></svg></a></span>
                
                </div>
            </div>

        </header>

        

        <!-- First Section  -->
        <div class="container-lg">
            <div class="content-1">
                <h1 class="txt-1 text-uppercase fw-bold" data-aos="fade-in" data-aos-delay="500"
                    data-aos-duration="3000">{!! @$slider->caption_description !!}</h1>
                <h1 class="txt-2 text-uppercase fw-bold" data-aos="fade-in" data-aos-delay="500"
                    data-aos-duration="3000"></h1>
                <h6 class="txt-3 text-uppercase fw-bold" data-aos="fade-in" data-aos-delay="2000"
                    data-aos-duration="3000">
                    {{ @$slider->name }}
                </h6>
            </div>
        </div>

    </div>

    <div class="row">
        @include('sweetalert::alert')
    </div>
    <!-- Second Section -->
    <div class="section-2" id="services">
        <div class="container-lg">
            <div class="sec-2-content">
                <!-- Horizontal Line  -->
                <div class="custom-line-white" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1000"></div>
                <!-- Heading  -->
                <h2 class="txt-4 text-uppercase fw-bold" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1000">Our <br> Services</h2>

                <!-- Row and Col  -->
                <div class="row-padding">
                    <div class="row forLargerScreen">
                        @if ($services->count() > 0)
                        @foreach ($services as $service)
                        <div class="col-6 col-lg-3">
                            <div class="custom-line-section-2" data-aos="fade-down" data-aos-delay="200" data-aos-duration="1000"></div>
                            <div class="txt-5 text-uppercase" data-aos="fade-down" data-aos-delay="300" data-aos-duration="1000">
                                {{ $service->name }}
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>

                    <div class="row forMobileScreen">
                        @if ($services->count() > 0)
                        @foreach ($services as $service)
                        <div class="col-6 col-lg-3">
                            <div class="custom-line-section-2" data-aos="fade-right" data-aos-delay="200"
                                data-aos-duration="1000"></div>
                            <div class="txt-5 text-uppercase" data-aos="fade-right" data-aos-delay="300"
                                data-aos-duration="1000">
                                {{ $service->name }}
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- Third Section -->
    <div class="section-3" id="about-us">

        <div class="container-lg">
            <div class="sec-3-content">
                <!-- Horizontal Line  -->
                <div class="custom-line" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1000"></div>
                <!-- Heading  -->
                <h2 class="txt-6 text-uppercase fw-bold" data-aos="fade-right" data-aos-delay="200"
                    data-aos-duration="1000">Who <br>We are </h2>

                <!-- Paragraph  -->
                <div class="txt-7 paragraph" data-aos="fade-in" data-aos-delay="200" data-aos-duration="3000">
                    <p>{!! @$static_page->description !!}</p>
                </div>
            </div>
        </div>
    </div>


    <!-- Fourth Section  -->
    <div class="section-4" id="work">

        <div class="container-lg">
            <div class="sec-4-content">
                <!-- Horizontal Line  -->
                <div class="custom-line" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1000"></div>
                <!-- Heading  -->
                <h2 class="txt-8 text-uppercase fw-bold" data-aos="fade-right" data-aos-delay="200"
                    data-aos-duration="1000">Our <br>Work</h2>

                <!-- Paragraph  -->
                <div class="txt-9 paragraph" data-aos="fade-in" data-aos-delay="200" data-aos-duration="3000">
                    <p>{!! @$work->description !!}</p>
                </div>
            </div>
        </div>

        <!-- Section Gallery  -->
        <div class="section-gallery-1">
            <div class="row">
                @if ($sectors->count() > 0)
                @foreach ($sectors as $sector)
                <div class="col-12 col-lg-6 col-xl-4">
                    <div class="hover-class noHover">
                        <img src="{{ asset('public/storage/uploads/sectors/main_image/thumbnail/list_' . $sector->main_image) }}"
                            id="our-work-img-1" alt="image-of-section-gallery-1">
                        <div class="for-hover">
                            <div class="for-hover-text">
                                <span class="text-uppercase text-above text-white">{{ $sector->name }}</span>
                                <span class="text-below text-white">{!! $sector->description !!}</span>
                            </div>
                        </div>
                    </div>

                    <div class="afterNoHover">
                        <img src="{{ asset('public/storage/uploads/sectors/main_image/thumbnail/list_' . $sector->main_image) }}"
                            id="our-work-img-1" alt="image-of-section-gallery-1">
                        <div class="gallery-1-txt-1">{{ $sector->name }}</div>
                        <div class="gallery-1-txt-2">{!! $sector->description !!}</div>
                        
                    </div>

                </div>
                @endforeach
                @endif
            </div>
        </div>
                
    </div>


    <!-- Fifth Section   -->
    <div class="section-5" id="clients">

        <div class="container-lg">
            <div class="sec-5-content">
                <!-- Horizontal Line  -->
                <div class="custom-line" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1000"></div>
                <!-- Heading -->
                <h2 class="txt-10 text-uppercase fw-bold" data-aos="fade-right" data-aos-delay="200"
                    data-aos-duration="1000">
                    Our <br>Clients
                </h2>

                <!-- Paragraph  -->
                <div class="txt-11 paragraph" data-aos="fade-in" data-aos-delay="200" data-aos-duration="3000">
                    <p>{!! @$client->description !!}
                    </p>
                </div>

                <!-- Section Gallery  -->
                <div class="section-gallery-2">
                    <!-- <img src="./Images/Clients/clients-image.png" alt=""> -->
                    <div class="row">
                        @if ($clients->count() > 0)
                        @foreach ($clients as $client)
                        <div class="col-6 col-xl-3 client-first-row"><img
                                src="{{ asset('public/storage/uploads/clients/organisation_logo/' . $client->organisation_logo) }}"
                                class="img-client-size" alt="client-image" data-aos="fade-right"
                                data-aos-delay="0" data-aos-duration="1500"></div>
                        @endforeach
                        @endif
                    </div> 
                </div>
            </div>
        </div>
    </div>


    <!-- Sixth Section  -->
    <div class="section-6" id="team">

        <div class="container-lg">
            <div class="sec-6-content">
                <!-- Horizontal Line  -->
                <div class="custom-line" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1000"></div>
                <!-- Heading  -->
                <h2 class="txt-12 text-uppercase fw-bold" data-aos="fade-right" data-aos-delay="200"
                    data-aos-duration="1000">
                    Our <br>Team
                </h2>

                <!-- Paragraph  -->
                <div class="txt-13 paragraph" data-aos="fade-in" data-aos-delay="200" data-aos-duration="3000">
                    <p>{!! @$team->description !!}</p>
                </div>
            </div>
        </div>

        <!-- Section Gallery  -->
        <div class="section-gallery-3">
            <div class="row">
                @if ($teams->count() > 0)
                @foreach ($teams as $team)
                <div class="col-12 col-lg-6 col-xl-3">
                    <div class="hover-class noHover">
                        <img src="{{ asset('public/storage/uploads/teams/profile_image/' . $team->profile_image) }}"
                            alt="{{ $team->name }}">
                        <div class="for-hover">
                            <div class="for-hover-text">
                                <span class="text-above text-white">{{ $team->name }}</span>
                                <span class="text-below text-white">{{ $team->designation->title ?? '' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="afterNoHover">
                        <img src="{{ asset('public/storage/uploads/teams/profile_image/' . $team->profile_image) }}"
                            alt="{{ $team->name }}">
                        <div class="gallery-3-txt-1">{{ $team->name }}</div>
                        <div class="gallery-3-txt-2">{{ $team->designation->title ?? '' }}</div> 
                    </div>

                </div>
                @endforeach
                @endif

                
            </div>
        </div>
    </div>


    <!-- Seventh Section  -->
    <div class="section-7" id="fun-facts">

        <div class="container-lg">
            <div class="sec-7-content">

                <!-- Horizontal Line  -->
                <div class="custom-line-white" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1000">
                </div>
                <!-- Heading  -->
                <h2 class="txt-14 text-uppercase fw-bold" data-aos="fade-right" data-aos-delay="200"
                    data-aos-duration="1000">
                    Fun <br>Facts
                </h2>

                <!-- Row and Col for Larger Screen -->
                <div class="row">
                    @if ($fun_facts->count() > 0)
                    @foreach ($fun_facts as $key => $fun)
                    <div class="col-12 col-md-6 col-xl-3 forLargerScreen" data-aos="fade-down" data-aos-delay="300" data-aos-duration="1500">
                        <div class="txt-15-1 fw-bold">
                            {{ ($key<9 ? '0' : '') . $key + 1 }}
                        </div>
                        <div class="txt-15-2 fw-bold">{{ $fun->title }}<br> </div>
                    </div>
                    @endforeach
                    @endif

                   


                    <!-- Row and Col For Mobile Screen -->
                    @if ($fun_facts->count() > 0)
                    @foreach ($fun_facts as $key => $fun)
                    <div class="col-6 forMobileScreen" data-aos="fade-in" data-aos-delay="300"
                        data-aos-duration="1500">
                        <div class="txt-15-1 fw-bold">
                            {{ ($key<9 ? '0' : '') . $key + 1 }}
                        </div>
                        <div class="txt-15-2 fw-bold">{{ $fun->title }}<br> </div>
                    </div>
                    @endforeach
                    @endif

                </div>

            </div>
        </div>
    </div>


    <!-- Eighth Section  -->
    <div class="section-8" id="contact">
        <div class="container-lg">
            <div class="sec-8-content">
                <!-- Horizontal Line  -->
                <div class="custom-line" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1000"></div>
                <!-- Heading  -->
                <h2 class="txt-16 text-uppercase fw-bold" data-aos="fade-right" data-aos-delay="200"
                    data-aos-duration="1000">
                    Get in <br>Touch
                </h2>

                <!-- Row and Col -->
                <div class="row">

                    <!-- Contact Us Form  -->
                    <div class="col-xxl-6 first">
                        <div class="sec-8-col-1">
                            <form action="{{ route('contact.store') }}" id="contact-form" method="post">
                                @csrf
                                <div class="input-container">
                                    <label for="name" class="txt-17" data-aos="fade-up" data-aos-delay="0"
                                        data-aos-duration="2000">Enter Your Name *</label>
                                    <input type="text" id="name" name="name" placeholder="Name"
                                        data-aos="fade-up" data-aos-delay="0" data-aos-duration="2000" required>
                                </div>

                                <div class="input-container">
                                    <label for="email" class="txt-17" data-aos="fade-up" data-aos-delay="0"
                                        data-aos-duration="2000">Enter Your Email *</label>
                                    <input type="email" id="email" name="email" placeholder="Email"
                                        data-aos="fade-up" data-aos-delay="0" data-aos-duration="2000" required>
                                </div>

                                <div class="input-container">
                                    <label for="subject" class="txt-17" data-aos="fade-up" data-aos-delay="0"
                                        data-aos-duration="2000">Enter Your Subject</label>
                                    <input type="text" id="subject" name="subject" placeholder="Subject"
                                        data-aos="fade-up" data-aos-delay="0" data-aos-duration="2000" required>
                                </div>

                                <div class="input-container">
                                    <label for="message" class="txt-17" data-aos="fade-up" data-aos-delay="0"
                                        data-aos-duration="2000">Enter Your Message</label>
                                    <textarea id="message" name="message" placeholder="Message" rows="6" cols="20" data-aos="fade-up"
                                        data-aos-delay="0" data-aos-duration="2000" required></textarea>
                                </div>
                                <div class="input-container recaptcha">
                                    <div>{!! app('captcha')->display() !!}</div>
                                    <div class="text-danger" style="display:none;" id="recaptcha">Recaptcha Field is required</div>
                                </div>

                                <button type="submit" id="submit" title="Submit" class="txt-17-btn" data-aos="fade-up" data-aos-delay="0"
                                    data-aos-duration="2000">Submit</button>
                            </form>
                        </div>
                    </div>

                    <!-- Contact Us Detail  -->
                    <div class="col-xxl-6">
                        <div class="sec-8-col-2">
                            <div class="contact-detail-1 txt-17" data-aos="fade-in" data-aos-delay="200"
                                data-aos-duration="3000">We can't wait to hear from you</div>
                            <div class="contact-detail-2 txt-17" data-aos="fade-in" data-aos-delay="200"
                                data-aos-duration="3000">{{ $siteSetting->title }} <br>
                                {{ $siteSetting->address }} <br>
                                {{ $siteSetting->postal_code }}
                            </div>
                            <div class="contact-detail-3 fw-bold txt-17" data-aos="fade-in" data-aos-delay="300"
                                data-aos-duration="3000">
                                {{ $siteSetting->email }}<br>
                                {{ $siteSetting->phone_no }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Nineth Section (Footer)  -->
    <div class="section-9">
        <footer class="container-lg">
            <div class="footer-content">
                <div class="row">
                    <div class="col-sm-6">
                        @php
                        $currentYear = date('Y');
                        @endphp
                        <div class="txt-19 forLargerScreen">© {{ $currentYear }} by {{ $siteSetting->title }}.
                            <br>Powered and secured by
                            <a href="https://outlines-rnd.com/" target="_blank" class="outlines-link">ORD</a>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="txt-20 forLargerScreen">​Be a SociaLight and  Follow Us:</div>
                        <div>
                            <!-- <img class="sec-9-img forLargerScreen" src="/Images/Footer/999.png" alt=""> -->
                            <div class="row forLargerScreen">
                                @if ($siteSetting->facebook)
                                <div class="col-2 col-lg-1"><a href="{{ $siteSetting->facebook }}" target="_blank" title="Facebook Link"><img
                                            src="{{ asset('assets/images/Social-Media/Facebook.png') }}"
                                            alt="facebook" style="width: 34px; height: 34px"></a></div>
                                @endif
                                @if ($siteSetting->twitter)
                                <div class="col-2 col-lg-1"><a href="{{ $siteSetting->twitter }}" target="_blank" title="Twitter Link"><img
                                            src="{{ asset('assets/images/Social-Media/Twitter.png') }}"
                                            alt="twitter" style="width: 34px; height: 34px"></a></div>
                                @endif
                                @if ($siteSetting->instagram)
                                <div class="col-2 col-lg-1"><a href="{{ $siteSetting->instagram }}" target="_blank" title="Instagram Link"><img
                                            src="{{ asset('assets/images/Social-Media/Instagram.png') }}"
                                            alt="instagram" style="width: 34px; height: 34px"></a></div>
                                @endif
                                @if ($siteSetting->youtube_link)
                                <div class="col-2 col-lg-1"><a href="{{ $siteSetting->youtube_link }}" target="_blank" title="Youtube Link"><img
                                            src="{{ asset('assets/images/Social-Media/Youtube.png') }}"
                                            alt="youtube" style="width: 34px; height: 34px"></a></div>
                                @endif
                                @if ($siteSetting->pinterest)
                                <div class="col-2 col-lg-1"><a href="{{ $siteSetting->pinterest }}" target="_blank" title="Pinterest Link"><img
                                            src="{{ asset('assets/images/Social-Media/Pinterest.png') }}"
                                            alt="pinterest" style="width: 34px; height: 34px"></a></div>
                                @endif
                            </div>
                        </div>
                    </div>


                    <!-- MOBILE SCREEN ONLY -->
                    <div class="col-sm-6">
                        <div class="txt-21 forMobileScreen">​Be a SociaLight and  Follow Us:</div>
                        <div>
                            <!-- <img class="social-media-image forMobileScreen" src="./Images/Footer/999.png" alt=""> -->
                            <div class="row forMobileScreen">
                                @if ($siteSetting->facebook)
                                <div class="col-2">
                                    <a href="{{ $siteSetting->facebook }}" target="_blank" title="Facebook Link">
                                        <img
                                            src="{{ asset('assets/images/Social-Media/Facebook.png') }}"
                                            alt="facebook" style="width: 34px; height: 34px">
                                    </a>
                                </div>

                                @endif
                                @if ($siteSetting->twitter)
                                <div class="col-2">
                                    <a href="{{ $siteSetting->twitter }}" target="_blank" title="Twitter Link">
                                        <img
                                            src="{{ asset('assets/images/Social-Media/Twitter.png') }}"
                                            alt="twitter" style="width: 34px; height: 34px">
                                    </a>
                                </div>

                                @endif
                                @if ($siteSetting->instagram)

                                <div class="col-2">
                                    <a href="{{ $siteSetting->instagram }}" target="_blank" title="Instagram Link">
                                        <img
                                            src="{{ asset('assets/images/Social-Media/Instagram.png') }}"
                                            alt="instagram" style="width: 34px; height: 34px">
                                    </a>
                                </div>

                                @endif
                                @if ($siteSetting->youtube_link)
                                <div class="col-2">
                                    <a href="{{ $siteSetting->youtube_link }}" target="_blank" title="Youtube Link">
                                        <img
                                            src="{{ asset('assets/images/Social-Media/Youtube.png') }}"
                                            alt="youtube" style="width: 34px; height: 34px">
                                    </a>
                                </div>

                                @endif
                                @if ($siteSetting->pinterest)
                                <div class="col-2">
                                    <a href="{{ $siteSetting->pinterest }}" target="_blank" title="Pinterest Link">
                                        <img
                                            src="{{ asset('assets/images/Social-Media/Pinterest.png') }}"
                                            alt="pinterest" style="width: 34px; height: 34px">
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="txt-22 forMobileScreen">© 2035 by SociaLight. <br>
                            Powered and secured by
                            <a href="https://outlines-rnd.com/" target="_blank" class="outlines-link">ORD</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @livewireScripts

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script async src="https://www.google.com/recaptcha/api.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const homeSection = document.getElementById('home');
            const menuItems = document.querySelectorAll('.menu-on-right a');

            // Options for the Intersection Observer
            const options = {
                root: null, // Use the viewport as the root
                threshold: 0.5 // Trigger when 50% of the section is visible
            };

            // Callback function for Intersection Observer
            const observerCallback = (entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Set the active class for home
                        menuItems.forEach(item => {
                            if (item.getAttribute('href') === '#home') {
                                item.classList.add('active');
                            } else {
                                item.classList.remove('active');
                            }
                        });
                    } else {
                        // Remove the active class if not in view
                        menuItems.forEach(item => item.classList.remove('active'));
                    }
                });
            };

            // Create an Intersection Observer instance
            const observer = new IntersectionObserver(observerCallback, options);

            // Start observing the home section
            observer.observe(homeSection);
        });




        function showSidebar() {
            const sidebar = document.querySelector('.mobile-sidebar');
            sidebar.classList.remove('hide');
            sidebar.classList.add('show');
            sidebar.style.display = 'flex';
        }

        function hideSidebar() {
            const sidebar = document.querySelector('.mobile-sidebar');
            sidebar.classList.remove('show');
            sidebar.classList.add('hide');

            setTimeout(() => {
                sidebar.style.display = 'none';
            }, 400);
        }

        function handleSidebarLinkClick(event, target) {
            event.preventDefault();
            hideSidebar();
            setTimeout(() => {
                document.querySelector(target).scrollIntoView({
                    behavior: 'smooth'
                });
            }, 300);
        }


        document.addEventListener('DOMContentLoaded', () => {
            const applyAOSAttributes = () => {
                const elements = document.querySelectorAll('[data-aos]');

                elements.forEach(element => {
                    // Skip elements within .forLargerScreen or .forMobileScreen
                    if (element.closest('.forLargerScreen') || element.closest('.forMobileScreen')) {
                        return;
                    }

                    if (window.innerWidth < 768) {
                        // For small screens, ensure original AOS attributes are preserved
                        const originalAos = element.getAttribute('data-original-aos');
                        const originalDelay = element.getAttribute('data-original-delay');
                        const originalDuration = element.getAttribute('data-original-duration');

                        if (!originalAos) element.setAttribute('data-original-aos', element
                            .getAttribute('data-aos'));
                        if (!originalDelay) element.setAttribute('data-original-delay', element
                            .getAttribute('data-aos-delay'));
                        if (!originalDuration) element.setAttribute('data-original-duration', element
                            .getAttribute('data-aos-duration'));

                        // Apply original AOS attributes for mobile screens
                        element.setAttribute('data-aos', originalAos || element.getAttribute(
                            'data-aos'));
                        element.setAttribute('data-aos-delay', originalDelay || '0');
                        element.setAttribute('data-aos-duration', originalDuration || '1000');
                    } else {
                        // For larger screens, remove AOS attributes
                        element.removeAttribute('data-aos');
                        element.removeAttribute('data-aos-delay');
                        element.removeAttribute('data-aos-duration');
                    }
                });

                // Reinitialize AOS to apply new settings
                AOS.refresh();
            };

            // Initial check
            applyAOSAttributes();

            // Add resize event listener
            window.addEventListener('resize', applyAOSAttributes);

            // Initialize AOS
            AOS.init();
        });

        AOS.init();
    </script>

    <!-- AOS Animation  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#contact-form').on('submit', function(event) {
                event.preventDefault();

                // Clear previous error messages
                $('.input-container').removeClass('is-invalid');
                $('.invalid-feedback').remove();
                var $submitButton = $('#submit');
                $submitButton.prop('disabled', true).text('Processing...');

                // Serialize form data
                var formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        window.location.href = '/';
                        $('#contact-form')[0].reset();
                        grecaptcha.reset();
                    },
                    error: function(xhr) {
                        // Handle validation errors
                        if (xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(field, messages) {
                                // Find the field by ID
                                var $field = $('#' + field);
                                if ($field.length) {
                                    // Add the 'is-invalid' class and error message
                                    $field.closest('.input-container').addClass(
                                            'is-invalid')
                                        .append('<div class="invalid-feedback">' +
                                            messages[0] + '</div>');
                                }

                            });
                        }
                        if (xhr.responseJSON.errors && xhr.responseJSON.errors[
                                'g-recaptcha-response']) {
                            // Display custom error message for reCAPTCHA
                            $('#recaptcha').show()
                            $('.recaptcha').first().before(
                                '<div class="invalid-feedback">Please complete the reCAPTCHA.</div>'
                            );
                        }
                    }
                });
            });
        });
    </script>

    <style>
        .is-invalid input,
        .is-invalid textarea {
            border-color: red;
        }

        .invalid-feedback {
            color: red;
            font-size: 0.875em;
        }
    </style>
</body>

</html>