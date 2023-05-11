@extends("layouts.frontend")
@section("title", "Blog")

@section("breadcrumb")
    <div class="col-xl-9 col-lg-10 col-md-8">
        <h1>Blog</h1>
        <p>Cooking delicious and tasty food since</p>
    </div>
@endsection

@section('content')
    <div class="container margin_60_40">
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    @if(!empty($blogs))
                        @foreach($blogs as $blog)
                            <div class="col-md-6" data-cue="slideInUp">
                                <article class="blog">
                                    <figure>
                                        <a href="{{ route("get.blog", $blog->id) }}"><img
                                                src="{{ asset($blog->thumbnail) }}" alt="{{ $blog->title }}">
                                            <div class="preview"><span>Read more</span></div>
                                        </a>
                                    </figure>
                                    <div class="post_info">
                                        <small>{{ $blog->category->name }}
                                            - {{ $blog->created_at->format('d/m/Y') }}</small>
                                        <h2><a href="{{ route("get.blog", $blog->id) }}">{{ $blog->title }}</a></h2>
                                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($blog->description), 200) }}</p>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!--<div class="pagination_fg">
                    <a href="#">&laquo;</a>
                    <a href="#" class="active">1</a>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <a href="#">4</a>
                    <a href="#">5</a>
                    <a href="#">&raquo;</a>
                </div>-->

            </div>
            <!-- /col -->

            @include("partials.frontend.blogSidebar", [$categories, $latests])
            <!-- /aside -->
        </div>
        <!-- /row -->
    </div>
@endsection
