<tr>
    @for ($i = 1; $i <= 10; $i++)
        @if ($i == $level)
            <td>
                {{ $referral->name }} ({{ $referral->refer_code }})<br>
                Referrals: {{ $referral->referrals->count() }}
            </td>
        @else
            <td></td>
        @endif
    @endfor
</tr>
@if($level < 10)
    @foreach($referral->sub_referrals as $sub_referral)
        @include('admin.mlm.partials.referral', ['referral' => $sub_referral, 'level' => $level + 1])
    @endforeach
@endif