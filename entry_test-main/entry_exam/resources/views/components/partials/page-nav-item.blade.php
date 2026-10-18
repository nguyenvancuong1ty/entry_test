@if ($url)
    <li class="page-item"><a class="page-link" href="{{ $url }}" rel="{{ $rel }}" aria-label="{{ $aria }}">{{ $label }}</a></li>
@else
    <li class="page-item disabled" aria-disabled="true"><span class="page-link" aria-hidden="true">{{ $label }}</span></li>
@endif
