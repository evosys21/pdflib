git clone -b align-tcpdf https://gitlab-ci:B62H1Lg5bueTZwPbPhp2@gitlab.interpid.eu/interpid/fpdf-table fpdf2


```shell script
php ./bin/build_release.php
php .\docs\src\update-redmine-wiki.php
```

```shell script
git add * && git commit -am "Upgrade table 6.0.1 and multicell 3.0.1" && git push
```

```shell script
git.cc Documentation/Deploy Updates
git push --delete origin 6.2.1
git tag -a -f 6.2.1 -m "Release 6.2.1" && git push origin "6.2.1" -f

git push --delete origin 6.2.1 && git.cc Documentation/Deploy Updates && git tag -a -f 6.2.1 -m "Release 6.1.0" && git push origin "6.2.1" -f
```



/wp-content/uploads/pdf/example-multicell-1-overview.pdf

/wp-content/uploads/pdf/fpdf/example-multicell-1-overview.pdf
/wp-content/uploads/pdf/fpdf/example-table-1-overview.pdf
/wp-content/uploads/pdf/fpdf/example-table-2-overview.pdf

/wp-content/uploads/pdf/tcpdf/example-multicell-1-overview.pdf
/wp-content/uploads/pdf/tcpdf/example-table-1-overview.pdf
/wp-content/uploads/pdf/tcpdf/example-table-2-overview.pdf