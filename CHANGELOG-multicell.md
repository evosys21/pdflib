# Changelog for FPDF Advanced Multicell

All notable changes to FPDF Advanced Multicell  will be documented in this file.

<!---
## [Unreleased]
##X.Y.X (2019-01-01)
-->

### 3.0.0 [Unreleased]

- Change, use Fpdf library from composer: `coomposer require "setasign/fpdf"`
- Change, Add support for a tag `width` and `align` attributes
- Change, Implement Style Inheritance
- Change, Use single quotes in PHP code ([#1930](https://tracker.interpid.eu/issues/1930))
- Change, Provide as composer package ([#1929](https://tracker.interpid.eu/issues/1929))
- Change, `"ypos"` sub-superscript parameter is deprecated. Use `"y"` instead.

### 2.6.3 (2019-02-06)

- Change, Examples folder clean-up ([#1755](https://tracker.interpid.eu/issues/1755))

### 2.6.2 (2018-11-27)

- Fix, PHP 7.* deprecation issues - each() function is deprecated ([#1680](https://tracker.interpid.eu/issues/1680))

### 2.6.1 (2018-09-19)

- Fix, /vendor folder moved to /library (conflict with composer) ([#1681](https://tracker.interpid.eu/issues/1681))

### 2.6.0 (2018-08-28)

- Fix, Table vertical align not working ([#1202](https://tracker.interpid.eu/issues/1202))
- Change, Use array short-hands ([#1201](https://tracker.interpid.eu/issues/1201))
- Change, Implement Namespaces ([#1200](https://tracker.interpid.eu/issues/1200))
- Change, Remove Hungarian Notation ([#1199](https://tracker.interpid.eu/issues/1199))

### 2.5.1 (2017-08-29)

- Change, Update Fpdf Utf8 version to the latest version ([#1257](https://tracker.interpid.eu/issues/1257))
- Change, Unable to open saved PDF in Acrobat Reader ([#1043](https://tracker.interpid.eu/issues/1043))

### 2.5.0 (2016-09-12)

- Change, Upgrade to Tcpdf 6.2.13 (tcpdf) ([#947](https://tracker.interpid.eu/issues/947))
- Change, Code improvements ([#946](https://tracker.interpid.eu/issues/946))
- Change, Upgrade to FPDF 1.8 ([#945](https://tracker.interpid.eu/issues/945))
- Fix, PDF result differences between PHP5 and PHP7(fpdf) ([#944](https://tracker.interpid.eu/issues/944))
- Fix, Relative font size in MultiCell not working as expected ([#895](https://tracker.interpid.eu/issues/895))
- Fix, Addons don't work in PHP7 ([#828](https://tracker.interpid.eu/issues/828))

### 2.4.0 (2014-08-23)

- Support, Code Refactoring ([#689](https://tracker.interpid.eu/issues/690))

### 2.3.1 (2013-11-20)

- Fix, html character in table utf-8(tfpdf) ([#558](https://tracker.interpid.eu/issues/558))

### 2.3.0 (2013-11-11)

- Change, Transparent multicell ([#553](https://tracker.interpid.eu/issues/553))
- Backward compatibility(Version 2.2.*)
- The Advanced Multicell class is renamed to: PdfMulticell for all Pdf Addons.

### 2.2.0 (2012-10-12)

- Change, Code refactoring, structure changes, more examples

### 2.1.0 (2012-09-14)

- Change, line breaking characters can be changed programmatically
- Change, update of the licence agreement

### 2.0.4 (2012-03-12)

- Fix - AcceptPageBreak not checked before page-break execution

### 2.0.3 (2012-03-12)

- Change, Fpdf ws incorrect when writing the content to the pdf ([#284](https://tracker.interpid.eu/issues/284))
- Fix, Fpdf Table - Empty content generated(multiple pdf documents) ([#283](https://tracker.interpid.eu/issues/283))

### 2.0.0 (2012-01-14)

- Change, Make the MulticellTag Class independent from FPDF ([#258](https://tracker.interpid.eu/issues/258))

* {{issue_fields(258,-p,-c,tracker,-c,subject,status)}}
* no need to extend FPDF class anymore, the fpdf object will be passed as a parameter to the multicell class
* class names, filenames and functions are changed


##### Note 

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html)