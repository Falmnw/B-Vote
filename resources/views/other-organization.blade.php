<h3>Daftar Organisasi:</h3>
<?php $i = 1 ?>
@foreach($organizations as $organization)
    @if(!$user->organizations->contains($organization->id))
        <a style="text-decoration: none;" href="{{ route('organization.show', $organization->id) }}">{{ $i }}. {{ $organization->name }} </a><br>
        <?php $i++ ?>
    @endif
@endforeach