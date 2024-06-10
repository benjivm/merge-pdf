# Merge PDF

Personal project fork of the original [hanneskod/libmergepdf](https://github.com/hanneskod/libmergepdf) PHP library for merging multiple PDFs. Use at your own risk.

## Installation

```shell
composer require benjivm/merge-pdf
```

## Usage

Append the first ten pages of **bar.pdf** to **foo.pdf**:

```php
use Benjivm\MergePdf\Merger;
use Benjivm\MergePdf\Pages;

$merger = new Merger;
$merger->addFile('foo.pdf');
$merger->addFile('bar.pdf', new Pages('1-10'));
$createdPdf = $merger->merge();
```

Bulk add files from an iterator:

```php
use Benjivm\MergePdf\Merger;

$merger = new Merger;
$merger->addIterator(['A.pdf', 'B.pdf']);
$createdPdf = $merger->merge();
```

### Merging pdfs of version 1.5 and later

The default `FPDI` driver is not able handle compressed pdfs of version 1.5 or later.
Circumvent this limitation by using the slightly more experimental `TCPDI` driver.

```php
use Benjivm\MergePdf\Merger;
use Benjivm\MergePdf\Driver\TcpdiDriver;

$merger = new Merger(new TcpdiDriver);
```

### Using an immutable merger

Immutability may be achieved by using a `driver` directly.

```php
use Benjivm\MergePdf\Driver\Fpdi2Driver;
use Benjivm\MergePdf\Source\FileSource;
use Benjivm\MergePdf\Pages;

$merger = new Fpdi2Driver;

$createdPdf = $merger->merge(
    new FileSource('foo.pdf'),
    new FileSource('bar.pdf', new Pages('1-10'))
);
```

## Known issues

* Links and other content outside a page content stream is removed at merge.
  This is due to limitations in FPDI and not possible to resolve with the
  current strategy. For more information see [FPDI](https://www.setasign.com/support/faq/fpdi/after-importing-a-page-all-links-are-gone/#question-84).
* _TCPDI_ (as used in the _TcpdiDriver_ for merging pdfs with newer features)
  does not seem to be maintained. This makes mergeing fragile for certain kinds
  of files, and error messages are often all but helpful. This package will not
  be able to fix issues in _TCPDI_. The long term solution is to switch
  to a different backend. Suggestions are very welcomed!
