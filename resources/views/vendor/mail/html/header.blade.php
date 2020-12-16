<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{asset('vendors/mainpage/assets/img/logo.png')}}" alt="AFPA">

@else
{{ $slot }}
@endif
</a>
</td>
</tr>
