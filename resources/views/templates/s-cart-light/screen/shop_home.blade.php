@php
/*
$layout_page = shop_home
*/ 
@endphp

@extends($sc_templatePath.'.layout')
@php
$productsNew = $modelProduct->start()->getProductLatest()->setlimit(sc_config('product_top'))->getData();
$news = $modelNews->start()->setlimit(sc_config('item_top'))->getData();
@endphp

@section('block_main')
      <!-- New Products-->
      <section class="section section-xxl bg-default">
        <div class="container">
          <h2 class="wow fadeScale">{{ trans('front.features_items') }}</h2>
          <div class="row row-30 row-lg-50">
            @foreach ($productsNew as $key => $productNew)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <!-- Product-->
                <article class="product wow fadeInRight">
                  <div class="product-body">
                    <div class="product-figure">
                        <a href="{{ $productNew->getUrl() }}">
                        <img src="{{ asset($productNew->getThumb()) }}" alt="{{ $productNew->name }}"/>
                        </a>
                    </div>
                    <h5 class="product-title"><a href="{{ $productNew->getUrl() }}">{{ $productNew->name }}</a></h5>
                    @if (sc_config_global('MultiStorePro') && config('app.storeId') == 1)
                    <div class="store-url"><a href="{{ $productNew->goToStore() }}"><i class="fa fa-shopping-bag" aria-hidden="true"></i> {{ trans('front.store').' '. $productNew->store_id  }}</a>
                    </div>
                    @endif
                    @if ($productNew->allowSale())
                    <a onClick="addToCartAjax('{{ $productNew->id }}','default')" class="button button-lg button-secondary button-zakaria add-to-cart-list"><i class="fa fa-cart-plus"></i> {{trans('front.add_to_cart')}}</a>
                    @endif

                    {!! $productNew->showPrice() !!}
                  </div>
                  
                  @if ($productNew->price != $productNew->getFinalPrice() && $productNew->kind !=
                  SC_PRODUCT_GROUP)
                  <span><img class="product-badge new" src="{{ asset($sc_templateFile.'/images/home/sale.png') }}" class="new" alt="" /></span>
                  @elseif($productNew->kind == SC_PRODUCT_BUILD)
                  <span><img class="product-badge new" src="{{ asset($sc_templateFile.'/images/home/bundle.png') }}" class="new" alt="" /></span>
                  @elseif($productNew->kind == SC_PRODUCT_GROUP)
                  <span><img class="product-badge new" src="{{ asset($sc_templateFile.'/images/home/group.png') }}" class="new" alt="" /></span>
                  @endif
                  <div class="product-button-wrap">
                    <div class="product-button">
                        <a class="button button-secondary button-zakaria" onClick="addToCartAjax('{{ $productNew->id }}','wishlist')">
                            <i class="fas fa-heart"></i>
                        </a>
                    </div>
                    <div class="product-button">
                        <a class="button button-primary button-zakaria" onClick="addToCartAjax('{{ $productNew->id }}','compare')">
                            <i class="fa fa-exchange"></i>
                        </a>
                    </div>
                  </div>
                </article>
              </div>
            @endforeach
          </div>
        </div>
      </section>      
@endsection

@section('news')
@if ($news)
<!-- Our Blog-->
<section class="section section-xxl section-last bg-gray-21">
  <div class="container">
    <h2 class="wow fadeScale">{{ trans('front.blog') }}</h2>
  </div>
  <!-- Owl Carousel-->
  <div class="owl-carousel owl-style-7" data-items="1" data-sm-items="2" data-xl-items="3" data-xxl-items="4" data-nav="true" data-dots="true" data-margin="30" data-autoplay="true">
    @foreach ($news as $blog)
    <!-- Post Creative-->
    <article class="post post-creative"><a class="post-creative-figure" href="{{ $blog->getUrl() }}"><img src="{{ asset($blog->getThumb()) }}" alt="" width="420" height="368"/></a>
      <div class="post-creative-content">
        <h5 class="post-creative-title"><a href="{{ $blog->getUrl() }}">{{ $blog->title }}</a></h5>
        <div class="post-creative-time">
          <time datetime="{{ $blog->created_at }}">{{ $blog->created_at }}</time>
        </div>
      </div>
    </article>
    @endforeach
  </div>
</section>
@endif
@endsection

@push('styles')
@endpush

@push('scripts')

@endpush
