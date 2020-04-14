git clone -b align-tcpdf https://gitlab-ci:B62H1Lg5bueTZwPbPhp2@gitlab.interpid.eu/interpid/fpdf-table fpdf2


```shell script
php ./bin/build_release.php
php ./docs/src/wiki-pages.php
```

```shell script
git.cc Documentation/Deploy Updates
git push --delete origin 6.0.0
git tag -a -f 6.0.0 -m "Release 6.0.0" && git push origin "6.0.0" -f

git push --delete origin 6.0.0 && git.cc Documentation/Deploy Updates && git tag -a -f 6.0.0 -m "Release 6.0.0" && git push origin "6.0.0" -f
```



/wp-content/uploads/pdf/example-multicell-1-overview.pdf

/wp-content/uploads/pdf/fpdf/example-multicell-1-overview.pdf
/wp-content/uploads/pdf/fpdf/example-table-1-overview.pdf
/wp-content/uploads/pdf/fpdf/example-table-2-overview.pdf

/wp-content/uploads/pdf/tcpdf/example-multicell-1-overview.pdf
/wp-content/uploads/pdf/tcpdf/example-table-1-overview.pdf
/wp-content/uploads/pdf/tcpdf/example-table-2-overview.pdf