@extends('layouts.app_content')

@section('title')
  記事詳細
@endsection
<head>
<link rel="stylesheet" href="{{ asset('/css/show.css') }}">
</head>
@section('content')
<div class="show-main">
  <div class="show-box">
    <div class="show-title-box">
      <div class="show-user-data">
        <img src="/storage/profile_image/{{$article->user->profile_image}}" class="show-user-image">
        <li class="show-article-user">
          {{ $article->user->name}}</li>
        </div>
        <li class="show-title">{{$article->title}}</li>
        <li class="show-created-at">{{ $article->created_at->format('Y年m月d日')}}に投稿</li>
       
        @if($article->user_id == Auth::user()->id)
        <div class="show-linkbox">
          <a href="{{ action('ArticleController@edit',$article->id)}}" class="show-link-edit">編集</a>

          <form action="{{ route('article.destroy',     $article->id)}}" method="post"        class="destroy-form">
            @csrf
            @method('delete')
            <input type='submit' value="削除" class="show-link-delete" onclick="return confirm('削除しますか？');">
          </form>
        </div>
      @endif
      </div>
     </div>
      <div class="show-body-box">
        <li class="show-body">{!! $article_parse_body !!}</li>
      </div>
  </div>
@endsection