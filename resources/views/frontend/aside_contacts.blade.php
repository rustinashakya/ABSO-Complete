<div class="aside-contacts">
    <div class="row row-30">
        <div class="col-sm-6 col-lg-12 aside-contacts-item">
            @if(!empty($shared_site_setting->facebook) || !empty($shared_site_setting->twitter) ||
            !empty($shared_site_setting->instagram) || !empty($shared_site_setting->google_plus))
            <p class="aside-contacts-title wow fadeInRight" data-wow-duration="1s" data-wow-delay=".1s">Get social</p>
            @endif
            <ul class="list-inline contacts-social-list list-inline-sm wow fadeInRight" data-wow-duration="1s" data-wow-delay=".2s">
                @if(!empty($shared_site_setting->facebook))
                <li><a class="icon mdi mdi-facebook" tile="View on facebook" target="_blank" href="{{$shared_site_setting->facebook}}"></a></li>
                @endif
                @if(!empty($shared_site_setting->twitter))
                <li><a class="icon mdi mdi-twitter" tile="View on twitter" target="_blank" href="{{$shared_site_setting->twitter}}"></a></li>
                @endif
                @if(!empty($shared_site_setting->instagram))
                <li><a class="icon mdi mdi-instagram" tile="View on instagram" target="_blank" href="{{$shared_site_setting->instagram}}"></a>
                </li>
                @endif
                @if(!empty($shared_site_setting->google_plus))
                <li><a class="icon mdi mdi-google-plus" tile="View on google plus" target="_blank"
                        href="{{$shared_site_setting->google_plus}}"></a></li>
                @endif
            </ul>
        </div>
        <div class="col-sm-6 col-lg-12 aside-contacts-item">
            <p class="aside-contacts-title wow fadeInRight" data-wow-duration="1s" data-wow-delay=".3s">Phone</p>
            <div class="unit unit-spacing-xs justify-content-center justify-content-md-start wow fadeInRight" data-wow-duration="1s" data-wow-delay=".4s">
                <div class="unit-left"><span class="icon mdi mdi-phone"></span></div>
                <div class="unit-body">
                    <a class="phone" href="tel:{{$shared_site_setting->phone_no}}"
                        title="Call {{$shared_site_setting->phone_no}}">{{$shared_site_setting->phone_no}}</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-12 aside-contacts-item">
            <p class="aside-contacts-title wow fadeInRight" data-wow-duration="1s" data-wow-delay=".5s">E-mail</p>
            <div class="unit unit-spacing-xs justify-content-center justify-content-md-start wow fadeInRight" data-wow-duration="1s" data-wow-delay=".6s">
                <div class="unit-left"><span class="icon mdi mdi-email-outline"></span></div>
                <div class="unit-body">
                    <a class="mail" href="mailto:{{$shared_site_setting->email}}"
                        title="Mail to {{$shared_site_setting->email}}">{{$shared_site_setting->email}}</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-12 aside-contacts-item">
            <p class="aside-contacts-title wow fadeInRight" data-wow-duration="1s" data-wow-delay=".7s">Address</p>
            <div class="unit unit-spacing-xs justify-content-center justify-content-md-start wow fadeInRight" data-wow-duration="1s" data-wow-delay=".8s">
                <div class="unit-left"><span class="icon mdi mdi-map-marker"></span></div>
                <div class="unit-body">{{$shared_site_setting->address}}</div>
            </div>
        </div>
    </div>
</div>
