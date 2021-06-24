<div class="col-sm-3">
    <div class="left-sidebar">
        <h2>Danh mục sản phẩm</h2>
        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
            @foreach($categories as $categoriesItem)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            @if($categoriesItem->category->count())
                                <a data-toggle="collapse" data-parent="#accordian" href="#sportswear_{{$categoriesItem->id}}  ">
                                <span class="badge pull-right">
                                    <i class="fa fa-plus"></i>
                                </span>
                                    {{$categoriesItem->name}}
                                </a>
                            @else
                                <a href="{{ route('category.product',['slug'=>$categoriesItem->slug, 'id'=>$categoriesItem->id]) }}">
                                <span class="badge pull-right">
                                </span>
                                    {{$categoriesItem->name}}
                                </a>
                            @endif
                        </h4>
                    </div>


                    <div id="sportswear_{{$categoriesItem->id}}" class="panel-collapse collapse">
                        <div class="panel-body">
                            <ul>
                                @foreach($categoriesItem->category as $categoryChildren)
                                    <li><a href="{{ route('category.product',
                                                    ['slug'=>$categoryChildren->slug,
                                                    'id'=>$categoryChildren->id]) }}">
                                            {{$categoryChildren->name}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
            @endforeach
        </div><!--/category-products-->
        <div class="brands_products"><!--brands_products-->
            <h2>Sản phẩm yêu thích</h2>
            <div class="brands-name">
                <div id="row_wishlist" class="row">

                </div>
            </div>
        </div><!--/brands_products-->
    </div>
</div>
