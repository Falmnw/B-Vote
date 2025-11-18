<?php $i = 1 ?>
@foreach($organizations as $organization)
    <a href="{{ route('viewUserRole' , $organization->id)}}">{{ $i }}. {{ $organization->name }}</a>
    <br>
    <?php $i++ ?>
@endforeach