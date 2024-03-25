<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 90%;">
        <div class="modal-content" style="width: 100%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Добавяне на Продукт</h4>
            </div>

            <div class="modal-body search-product-modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="searchbar_product" class="form-label">Търсене</label>
                        <input type="text" class="searchbar-product form-control" id="searchbar_product" placeholder="Търсете по: Име на продукт, продуктов код, марка" autocomplete="off">
                    </div>
                </div>

                <div class="search-product-modal-body-product-list row">
                    @if($products->isNotEmpty())
                        <div class="product-wrapper col-md-4 col-xs-12 hidden">
                            <form></form>
                        </div>
						@foreach($products as $product)
							<div class="product-wrapper col-md-4 col-xs-12">
								<form id="{{$product->id}}" action="{{ route('admin.shop.orders.edit_products_add_product', ['id' => $order->id]) }}" method="POST" class="form-wrapper">
									@csrf
									<input type="hidden" name="product_id" value="{{$product->id}}">
									<div class="basic-info">
										<div class="image">
											<img src="{{$product->getFileUrl()}}" alt="{{ $product->title }}" class="thumbnail img-responsive">
										</div>
										<div>
											<div class="title">{{ $product->title }} / <strong>{{ $product->measure_unit_value }} {{ $product->measureUnit->title }}</strong></div>

											<div class="quantity">
												<input type="number" step="1" min="1" name="product_quantity" value="1">
											</div>

                                            <div class="other-info">
                                                <table width="100%">
                                                    <tbody>
                                                    <tr>
                                                        <td>SKU</td>
                                                        <td>{{ $product->sku }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Марка</td>
                                                        <td>{{ $product->brand->title }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="actions">
                                                <span data-toggle="collapse" data-target="#demo{{ $product->id }}" class="btn btn-primary">Добави, извади, комбинирай</span>
                                                <button type="submit" class="btn btn-success">Добави</button>
                                            </div>
										</div>
									</div>

                                    <div id="demo{{ $product->id }}" class="collapse-panel collapse">
                                        <div class="additives-wrapper">
                                            @include('shop::admin.orders.add_products_modal.additives')
                                        </div>
                                        <div class="additives-wrapper">
                                            @include('shop::admin.orders.add_products_modal.exceptions')
                                        </div>
                                        <div class="collections-wrapper">
                                            @include('shop::admin.orders.add_products_modal.collections')
                                        </div>
                                    </div>
								</form>
							</div>
						@endforeach
					@else
						<div class="alert alert-danger m-b-0"><strong>Внимание! </strong>Няма намерени активни продукти</div>
					@endif
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Затвори</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#searchbar_product').on('input', function() {
            var searchTerm = $(this).val().toLowerCase();

            $('.product-wrapper').each(function() {
                // Get all the text inside the product-wrapper
                var text = $(this).text().toLowerCase();

                // Check if the text contains the search term
                if (text.includes(searchTerm)) {
                    $(this).show(); // Show if the term is found
                } else {
                    $(this).hide(); // Hide if the term is not found
                }
            });
        });


    });
</script>
