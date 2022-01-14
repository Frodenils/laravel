@extends('layout.app')

@section('content')
<h1>{{  $post->content  }}</h1>
    <span>{{ $post->image ? $post->image-path : "pas d'image" }}</span>
    <hr>
    @forelse($post->comments as $comment)
        <div>{{ $comment->content }} | créé le  {{ $comment->created_at->format('d m Y') }}</div>
    @empty
        <span>Aucun commentaire</span>
    @endforelse
@endsection