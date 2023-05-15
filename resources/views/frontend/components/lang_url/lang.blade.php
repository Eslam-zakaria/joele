@if(app()->getLocale() == 'en')
<div class="top-bar__block lang d-flex">
    <a class="top-bar__link" href="{{ url('/').$path }}"> <span class="top-bar__link-icon">
        <picture>
            <source srcset="{{ asset('frontend/images/icons/icons.svg#lang') }}" type="image/webp" />
            <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#lang') }}" alt="Language Icon" />
        </picture>
        </span> <span class="top-bar__link-text">عربى</span>
    </a>
</div>
@else
<div class="top-bar__block lang d-flex">
    <a class="top-bar__link" href="{{ url('/').'/en'.$path }}"> <span class="top-bar__link-icon">
        <picture>
            <source srcset="{{ asset('frontend/images/icons/icons.svg#lang') }}" type="image/webp" />
            <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#lang') }}" alt="Language Icon" />
        </picture>
        </span> <span class="top-bar__link-text">English</span>
    </a>
</div>
@endif