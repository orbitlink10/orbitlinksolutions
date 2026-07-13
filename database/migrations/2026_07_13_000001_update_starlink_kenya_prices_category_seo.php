<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('categories')
            ->where('slug', 'starlink-kenya-prices')
            ->update([
                'meta_description' => 'Compare Starlink Kenya prices for kits, accessories, and installation support. Shop genuine hardware from Orbitlink Solutions with expert setup help.',
                'description' => <<<'HTML'
<h2>Starlink Kenya Prices: Kits, Accessories, and Installation Guide for 2026</h2>
<p><strong>Last updated: July 13, 2026.</strong> Use this page to compare Orbitlink Solutions Starlink kit and accessory prices in Kenya. Hardware prices are shown in the product grid above and may change with stock, model, exchange rates, and installation requirements.</p>

<h2>What the Starlink price usually includes</h2>
<p>The total cost of getting connected normally has three parts: the Starlink hardware, any accessories needed for a clean installation, and the monthly Starlink service plan selected during activation.</p>
<ul>
    <li><strong>Hardware:</strong> Starlink kits, Starlink Mini kits, high performance kits, power supplies, cables, mounts, and backup power bundles.</li>
    <li><strong>Installation:</strong> site survey, safe mounting, cable routing, dish alignment, router setup, and WiFi checks.</li>
    <li><strong>Subscription:</strong> Starlink monthly service plans are paid separately and can change. Confirm the active plan price during activation or ask Orbitlink for current guidance.</li>
</ul>

<h2>Starlink kit and accessory price guide in Kenya</h2>
<table>
    <tbody>
        <tr>
            <th>Item</th>
            <th>Best for</th>
            <th>Price guidance</th>
        </tr>
        <tr>
            <td>Starlink Standard Kit</td>
            <td>Homes, offices, schools, and small businesses</td>
            <td>See live product price above</td>
        </tr>
        <tr>
            <td>Starlink Mini Kit</td>
            <td>Portable use, backup connectivity, and smaller sites</td>
            <td>See live product price above</td>
        </tr>
        <tr>
            <td>High Performance Kits</td>
            <td>Business, remote sites, hospitality, and demanding users</td>
            <td>See live product price above</td>
        </tr>
        <tr>
            <td>Mounts, cables, adapters, and power accessories</td>
            <td>Stable roof, wall, pole, or backup power setups</td>
            <td>Depends on the accessory and site needs</td>
        </tr>
    </tbody>
</table>

<h2>Installation costs and what affects the final quote</h2>
<p>Installation pricing depends on the roof type, cable distance, mounting height, obstruction level, backup power needs, and whether the site needs extra networking equipment such as routers, access points, or CCTV connectivity. Orbitlink can quote after checking the location and preferred setup.</p>

<h2>How to choose the right Starlink setup</h2>
<ul>
    <li><strong>Home users:</strong> choose a standard kit or Mini kit based on budget, space, and expected usage.</li>
    <li><strong>Businesses:</strong> consider backup power, stronger WiFi coverage, structured cabling, and failover with existing internet.</li>
    <li><strong>Remote sites:</strong> prioritize mounting height, clear sky view, weatherproof cable routing, and power stability.</li>
    <li><strong>Heavy users:</strong> compare standard and high performance options before buying.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>How much is a Starlink kit in Kenya?</h3>
<p>Starlink kit pricing in Kenya depends on the model, stock, accessories, and installation needs. Check the product prices on this category page or contact Orbitlink Solutions for a current quote.</p>

<h3>Does Orbitlink Solutions install Starlink in Kenya?</h3>
<p>Yes. Orbitlink Solutions supplies Starlink kits and accessories and can help with installation, mounting, alignment, WiFi setup, and support for homes and businesses in Kenya.</p>

<h3>Are Starlink monthly subscription prices included in the kit price?</h3>
<p>No. Hardware and installation are separate from Starlink monthly service plans. Subscription plans can change, so confirm the active plan price during activation or with Orbitlink Solutions before purchase.</p>

<h2>Order Starlink hardware from Orbitlink Solutions</h2>
<p>Browse the products above, choose the kit or accessory you need, or contact Orbitlink Solutions for installation support before you buy.</p>
<p><a href="/category/starlink-kenya-prices#category-products">Shop Starlink products</a> or <a href="/contacts">talk to Orbitlink Solutions</a>.</p>
HTML,
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        // Content migration only. The previous CMS copy is intentionally not restored.
    }
};
