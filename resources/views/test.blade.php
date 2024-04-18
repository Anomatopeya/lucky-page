@php
use Carbon\Carbon;
    $month = [];

for ($m=1; $m<=12; $m++) {
     $month[] = date('M', mktime(0,0,0,$m, 1, date('Y')));
}

print_r($month);
@endphp
