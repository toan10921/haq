# Nebon WordPress Theme

A modern, responsive WordPress theme built with performance and flexibility in mind. Nebon provides a comprehensive solution for e-commerce websites with WooCommerce integration and advanced customization options.

## 📋 Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Customization](#customization)
- [Elementor Widgets](#elementor-widgets)
- [WooCommerce Integration](#woocommerce-integration)
- [Development](#development)
- [Documentation](#documentation)
- [Support](#support)
- [Changelog](#changelog)
- [License](#license)

## ✨ Features

### Core Features
- **Responsive Design**: Mobile-first approach with flex box and grid system
- **Performance Optimized**: Fast loading times with optimized assets
- **SEO Ready**: Built with SEO best practices
- **Translation Ready**: Multi-language support with text domain 'nebon'
- **Accessibility**: WCAG compliant structure

### E-commerce Features
- **WooCommerce Integration**: Full WooCommerce support
- **Product Filtering**: AJAX-powered product filters
- **Custom Product Layouts**: Multiple product display options
- **Shopping Cart**: Enhanced mini cart functionality
- **Wishlist Support**: Built-in wishlist features

### Advanced Features
- **Elementor Integration**: 30+ custom Elementor widgets
- **Theme Customizer**: Extensive customization options
- **Custom Post Types**: Extended content management
- **AJAX Search**: Real-time search functionality
- **Icon Libraries**: Line Awesome icons included

## 🔧 Requirements

- **WordPress**: 5.0 or higher
- **PHP**: 7.4 or higher
- **MySQL**: 5.6 or higher
- **Memory Limit**: 128MB minimum (256MB recommended)

### Required Plugins
- **Elementor**: Page builder integration
- **WooCommerce**: E-commerce functionality (optional)

### Recommended Plugins
- **Yoast SEO**: Enhanced SEO features
- **Contact Form 7**: Contact forms
- **UpdraftPlus**: Backup solution

## 🚀 Installation

### Automatic Installation
1. Log in to your WordPress admin panel
2. Navigate to **Appearance > Themes**
3. Click **Add New**
4. Upload the `nebon.zip` file
5. Click **Install Now**
6. Activate the theme

### Manual Installation
1. Download the theme files
2. Extract to `/wp-content/themes/nebon/`
3. Activate via **Appearance > Themes**

### Demo Content Import
1. Install recommended plugins
2. Navigate to **Appearance > Import Demo Data**
3. Select demo content to import
4. Click **Import**

## ⚙️ Configuration

### Initial Setup
1. **Set Homepage**: Go to **Settings > Reading** and set a static front page
2. **Configure Menus**: Navigate to **Appearance > Menus** and assign menus to locations
3. **Customize Logo**: Upload your logo via **Appearance > Customize > Site Identity**
4. **Set Colors**: Configure brand colors in **Appearance > Customize > Colors**

### Theme Options
Access theme options via **Appearance > Customize**:

- **Site Identity**: Logo, site title, tagline
- **Colors**: Primary, secondary, accent colors
- **Typography**: Font families and sizes
- **Layout**: Container width, sidebar options
- **Header**: Header layout and styling
- **Footer**: Footer layout and content
- **Shop**: WooCommerce settings
- **Blog**: Blog layout options

## 🎨 Customization

### Custom CSS
Add custom CSS via:
- **Appearance > Customize > Additional CSS**
- Child theme `style.css`
- Custom CSS files in `/assets/css/custom/`

### Child Theme
Create a child theme for customizations:

```php
<?php
// functions.php in child theme
add_action('wp_enqueue_scripts', 'child_theme_styles');
function child_theme_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
}
```

### Custom Functions
Add custom functionality via child theme `functions.php` or custom plugin.

## 🧩 Elementor Widgets

Nebon includes 30+ custom Elementor widgets:

### Content Widgets
- **T888 Title**: Advanced heading widget
- **T888 Slider**: Responsive image slider
- **T888 Accordion**: Collapsible content sections
- **T888 Testimonial**: Customer testimonials
- **T888 Feature Box**: Service/feature highlights
- **T888 Quote Box**: Styled quote blocks
- **T888 Video**: Video embed with customization
- **T888 Team**: Team member profiles

### E-commerce Widgets
- **T888 Product Group**: Product collections
- **T888 Product Tabs**: Tabbed product displays
- **T888 Discount Products**: Sale products showcase
- **T888 Featured Categories**: Category highlights
- **T888 Hot Deals**: Limited time offers
- **T888 Feature Products**: Featured product grid
- **T888 List Product**: Custom product listings

### Navigation Widgets
- **T888 Menu**: Custom navigation menus
- **T888 Search Form**: AJAX search functionality
- **T888 Mini Cart**: Shopping cart display
- **T888 My Account**: User account links
- **T888 My Wishlist**: Wishlist functionality

### Utility Widgets
- **T888 Button**: Custom styled buttons
- **T888 Social List**: Social media links
- **T888 Phone**: Contact information
- **T888 Logo**: Brand logo display

## 🛒 WooCommerce Integration

### Product Pages
- Custom product page layouts
- Product image galleries
- Related products
- Product tabs customization
- Review system integration

### Shop Pages
- Product filtering (AJAX)
- Custom product layouts
- Pagination options
- Sorting functionality
- Category navigation

### Cart & Checkout
- Enhanced cart page
- Streamlined checkout
- Payment gateway integration
- Order tracking

### Account Pages
- Custom account dashboard
- Order history
- Wishlist integration
- Address management

## 🔧 Development

### File Structure
```
nebon/
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
├── core/
│   ├── class/
│   ├── customizer/
│   ├── elementor-widget/
│   └── function/
├── template-parts/
├── woocommerce/
├── functions.php
├── style.css
└── README.md
```

### Build Process
```bash
# Install dependencies
npm install

# Development build
npm run dev

# Production build
npm run build

# Watch for changes
npm run watch
```

### PHP Documentation
Generate PHP documentation:
```bash
php bin/phpdoc -d /path/to/theme -t /path/to/docs
```

### Coding Standards
- Follow WordPress Coding Standards
- Use PSR-4 autoloading for classes
- Implement proper sanitization and validation
- Add proper documentation for all functions

## 📚 Documentation

### Online Documentation
- [Theme Documentation](https://7uptheme.net)
- [Video Tutorials](https://forum.7uptheme.net)
- [FAQ](https://forum.7uptheme.net/faq)

### Developer Resources
- [Hooks Reference](docs/hooks.md)
- [Filters Reference](docs/filters.md)
- [Custom Post Types](docs/post-types.md)
- [API Documentation](docs/api.md)

### Dependencies
- **Customizer Repeater**: [cristian-ungureanu/customizer-repeater](https://github.com/cristian-ungureanu/customizer-repeater)
- **Color Picker Alpha**: [kallookoo/wp-color-picker-alpha](https://github.com/kallookoo/wp-color-picker-alpha)

## 🆘 Support

### Getting Help
- **Documentation**: Check the online documentation first
- **Community Forum**: Join our community forum for discussions
- **Support Tickets**: Submit support tickets for technical issues
- **Email Support**: contact@example.com

### Bug Reports
Please report bugs via GitHub Issues:
1. Check existing issues first
2. Provide detailed description
3. Include steps to reproduce
4. Add screenshots if applicable

### Feature Requests
Submit feature requests through:
- GitHub Issues (feature request template)
- Community forum discussions
- Support tickets

## 📝 Changelog

### Version 2.1.0 (Latest)
- **Added**: New Elementor widgets
- **Added**: Enhanced AJAX filtering
- **Improved**: Performance optimizations
- **Fixed**: Minor CSS issues
- **Updated**: Translation files

### Version 2.0.0
- **Added**: Elementor integration
- **Added**: WooCommerce enhancements
- **Improved**: Mobile responsiveness
- **Fixed**: Cross-browser compatibility

### Version 1.5.0
- **Added**: Theme customizer options
- **Added**: Custom post types
- **Improved**: SEO optimization
- **Fixed**: Security vulnerabilities

[View Full Changelog](CHANGELOG.md)

## 📄 License

This theme is licensed under the GNU General Public License v2 or later.

### Credits
- **Framework**: WordPress
- **Icons**: Line Awesome
- **Fonts**: Google Fonts
- **Images**: Unsplash (demo content)

### Third-Party Libraries
- Bootstrap Grid System
- jQuery
- Swiper.js (for sliders)
- Select2 (for enhanced selects)

## 🤝 Contributing

We welcome contributions! Please read our [Contributing Guidelines](CONTRIBUTING.md) before submitting pull requests.

### Development Setup
1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

---

**Made with ❤️ by [7up Theme]**

For more information, visit our [website](https://7uptheme.net) or follow us on [Twitter](https://x.com/7uptheme.net).