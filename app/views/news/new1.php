<h1>DANH SÁCH TIN TỨC.</h1>
{{$title}}<br />
{{$new_content}}<br />
{{ 'Unicode' }} <br />
{{ toSlug('Tiêu đề bài viết')}} <br />
{!$new_author!}<br />

@if(!empty($new_author))
<p>tên tác giả: {{$new_author}}</p>
@else
<p>Chưa có tác giả</p>
@endif

@if (md5('123456')!='')
<h4>MD5: {{md5('123456')}} </h4>
@endif

@php
$number = 1;
$number++;
$data = [
        'Item1',
        'Item2',
        'Item3',
    ]
@endphp

{{$number}}</br>

@for( $i = 0; $i < count($data); $i++)
<p>{{$data[$i]}}</p>
@endfor

@while ($i <= 10)
<p>{{$i}}</p>
@php
$i++
@endphp
@endwhile

@foreach($data as $key=>$value)
<p>Key: {{$key}}</p>
<p>Value: {{$value}}</p>
@endforeach