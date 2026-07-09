<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">
  <channel>
    <title>Your Store Name</title>
    <link>{{ url('/') }}</link>
    <description>Product feed for Google Merchant Center</description>
    @foreach($products as $product)
    <item>
      <g:id>{{ $product->id }}</g:id>
      <g:title>{{ $product->name }}</g:title>
      <g:description><![CDATA[{{ $product->description }}]]></g:description>
      <g:link>{{ route('product_details', $product->slug) }}</g:link>
      <g:image_link>{{ url('/storage/' . $product->photo) }}</g:image_link>
      <g:price>{{ number_format($product->price, 2) }} KES</g:price>
      <g:availability>in stock</g:availability>
      <g:brand>{{ $product->brand ?? 'Your Brand' }}</g:brand>
      <g:condition>new</g:condition>
      <!-- Add any additional fields as required -->
    </item>
    @endforeach
  </channel>
</rss>
