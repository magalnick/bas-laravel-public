@php
    $hidden_fields_map_callback = function ($field) {
        return "<input type=\"hidden\" name=\"{$field['key']}\" value=\"{$field['value']}\" />";
    };

    $common_hidden_fields = $gift_shop['PayPalStuff']['hiddenFields'];
    array_unshift(
        $common_hidden_fields,
        [
            'key' => 'business',
            'value' => config('bas.contacts.GiftShop.email'),
        ]
    );
    $html_common_hidden_fields = array_map($hidden_fields_map_callback, $common_hidden_fields);
@endphp
<div class="row">
    <div class="col-md">
        <div class="infobox rounded">
            <p>
                What better way to help support the Baja Animal Sanctuary than by purchasing one of the following fun products!
                They also make great gifts for friends and family!
            </p>
            <p>
                Add the items you would like to purchase by clicking on the <span class="font-italic">"Add to Cart"</span> button below the item.
                A PayPal window will open showing the items in your shopping cart.
                You can add as many items as you would like.
                When you are done shopping, click the <span class="font-italic">"PayPal check out"</span> button in your shopping cart to complete your order.
                Note that you do not need to have an existing PayPal account - just follow the checkout instructions to pay via credit card.
            </p>
        </div>

        @foreach ($gift_shop['products'] as $product)
            @if ($product['soldoutPermanently'])
                @continue
            @endif
            @php
                $display_price = sprintf('$%01.2f', $product['price'] / 100);
                $display_price .= $product['shipping'] > 0
                    ? ' (plus ' . sprintf('$%01.2f', $product['shipping'] / 100) . ' shipping per item)'
                    : ' (includes shipping and handling)';

                $display_amount = sprintf('%01.2f', ($product['price'] + $product['shipping']) / 100);
            @endphp
            <div class="infobox rounded">
                <p class="h5">{{ $product['title'] }}</p>

                @foreach ($product['images'] as $image)
                    <div><img src="{{ $image }}" alt="{{ $product['title'] }}" style="width: 50%;" /></div>
                @endforeach

                @foreach ($product['colors'] as $color)
                    @php
                        $sizes = array_map(
                            function ($size) {
                                return $size['size'];
                            },
                            $color['sizes']
                        );
                    @endphp
                    <p>&nbsp;</p>
                    <p class="h6 font-weight-bold">{!! $color['description'] !!}</p>
                    <div>{{ $display_price }}</div>
                    @if ($color['sizeSummary'])
                        <div style="font-size: 0.8rem;">(Sizes: {{ join(', ', $sizes) }})</div>
                    @endif

                    @foreach ($color['sizes'] as $size)
                        @php
                            $specific_hidden_fields = [
                                [
                                    'key'   => 'item_name',
                                    'value' => $size['paypal']['item_name'],
                                ],
                                [
                                    'key'   => 'item_number',
                                    'value' => $size['paypal']['item_number'],
                                ],
                                [
                                    'key'   => 'amount',
                                    'value' => $display_amount,
                                ],
                            ];
                            $html_specific_hidden_fields = array_map($hidden_fields_map_callback, $specific_hidden_fields);
                        @endphp
                        <div class="mt-2">
                            @if ($size['soldout'])
                                <button class="text-left btn btn-outline-cta disabled" style="width: 30%; min-width: 280px;">
                                    <i class="fa fa-frown-o" aria-hidden="true"></i>
                                    (Sold out)
                                    {{ $gift_shop['AddToCartButtons'][$size['size']] }}
                                </button>
                            @else
                                <form target="paypal" action="{{ $gift_shop['PayPalStuff']['formPost'] }}" method="post">
                                    <button class="text-left btn btn-outline-cta" type="submit" name="submit" style="width: 30%; min-width: 280px;">
                                        <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                        {{ $gift_shop['AddToCartButtons'][$size['size']] }}
                                    </button>
                                    <img src="{{ $gift_shop['PayPalStuff']['pixelGif'] }}" alt="pixel" style="width: 1px; height: 1px; border: 0;" />
                                    {!! join("\n", $html_specific_hidden_fields) !!}
                                    {!! join("\n", $html_common_hidden_fields) !!}
                                </form>
                            @endif
                        </div>
                    @endforeach
                @endforeach
            </div>
        @endforeach
    </div>

    <div class="col-md-3 text-center">
        <form name="_xclick" target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_cart" />
            <input type="hidden" name="business" value="{{ config('bas.contacts.GiftShop.email') }}">
            <button class="btn btn-outline-cta btn-lg btn-block" type="submit" name="submit" style="width: 100%;">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                View Cart
            </button>
            <input type="hidden" name="display" value="1">
        </form>
    </div>
</div>
