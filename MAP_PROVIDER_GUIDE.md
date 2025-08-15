# Quick Start Guide: OpenStreetMap vs Google Maps

Pilihan map provider untuk sistem presensi karyawan dengan lokasi penempatan.

## 🚀 Quick Setup

### Option 1: Menggunakan OpenStreetMap (Gratis - Recommended)

```bash
# Set to OpenStreetMap
php artisan map:provider switch --provider=osm

# Verify configuration
php artisan map:provider status
```

### Option 2: Menggunakan Google Maps (Berbayar)

```bash
# Set Google Maps API key di .env
GOOGLE_MAPS_API_KEY=your_actual_api_key_here

# Set to Google Maps
php artisan map:provider switch --provider=google

# Verify configuration
php artisan map:provider status
```

## 📊 Comparison Table

| Feature                | OpenStreetMap          | Google Maps          |
| ---------------------- | ---------------------- | -------------------- |
| **Setup Time**         | ⚡ Instant (0 minutes) | ⏱️ 15-30 minutes     |
| **Cost**               | 🆓 Free forever        | 💰 Paid after quota  |
| **API Key**            | ❌ Not needed          | ✅ Required          |
| **Data Quality**       | 🌍 Community-driven    | 🏢 Commercial-grade  |
| **Accuracy**           | ⭐⭐⭐⭐ Good          | ⭐⭐⭐⭐⭐ Excellent |
| **Indonesia Coverage** | ✅ Very good           | ✅ Excellent         |
| **Search Quality**     | ⭐⭐⭐ Decent          | ⭐⭐⭐⭐⭐ Superior  |
| **Performance**        | 🚀 Fast                | 🚀 Fast              |
| **Privacy**            | 🔒 Privacy-friendly    | ⚠️ Google tracking   |

## 🔧 Management Commands

```bash
# Check current provider and status
php artisan map:provider status

# Switch to OpenStreetMap
php artisan map:provider switch --provider=osm

# Switch to Google Maps
php artisan map:provider switch --provider=google

# Interactive provider selection
php artisan map:provider switch

# Validate current configuration
php artisan map:provider validate
```

## 📍 Features Available

### ✅ Both Providers Support:

-   🗺️ Interactive map display
-   📍 Click-to-place location markers
-   🔄 Drag markers to reposition
-   🔍 Location search functionality
-   📐 Radius visualization for attendance area
-   🏠 Reverse geocoding (coordinates → address)
-   📱 Responsive design for mobile/desktop
-   🎯 Form validation and error handling

### 🎯 OpenStreetMap Specific Features:

-   🌍 Uses Nominatim for geocoding
-   🆓 No API quotas or limits
-   🔧 Fully customizable tile layers
-   📊 Community-driven data updates
-   🔒 No user tracking

### 🎯 Google Maps Specific Features:

-   🔍 Advanced Places API search
-   📍 More detailed business listings
-   🛣️ Street View integration potential
-   📊 Commercial-grade accuracy
-   🌐 Global coverage consistency

## 🖥️ User Interface

Both providers maintain the same UI/UX:

-   Consistent form layouts
-   Same button placements
-   Identical validation messages
-   Unified error handling

Only visual difference: Small badge showing active provider.

## ⚙️ Configuration

### Environment Variables:

```env
# Enable OpenStreetMap (default: false)
USE_OPENSTREETMAP=true

# Google Maps API Key (only if using Google Maps)
GOOGLE_MAPS_API_KEY=your_api_key_here
```

### Programmatic Detection:

```php
$serviceInfo = \App\Services\MapServiceFactory::getServiceInfo();
echo "Current provider: " . $serviceInfo['service'];
```

## 🎯 Recommendations

### 👍 Use OpenStreetMap When:

-   ✅ You want zero setup time
-   ✅ Budget is a primary concern
-   ✅ Privacy is important
-   ✅ Basic location needs (offices, buildings)
-   ✅ Internal company use
-   ✅ Want to avoid vendor lock-in

### 👍 Use Google Maps When:

-   ✅ Need highest accuracy possible
-   ✅ Advanced search capabilities required
-   ✅ Business-critical application
-   ✅ Customer-facing features
-   ✅ Budget allows for API costs
-   ✅ Integration with other Google services

## 🚀 Getting Started (Step by Step)

### For OpenStreetMap (5 minutes):

1. Run: `php artisan map:provider switch --provider=osm`
2. Run: `php artisan config:clear`
3. Visit: `/admin/lokasi-penempatan/create`
4. ✅ Done! Start adding locations

### For Google Maps (30 minutes):

1. Get API key from [Google Cloud Console](https://console.cloud.google.com/)
2. Enable Maps JavaScript API, Places API, Geocoding API
3. Add API key to `.env`: `GOOGLE_MAPS_API_KEY=your_key`
4. Run: `php artisan map:provider switch --provider=google`
5. Run: `php artisan config:clear`
6. Visit: `/admin/lokasi-penempatan/create`
7. ✅ Done!

## 🔍 Validation & Testing

```bash
# Check if everything is working
php artisan map:provider validate

# Expected output for OpenStreetMap:
✅ All configuration is valid!
📋 Configuration Details:
  • Map Service: OpenStreetMap
  • API Key Required: No
  • Search Provider: Nominatim
  • Cost: Free

# Expected output for Google Maps:
✅ All configuration is valid!
📋 Configuration Details:
  • Map Service: Google Maps
  • API Key Required: Yes
  • API Key Configured: Yes
  • Search Provider: Google Places API
  • Cost: Paid after quota
```

## 🎉 Final Recommendation

**For most Laravel applications, especially internal tools like employee attendance systems, OpenStreetMap is the recommended choice because:**

1. ⚡ **Zero setup time** - works immediately
2. 🆓 **Completely free** - no surprise bills
3. 🔒 **Privacy-friendly** - no tracking
4. ✅ **Good enough accuracy** for business locations
5. 🎯 **Perfect for Indonesia** - good coverage

**Switch to Google Maps only if you specifically need:**

-   Street View integration
-   Advanced business search
-   Maximum accuracy for customer-facing features

---

**Ready to start?** Run `php artisan map:provider switch --provider=osm` and begin adding locations in under 5 minutes! 🚀
