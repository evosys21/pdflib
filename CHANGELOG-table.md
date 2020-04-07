# Changelog for FPDF Advanced Table

All notable changes to FPDF Advanced Table will be documented in this file.

<!---
## [Unreleased]
##X.Y.X (2019-01-01)
-->

### 6.0.0 [Unreleased]

- Change, use Fpdf library from composer: `coomposer require "setasign/fpdf"`
- Change, Implement Style Inheritance
- Change, Use Single Quotes in code ([#1930](https://tracker.interpid.eu/issues/1930))
- Change, Provide as composer package ([#1929](https://tracker.interpid.eu/issues/1929))
- Change, Integrate Advanced Multicell Version 3.0.0

### 5.4.5 (2019-06-07)

- Fix, PHP 7.3 compatibility ([#1840](https://tracker.interpid.eu/issues/1840))

### 5.4.4 (2019-02-06)

- Change, Examples folder clean-up([#1755](https://tracker.interpid.eu/issues/1755))

### 5.4.3 (2018-12-30)

- Change, Version update for version compatibility with TCPDF AddOns

### 5.4.2 (2018-11-27)

- Fix, PHP 7.* deprecation issues ([#1680](https://tracker.interpid.eu/issues/1680))

### 5.4.1 (2018-09-19)

- Fix, /vendor folder moved to /library (conflict with composer) ([#1681](https://tracker.interpid.eu/issues/1681))

### 5.4.0 (2018-08-28)

- Fix, Table vertical align not working ([#1202](https://tracker.interpid.eu/issues/1202))
- Change, Use array short-hands ([#1201](https://tracker.interpid.eu/issues/1201))
- Change, Implement Namespaces ([#1200](https://tracker.interpid.eu/issues/1200))
- Change, Remove Hungarian Notation ([#1199](https://tracker.interpid.eu/issues/1199))

### 4.3.1 (2017-08-29)

- Change, Update Fpdf Utf8 version to the latest version ([#1234](https://tracker.interpid.eu/issues/1234))
- Change, Unable to open saved PDF in Acrobat Reader ([#1234](https://tracker.interpid.eu/issues/1234))

### 4.3.0 (2016-09-12)

- Change, Code improvements ([#946](https://tracker.interpid.eu/issues/946))
- Change, Upgrade to FPDF 1.8 ([#945](https://tracker.interpid.eu/issues/945))
- Fix, PDF result differences between PHP5 and PHP7(fpdf) ([#944](https://tracker.interpid.eu/issues/944))
- Fix, Passing TABLE_ALIGN to setTableConfig does not work ([#896](https://tracker.interpid.eu/issues/896))
- Fix, Relative font size in MultiCell not working as expected ([#895](https://tracker.interpid.eu/issues/895))
- Fix, Addons don't work in PHP7 ([#828](https://tracker.interpid.eu/issues/828))

### 4.2.0 (2015-08-23)

- Change, FPDF Addons - Add support for ISO encoding  ([#804](https://tracker.interpid.eu/issues/804))

### 4.1.0 (2014-08-23)

- Change, SVG Images support for tables - ONLY for Tcpdf ([#690](https://tracker.interpid.eu/issues/690))
- Change, Code Refactoring ([#689](https://tracker.interpid.eu/issues/689))
- Change, Disable page-break of a table ([#608](https://tracker.interpid.eu/issues/608))

### 4.0.1 (2013-11-20)

- Fix, html character in table utf-8(tfpdf) ([#558](https://tracker.interpid.eu/issues/558))

### 4.0.0 (2013-11-11)

- Change, Transparent tables ([#555](https://tracker.interpid.eu/issues/555))
- Change, Images support for tables ([#552](https://tracker.interpid.eu/issues/552))
- Change, Use the same versions for Advanced Table classes
- Change, Backward compatibility(Version 4.*.*)
- The Advanced Table class is renamed to: PdfTable for all Pdf Addons

### 4.2.0 (2012-10-12)

- code refactoring, structure changes, more examples

### 4.1.0 (2012-09-14)

- Version update due to multicell version changes, update of the licence agreement

### 4.0.5 (2012-08-02)

- Fix - errors displayed and wrong table alignment in case the table was started and it's not enough space on the current page.

### 4.0.4 (2012-05-21)

- Version update due to multicell version changes.

### 4.0.3 (2012-03-12)

- Fix, Empty content generated(multiple pdf documents)


##### Note 

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html)
