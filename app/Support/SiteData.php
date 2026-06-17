<?php

namespace App\Support;

class SiteData
{
    public static function categories(): array
    {
        return [
            ['name' => 'Custom Jigs', 'slug' => 'custom-jigs', 'description' => 'Hand-tied jigs built for local saltwater conditions.', 'accent' => 'from-sky-300 to-cyan-500'],
            ['name' => 'Jig Heads', 'slug' => 'jig-heads', 'description' => 'Durable jig heads poured for clean action and solid hooksets.', 'accent' => 'from-blue-300 to-sky-600'],
            ['name' => 'Bucktail Jigs', 'slug' => 'bucktail-jigs', 'description' => 'Classic bucktails with flash, profile, and dependable movement.', 'accent' => 'from-cyan-300 to-teal-500'],
            ['name' => 'Snook Jigs', 'slug' => 'snook-jigs', 'description' => 'Purpose-built tackle for docks, bridges, passes, and beaches.', 'accent' => 'from-sky-400 to-blue-700'],
            ['name' => 'Pompano Jigs', 'slug' => 'pompano-jigs', 'description' => 'Compact surf jigs made for clean presentation and fast bites.', 'accent' => 'from-cyan-200 to-sky-500'],
            ['name' => 'Specialty Tackle', 'slug' => 'specialty-tackle', 'description' => 'Custom color, weight, and profile options for serious anglers.', 'accent' => 'from-blue-200 to-indigo-600'],
            ['name' => 'Fishing Accessories', 'slug' => 'fishing-accessories', 'description' => 'Hooks, packs, and small essentials for saltwater trips.', 'accent' => 'from-slate-200 to-sky-500'],
            ['name' => 'Apparel', 'slug' => 'apparel', 'description' => 'Comfortable fishing apparel for long days on the water.', 'accent' => 'from-sky-100 to-cyan-400'],
        ];
    }

    public static function products(): array
    {
        return [
            ['name' => 'Sarasota Snook Jig', 'slug' => 'sarasota-snook-jig', 'price' => 8.99, 'sale_price' => null, 'stock' => 40, 'sku' => 'MM-SNOOK-001', 'category_slug' => 'snook-jigs', 'short_description' => 'A balanced snook jig with strong flash and dependable dock-light action.', 'description' => 'Designed for Sarasota passes, bridges, and grass edges where snook respond to a compact profile with controlled flare.', 'image' => null, 'status' => 'active', 'color' => 'from-sky-200 via-white to-blue-400', 'rating' => 5, 'specs' => ['Weight: 1/2 oz', 'Hook: Saltwater-grade', 'Finish: Powder coated', 'Best for: Snook, trout, redfish']],
            ['name' => 'Bluewater Bucktail Jig', 'slug' => 'bluewater-bucktail-jig', 'price' => 10.50, 'sale_price' => null, 'stock' => 35, 'sku' => 'MM-BUCK-002', 'category_slug' => 'bucktail-jigs', 'short_description' => 'A bright bucktail jig tied for clear water, current, and aggressive strikes.', 'description' => 'Premium hair, flash, and a clean head finish help this jig track naturally through moving water.', 'image' => null, 'status' => 'active', 'color' => 'from-blue-200 via-cyan-100 to-sky-600', 'rating' => 5, 'specs' => ['Weight: 3/4 oz', 'Material: Bucktail hair', 'Water: Inshore and nearshore', 'Action: Swimming retrieve']],
            ['name' => 'Heavy Duty Jig Head', 'slug' => 'heavy-duty-jig-head', 'price' => 6.75, 'sale_price' => null, 'stock' => 60, 'sku' => 'MM-HEAD-003', 'category_slug' => 'jig-heads', 'short_description' => 'Tough jig heads for anglers who need strength around structure.', 'description' => 'A clean, durable jig head option for pairing with soft plastics in saltwater situations.', 'image' => null, 'status' => 'active', 'color' => 'from-slate-100 via-sky-100 to-cyan-500', 'rating' => 4, 'specs' => ['Weight: 1 oz', 'Pack: 3 count', 'Hook: Heavy wire', 'Finish: Chip-resistant']],
            ['name' => 'Pompano Surf Jig', 'slug' => 'pompano-surf-jig', 'price' => 7.25, 'sale_price' => null, 'stock' => 45, 'sku' => 'MM-POMP-004', 'category_slug' => 'pompano-jigs', 'short_description' => 'Compact jig made for beach, surf, and sandbar presentations.', 'description' => 'Built for quick casts, bright flash, and a subtle profile when pompano are cruising the troughs.', 'image' => null, 'status' => 'active', 'color' => 'from-cyan-100 via-white to-amber-100', 'rating' => 5, 'specs' => ['Weight: 1/4 oz', 'Profile: Compact', 'Best for: Surf fishing', 'Finish: Bright accent']],
            ['name' => 'Custom Flare Hawk Jig', 'slug' => 'custom-flare-hawk-jig', 'price' => 12.99, 'sale_price' => null, 'stock' => 25, 'sku' => 'MM-FLARE-005', 'category_slug' => 'custom-jigs', 'short_description' => 'Handmade flare hawk style jig with custom colors available.', 'description' => 'A serious presentation for bridge and inlet anglers who want a handmade jig with the right silhouette.', 'image' => null, 'status' => 'active', 'color' => 'from-white via-sky-200 to-blue-700', 'rating' => 5, 'specs' => ['Weight: Custom options', 'Colors: Made to order', 'Use: Bridges and passes', 'Build: Hand-tied']],
            ['name' => 'M&M Specialty Tackle Set', 'slug' => 'mm-specialty-tackle-set', 'price' => 34.00, 'sale_price' => null, 'stock' => 18, 'sku' => 'MM-SET-006', 'category_slug' => 'specialty-tackle', 'short_description' => 'A starter set of local favorites selected for Florida fishing.', 'description' => 'A curated set for anglers who want a practical spread of colors, weights, and profiles.', 'image' => null, 'status' => 'active', 'color' => 'from-sky-100 via-cyan-200 to-blue-950', 'rating' => 5, 'specs' => ['Includes: 5 pieces', 'Packaging: Ready to fish', 'Best for: Inshore variety', 'Custom: Available']],
            ['name' => 'Saltwater Hook Pack', 'slug' => 'saltwater-hook-pack', 'price' => 5.99, 'sale_price' => null, 'stock' => 75, 'sku' => 'MM-HOOK-007', 'category_slug' => 'fishing-accessories', 'short_description' => 'Reliable saltwater hooks for tackle box restocks and custom rigs.', 'description' => 'A simple accessory pack for keeping your saltwater setup ready.', 'image' => null, 'status' => 'active', 'color' => 'from-slate-100 via-white to-sky-300', 'rating' => 4, 'specs' => ['Pack: 10 count', 'Use: Saltwater rigs', 'Material: Corrosion-resistant', 'Size: Assorted']],
            ['name' => 'Custom Fishing Apparel', 'slug' => 'custom-fishing-apparel', 'price' => 24.00, 'sale_price' => null, 'stock' => 30, 'sku' => 'MM-APP-008', 'category_slug' => 'apparel', 'short_description' => 'Comfortable coastal apparel for anglers and M&M supporters.', 'description' => 'Lightweight everyday fishing apparel with clean branding for boat, beach, and dock.', 'image' => null, 'status' => 'active', 'color' => 'from-white via-sky-100 to-cyan-300', 'rating' => 4, 'specs' => ['Fit: Unisex', 'Material: Soft cotton blend', 'Sizes: S-XXL', 'Care: Machine washable']],
        ];
    }

    public static function testimonials(): array
    {
        return [
            ['name' => 'Chris D.', 'location' => 'Sarasota, FL', 'quote' => 'The snook jigs have the right weight and action around the bridges. You can tell they were made by someone who fishes here.'],
            ['name' => 'Angela R.', 'location' => 'Bradenton, FL', 'quote' => 'Great communication on a custom color order, and the finish held up after multiple saltwater trips.'],
            ['name' => 'Mike T.', 'location' => 'Venice, FL', 'quote' => 'The bucktail jigs swim clean and stay balanced. They earned a permanent spot in my tackle tray.'],
            ['name' => 'Derek S.', 'location' => 'Siesta Key, FL', 'quote' => 'I ordered a few surf jigs for pompano and they shipped quickly. Clean work and fair pricing.'],
            ['name' => 'Lauren M.', 'location' => 'Longboat Key, FL', 'quote' => 'Professional, friendly, and the custom tackle set made a great gift for my husband.'],
        ];
    }

    public static function blogPosts(): array
    {
        return [
            ['title' => 'Choosing the Right Jig for Saltwater Fishing', 'slug' => 'choosing-the-right-jig-for-saltwater-fishing', 'excerpt' => 'Match weight, profile, current, and target species before you tie on.', 'body' => 'The right jig starts with water depth, current, and the way your target species feeds. A compact jig is easier to control in moving water, while a larger profile can call attention in dirty water or low light.'],
            ['title' => 'Best Fishing Tackle for Sarasota Waters', 'slug' => 'best-fishing-tackle-for-sarasota-waters', 'excerpt' => 'A practical look at tackle choices for passes, grass flats, docks, and beaches.', 'body' => 'Sarasota anglers need versatile tackle that can handle bridges, grass edges, surf zones, and dock lights. Carry a spread of jig weights and colors so you can adjust quickly.'],
            ['title' => 'Why Handmade Tackle Matters', 'slug' => 'why-handmade-tackle-matters', 'excerpt' => 'Handmade tackle gives anglers better control over color, weight, and finish.', 'body' => 'Handmade tackle allows for thoughtful material choices, small-batch quality checks, and customization that mass-produced options often miss.'],
            ['title' => 'Tips for Snook Fishing in Florida', 'slug' => 'tips-for-snook-fishing-in-florida', 'excerpt' => 'Focus on structure, moving water, and quiet presentations for better snook results.', 'body' => 'Snook fishing rewards patience and precision. Fish moving water, use structure to your advantage, and choose tackle that keeps a natural profile in the strike zone.'],
        ];
    }

    public static function galleryItems(): array
    {
        return [
            ['title' => 'Blue Custom Jig Finish', 'category' => 'Custom Jigs', 'description' => 'Hand-tied blue and white coastal pattern.', 'color' => 'from-sky-200 to-blue-600'],
            ['title' => 'Fresh Jig Heads', 'category' => 'Jig Heads', 'description' => 'Clean powder-coated heads ready for packaging.', 'color' => 'from-cyan-100 to-sky-500'],
            ['title' => 'Customer Snook Catch', 'category' => 'Customer Photos', 'description' => 'Local catch using a custom snook jig.', 'color' => 'from-white to-cyan-400'],
            ['title' => 'Finished Bucktail Batch', 'category' => 'Finished Products', 'description' => 'A finished run of bucktail jigs.', 'color' => 'from-blue-100 to-slate-400'],
            ['title' => 'Pompano Surf Set', 'category' => 'Finished Products', 'description' => 'Compact surf jigs for beach fishing.', 'color' => 'from-cyan-50 to-amber-100'],
            ['title' => 'Special Color Request', 'category' => 'Custom Jigs', 'description' => 'Custom color blend for local conditions.', 'color' => 'from-sky-100 to-indigo-500'],
        ];
    }
}
