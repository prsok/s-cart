@php
/*
$layout_page = product_list
$subCategory: paginate
Use paginate: $subCategory->appends(request()->except(['page','_token']))->links()
$products: paginate
Use paginate: $products->appends(request()->except(['page','_token']))->links()
*/ 
@endphp

@extends($sc_templatePath.'.layout')

{{-- block_main_content_center --}}
@section('block_main_content_center')
<div class="col-lg-8 col-xl-9">

  {{-- sub category --}}
  @isset ($subCategory)
  @if($subCategory->count())
  <h6 class="aside-title">{{ trans('front.sub_categories') }}</h6>
  <div class="row item-folder">
      @foreach ($subCategory as $key => $item)
      <div class="col-6 col-sm-6 col-md-3">
          <div class="item-folder-wrapper product-single">
              <div class="single-products">
                  <div class="productinfo text-center product-box-{{ $item->id }}">
                      <a href="{{ $item->getUrl() }}"><img src="{{ asset($item->getThumb()) }}"
                              alt="{{ $item->title }}" /></a>
                      <a href="{{ $item->getUrl() }}">
                          <p>{{ $item->title }}</p>
                      </a>
                  </div>
              </div>
          </div>
      </div>
      @endforeach
      <div style="clear: both; ">
          <ul class="pagination">
              {{ $subCategory->appends(request()->except(['page','_token']))->links() }}
          </ul>
      </div>
  </div>
  @endif
  @endisset
  {{-- //sub category --}}

  {{-- Sort filter --}}
  <div class="product-top-panel group-md">
    <p class="product-top-panel-title">
      {!! trans('front.result_item', ['item_from' => $products->firstItem(), 'item_to'=> $products->lastItem(), 'item_total'=> $products->total()  ]) !!}
    </p>
        <form action="" method="GET" id="filter_sort">
          @php
          $queries = request()->except(['filter_sort','page']);
          @endphp
          @foreach ($queries as $key => $query)
          <input type="hidden" name="{{ $key }}" value="{{ $query }}">
          @endforeach
          
          <select class="form-control" name="filter_sort">
              <option value="">{{ trans('front.filters.sort') }}</option>
              <option value="price_asc" {{ ($filter_sort =='price_asc')?'selected':'' }}>
                  {{ trans('front.filters.price_asc') }}</option>
              <option value="price_desc" {{ ($filter_sort =='price_desc')?'selected':'' }}>
                  {{ trans('front.filters.price_desc') }}</option>
              <option value="sort_asc" {{ ($filter_sort =='sort_asc')?'selected':'' }}>
                  {{ trans('front.filters.sort_asc') }}</option>
              <option value="sort_desc" {{ ($filter_sort =='sort_desc')?'selected':'' }}>
                  {{ trans('front.filters.sort_desc') }}</option>
              <option value="id_asc" {{ ($filter_sort =='id_asc')?'selected':'' }}>{{ trans('front.filters.id_asc') }}
              </option>
              <option value="id_desc" {{ ($filter_sort =='id_desc')?'selected':'' }}>
                  {{ trans('front.filters.id_desc') }}</option>
          </select>
        </form>
  </div>
  {{-- //Sort filter --}}

  {{-- Product list --}}
  <div class="row row-30 row-lg-50">
    @foreach ($products as $key => $product)
    <div class="col-sm-6 col-md-4 col-lg-6 col-xl-4">
        <!-- Product-->
        <article class="product wow fadeInRight">
          <div class="product-body">
            <div class="product-figure">
                <a href="{{ $product->getUrl() }}">
                <img src="{{ asset($product->getThumb()) }}" alt="{{ $product->name }}"/>
                </a>
            </div>
            <h5 class="product-title"><a href="{{ $product->getUrl() }}">{{ $product->name }}</a></h5>

            {{-- Go to store --}}
            @if (sc_config_global('MultiStorePro') && config('app.storeId') == 1)
            <div class="store-url"><a href="{{ $product->goToStore() }}"><i class="fa fa-shopping-bag" aria-hidden="true"></i> {{ trans('front.store').' '. $product->store_id  }}</a>
            </div>
            @endif
            {{-- End go to store --}}

            @if ($product->allowSale())
            <a onClick="addToCartAjax('{{ $product->id }}','default')" class="button button-lg button-secondary button-zakaria add-to-cart-list">
              <i class="fa fa-cart-plus"></i> {{trans('front.add_to_cart')}}</a>
            @endif

            {!! $product->showPrice() !!}
          </div>
          
          @if ($product->price != $product->getFinalPrice() && $product->kind !=
          SC_PRODUCT_GROUP)
          <span><img class="product-badge new" src="{{ asset($sc_templateFile.'/images/home/sale.png') }}" class="new" alt="" /></span>
          @elseif($product->kind == SC_PRODUCT_BUILD)
          <span><img class="product-badge new" src="{{ asset($sc_templateFile.'/images/home/bundle.png') }}" class="new" alt="" /></span>
          @elseif($product->kind == SC_PRODUCT_GROUP)
          <span><img class="product-badge new" src="{{ asset($sc_templateFile.'/images/home/group.png') }}" class="new" alt="" /></span>
          @endif
          <div class="product-button-wrap">
            <div class="product-button">
                <a class="button button-secondary button-zakaria" onClick="addToCartAjax('{{ $product->id }}','wishlist')">
                    <i class="fas fa-heart"></i>
                </a>
            </div>
            <div class="product-button">
                <a class="button button-primary button-zakaria" onClick="addToCartAjax('{{ $product->id }}','compare')">
                    <i class="fa fa-exchange"></i>
                </a>
            </div>
          </div>
        </article>
      </div>
    @endforeach
  </div>

  <div class="pagination-wrap">
    <!-- Bootstrap Pagination-->
    <nav aria-label="Page navigation">
      <ul class="pagination">
        {{ $products->appends(request()->except(['page','_token']))->links() }}
      </ul>
    </nav>
  </div>
  {{-- //Product list --}}
@endsection
{{-- //block_main_content_center --}}


{{-- breadcrumb --}}
@section('breadcrumb')
@php
if(empty($bannerImage)) {
  $bannerBreadcrumb = $modelBanner->start()->getBreadcrumb()->getData()->first();
  $bannerImage = $bannerBreadcrumb['image'];
}
@endphp
<section class="breadcrumbs-custom">
  <div class="parallax-container" data-parallax-img="{{ asset($bannerImage ?? '') }}">
    <div class="material-parallax parallax"><img src="{{ asset($bannerImage ?? '') }}" alt="" style="display: block; transform: translate3d(-50%, 83px, 0px);"></div>
    <div class="breadcrumbs-custom-body parallax-content context-dark">
      <div class="container">
        <h2 class="breadcrumbs-custom-title">{{ $title ?? '' }}</h2>
      </div>
    </div>
  </div>
  <div class="breadcrumbs-custom-footer">
    <div class="container">
      <ul class="breadcrumbs-custom-path">
        <li><a href="{{ sc_route('home') }}">{{ trans('front.home') }}</a></li>
        <li class="active">{{ $title ?? '' }}</li>
      </ul>
    </div>
  </div>
</section>
@endsection
{{-- //breadcrumb --}}

@push('styles')
@endpush

@push('scripts')
<script type="text/javascript">
  $('[name="filter_sort"]').change(function(event) {
      $('#filter_sort').submit();
  });
</script>
@endpush