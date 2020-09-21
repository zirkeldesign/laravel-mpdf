# Laravel mPDF: Using mPDF in Laravel >= 5.x for generate Pdfs

> Easily generate PDF documents from HTML right inside of Laravel using this mpdf wrapper.

## Important Note

> Currently supported mpdf version `8.0` with FPDF version 2 and PHP version >= 7.0

## Installation

Require this package in your `composer.json`

```json
"require": {
	"carlos-meneses/laravel-mpdf": "2.1.3"
}
```

or install it by running:

```sh
composer require carlos-meneses/laravel-mpdf
```

To start using Laravel, add the Service Provider and the Facade to your `config/app.php`:

```php
'providers' => [
	// ...
	Meneses\LaravelMpdf\LaravelMpdfServiceProvider::class
]
```

```php
'aliases' => [
	// ...
	'PDF' => Meneses\LaravelMpdf\Facades\LaravelMpdf::class
]
```

## Basic Usage

To use Laravel mPDF add something like this to one of your controllers. You can pass data to a view in `/resources/views`.

```php
//....
use PDF;

class ReportController extends Controller
{
    public function generate_pdf()
    {
        $data = [
            'foo' => 'bar'
        ];
        $pdf = PDF::loadView('pdf.document', $data);
        return $pdf->stream('document.pdf');
    }
}
```

## Other methods

It is also possible to use the following methods on the `pdf` object:

-   `output()`: Outputs the PDF as a string.
-   `save($filename)`: Save the PDF to a file
-   `download($filename)`: Make the PDF downloadable by the user.
-   `stream($filename)`: Return a response with the PDF to show in the browser.

## Config

You can use a custom file to overwrite the default configuration. Just create `config/pdf.php` and add this:

```php
return [
	'mode'                    => '',
	'format'                  => 'A4',
	'default_font_size'       => '12',
	'default_font'            => 'sans-serif',
	'margin_left'             => 10,
	'margin_right'            => 10,
	'margin_top'              => 10,
	'margin_bottom'           => 10,
	'margin_header'           => 0,
	'margin_footer'           => 0,
	'orientation'             => 'P',
	'title'                   => 'Laravel mPDF',
	'author'                  => '',
	'watermark'               => '',
	'show_watermark'          => false,
	'watermark_font'          => 'sans-serif',
	'display_mode'            => 'fullpage',
	'watermark_text_alpha'    => 0.1,
	'custom_font_dir'         => '',
	'custom_font_data'        => [],
	'auto_language_detection' => false,
	'temp_dir'                => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
	'pdfa'                    => false,
	'pdfaauto'                => false,
];
```

To override this configuration on a per-file basis use the fourth parameter of the initializing call like this:

```php
PDF::loadView('pdf', $data, [], [
    'title' => 'Another Title',
    'margin_top' => 0
])->save($pdfFilePath);
```

You can use a callback with the key 'instanceConfigurator' to access mPDF functions:

```php
$config = ['instanceConfigurator' => function($mpdf) {
    $mpdf->SetImportUse();
    $mpdf->SetDocTemplate('/path/example.pdf', true);
}]

PDF::loadView('pdf', $data, [], $config)->save($pdfFilePath);
```

## Headers and Footers

If you want to have headers and footers that appear on every page, add them to your `<body>` tag like this:

```html
<htmlpageheader name="page-header">
    Your Header Content
</htmlpageheader>

<htmlpagefooter name="page-footer">
    Your Footer Content
</htmlpagefooter>
```

Now you just need to define them with the name attribute in your CSS:

```css
@page {
    header: page-header;
    footer: page-footer;
}
```

Inside of headers and footers `{PAGENO}` can be used to display the page number.

## Included Fonts

By default you can use all the fonts [shipped with mPDF](https://mpdf.github.io/fonts-languages/available-fonts-v6.html).

## Custom Fonts

You can use your own fonts in the generated PDFs. The TTF files have to be located in one folder, e.g. `resources/fonts/`. Add this to your configuration file (`/config/pdf.php`):

```php
return [
	'custom_font_dir' => base_path('resources/fonts/'), // don't forget the trailing slash!
	'custom_font_data' => [
		'examplefont' => [
			'R'  => 'ExampleFont-Regular.ttf',    // regular font
			'B'  => 'ExampleFont-Bold.ttf',       // optional: bold font
			'I'  => 'ExampleFont-Italic.ttf',     // optional: italic font
			'BI' => 'ExampleFont-Bold-Italic.ttf' // optional: bold-italic font
		]
		// ...add as many as you want.
	]
];
```

Now you can use the font in CSS:

```css
body {
    font-family: "examplefont", sans-serif;
}
```

## Get instance your mPDF

You can access all mpdf methods through the mpdf instance with `getMpdf()`.

```php
use PDF;

$pdf = PDF::loadView('pdf.document', $data);
$pdf->getMpdf()->AddPage(...);

```

## Set Protection

To set protection, you just call the `setProtection()` method and pass an array with permissions, an user password and an owner password. The passwords are optional.

There are a few permissions: `'copy'`, `'print'`, `'modify'`, `'annot-forms'`, `'fill-forms'`, `'extract'`, `'assemble'`, `'print-highres'`.

```php
use PDF;

function generate_pdf() {
    $data = [
        'foo' => 'bar'
    ];
    $pdf = PDF::loadView('pdf.document', $data);
    $pdf->setProtection(['copy', 'print'], '', 'pass');

    return $pdf->stream('document.pdf');
}
```

Find more information to `setProtection()` here: https://mpdf.github.io/reference/mpdf-functions/setprotection.html

## License

Laravel mPDF is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
